<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;
    protected $table = 'tickets';

    


    protected $fillable = [
        'flight_id',
        'passanger_name',
        'passanger_phone',
        'seat_number',
        'is_boarding',
        'boarding_time',
    ];

    public function flight()
    {
        return $this->belongsTo(Flight::class);
    }
}
