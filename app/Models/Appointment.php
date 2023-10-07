<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'hour',
        'name',
        'phone_number'
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public static function getFreeHoursForService($date, $serviceId)
    {
        $startTime = 10;
        $endTime = 18;

        $busyHours = self::where('date', $date)
            ->where('service_id', $serviceId)
            ->pluck('hour')
            ->toArray();

        $freeHours = [];

        for ($hour = $startTime; $hour <= $endTime; $hour++) {
            if (!in_array($hour, $busyHours)) {
                $freeHours[] = $hour;
            }
        }

        return $freeHours;
    }
}