<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
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

    protected $appends = ['type'];

    protected function type(): Attribute
    {
        return Attribute::make(
            get: fn () => 'person',
        );
    }

}
