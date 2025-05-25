<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Platform extends Model
{
    use HasFactory;
    protected $guraded = [
        'id',
        'created_at'
    ];


    function posts()
    {
        return $this->belongsToMany(Post::class, 'post_platform')->withPivot('platform_status');
    }

    function user()
    {
        return $this->belongsToMany(User::class, 'user_platform');
    }

    function isPlatfromEnabled()
    {
        return $this->user()->where('user_id', auth()->id())->exists();
    }
}