<?php

namespace App\Filament\Resources\WasteCollectingScheduleResource\Pages;

use App\Filament\Resources\WasteCollectingScheduleResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListWasteCollectingSchedules extends ListRecords
{
    protected static string $resource = WasteCollectingScheduleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
