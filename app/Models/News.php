<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'head',
        'body',
        'picture',
    ];

    /**
     * @var string
     */
    protected $table = 'news';
}
