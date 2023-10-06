<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'appointment_date',
        'name',
        'phone_number'
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}