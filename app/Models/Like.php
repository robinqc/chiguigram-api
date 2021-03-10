<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphPivot;

class Like extends MorphPivot
{
    use HasFactory;
    protected $table = 'likes';

    protected $fillable = [
        'post_id',
        'user_id'
    ];
}
