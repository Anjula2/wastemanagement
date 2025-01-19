<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WasteCollectingSchedule extends Model
{
    protected $fillable = [
        'schedule_id',
        'date',
        'start_time', 
        'end_time',
        'waste_collection_zone_id',
        'waste_type',


    ];

    public function wasteCollectionZone()
   {
      return $this->belongsTo(WasteCollectionZone::class);
   }
}
