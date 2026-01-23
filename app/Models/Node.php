<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Node extends Model
{
    protected $fillable = [
        'family_id',
        'data',
        'biography',
        'avatar',
        'birthday',
        'label',
    ];
}
