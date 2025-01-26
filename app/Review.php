<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'content',
        'recommend',
    ];

    // Связь с пользователем
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
