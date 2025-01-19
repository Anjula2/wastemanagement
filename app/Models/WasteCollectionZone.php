<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WasteCollectionZone extends Model
{
    protected $fillable = [
        'zone_id',
        'zone_name',
        'areas', // JSON field
    ];

    protected $casts = [
        'areas' => 'array',
    ];

    public function wasteCollectingSchedules()
{
    return $this->hasMany(WasteCollectingSchedule::class, 'waste_collection_zone_id');
}
}
