<?php
/**
 * Created by PhpStorm.
 * User: Laptop
 * Date: 19.7.2017 г.
 * Time: 11:13 ч.
 */

namespace Chatty\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Status extends Model
{
    protected $table = 'statuses';

    protected $fillable = [
        'body',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo('Chatty\Models\User', 'user_id');
    }

    public function scopeNotReply($query)
    {
        return $query->whereNull('parent_id');
    }

    public function replies()
    {
        return $this->hasMany('Chatty\Models\Status', 'parent_id');
    }

    public function likes()
    {
        return $this->morphMany('Chatty\Models\Like', 'likeable');
    }

    public function likedLikes()
    {
        //dd($this->reacts()->where('like_type' == 1));
        //dd($this->likes());
       // DB::enableQueryLog();

        return  $this->likes()->where('like_type', 1)->count();
        //dd(DB::getQueryLog());
    }

}