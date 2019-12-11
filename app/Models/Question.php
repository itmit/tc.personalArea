<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $table = 'questions';

    protected $guarded = ['id'];

    public function place()
    {
        return $this->belongsTo(Place::class, 'place');
    }
}
