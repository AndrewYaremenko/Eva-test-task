<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_id',
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
        $startTime = '10:00';
        $endTime = '18:00';

        $busyHours = self::where('date', $date)
            ->where('service_id', $serviceId)
            ->pluck('hour')
            ->toArray();

        $freeHours = [];

        $currentHour = $startTime;
        while ($currentHour <= $endTime) {
            if (!in_array($currentHour, $busyHours)) {
                $freeHours[] = $currentHour;
            }

            $currentHour = date('H:i', strtotime($currentHour . ' +30 minutes'));
        }

        return $freeHours;
    }
}