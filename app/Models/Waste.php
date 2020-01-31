<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Waste extends Model
{
     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'wastes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    public function place()
    {
        return $this->belongsTo(Place::class, 'place');
    }
}
