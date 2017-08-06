<?php

namespace Chatty\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'email', 'password','first_name','last_name','location',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getName()
    {
        if($this->first_name && $this->last_name){
            return "{$this->first_name} {$this->last_name}";
        }

        if($this->first_name){
            return $this->first_name;
        }

        return null;
    }

    public function getNameOrUsername()
    {
        return $this->getName() ?: $this->username;
    }

    public function  getFirstNameOrUsername()
    {
        return $this->first_name ?: $this->username;
    }

    public function getNameOrPronoun($pronoun = 'You',$suffix)
    {
        return $this->id === Auth::user()->id ? $pronoun : $this->getNameOrUsername() . $suffix;
    }

    public function getAvatarUrl($default = "mm",$size=40)
    {
        return "https://www.gravatar.com/avatar/" . md5( strtolower( trim( $this->email ) ) ) . "?d=" . urlencode( $default ) . "&s=" . $size;
    }

    public function statuses()
    {
        return $this->hasMany('Chatty\Models\Status', 'user_id');
    }

    public function likes()
    {
        return $this->hasMany('Chatty\Models\Like', 'user_id');
    }
    public function friendsOfMine()
    {
        return $this->belongsToMany('Chatty\Models\User', 'friends',
            'user_id', 'friend_id')->withPivot('accepted');
    }

    public function friendOf()
    {
        return $this->belongsToMany('Chatty\Models\User', 'friends',
            'friend_id', 'user_id')->withPivot('accepted');
    }

    public function friends()
    {
        return $this->friendsOfMine()
            ->wherePivot('accepted', true)
            ->get()
            ->merge($this->friendOf()
                ->where('accepted', true)
                ->get());
    }

    public function friendRequests()
    {
        return $this->friendsOfMine()->wherePivot('accepted',false)->get();
    }

    public function friendRequestsPending()
    {
        return $this->friendOf()->wherePivot('accepted', false)->get();
    }

    public function hasFriendRequestPending(User $user)
    {
        return (bool) $this->friendRequestsPending()->where('id', $user->id)
            ->count();
    }

    public function hasFriendRequestReceived(User $user)
    {
        return (bool) $this->friendRequests()->where('id',$user->id)->count();
    }

    public function addFriend(User $user)
    {
        $this->friendOf()->attach($user->id);
    }

    public function deleteFriend(User $user)
    {
        $this->friendsOfMine()->detach($user->id);
    }

    public function acceptFriendRequest(User $user)
    {
        $this->friendRequests()->where('id', $user->id)->first()
            ->pivot->update(['accepted' => true]);
    }

    public function isFriendsWith(User $user)
    {
        return (bool) $this->friends()->where('id', $user->id)->count();
    }

    public function isAuthProfile()
    {
        return $this->id === Auth::user()->id;
    }

    public function hasReactedToStatus(Status $status)
    {
        return (bool) $status->likes
            ->where('user_id', $this->id)
            ->count();
    }

    public function hasLikedStatus(Status $status)
    {
         return (bool) $status->likes()
            ->where([
                ['user_id', Auth::user()->id],
                ['like_type', 1]
            ])
            ->count();
    }

    public function getUserStatusLike(Status $status)
    {
        return $status->likes()
            ->where('user_id', Auth::user()->id)
            ->first();
    }
}
