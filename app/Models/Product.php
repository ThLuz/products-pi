<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'external_id',
        'title',
        'price',
        'description',
        'category',
        'image',
        'rating_rate',
        'rating_count',
        'update_log'
    ];

    protected $casts = [
        'update_log' => 'array'
    ];
}