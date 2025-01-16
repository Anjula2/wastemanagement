<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkShift extends Model
{
    protected $table = 'work_shifts';

    protected $fillable = [
        'worker_ids',
        'driver_id',
        'supervisor_id',
        'vehicle_id',
        'waste_collection_zone_id',
        'shift_type',
        'shift_start',
        'shift_end',
    ];

    protected $casts = [
        'worker_ids' => 'array', 
    ];

    public function worker()
    {
        return $this->belongsTo(Worker::class);
    }

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }

    public function supervisor()
    {
        return $this->belongsTo(Supervisor::class);
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function wasteCollectionZone()
    {
        return $this->belongsTo(WasteCollectionZone::class);
    }
}
