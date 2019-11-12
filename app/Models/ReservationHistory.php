<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReservationHistory extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'reservation_histories';

    protected $guarded = ['id'];

    public function action()
    {
        return $this->belongsTo(Actions::class, 'action')->get();
    }

    public function lastAction()
    {
        return $this->belongsTo(Actions::class, 'action')->latest()->first();
    }
}
