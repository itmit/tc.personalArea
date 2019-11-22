<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Reservation extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'reservation';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    protected $dates = ['expires_at'];

    /**
     * @return User
     */
    public function place()
    {
        return $this->belongsTo(Place::class, 'place_id')->get()->first();
    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'client')->get()->first();
    }

    public function history()
    {
        return $this->hasOne(ReservationHistory::class, 'id')->latest()->first();
    }
}