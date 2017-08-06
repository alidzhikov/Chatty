<?php

namespace Chatty\Models;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    protected $table = 'likeable';

    protected $fillable = [
        'user_id',
        'like_type',
    ];

    public function likeable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo('Chatty\Models\User', 'user_id');
    }
}