<?php

namespace App\Filament\Resources\WasteCollectingScheduleResource\Pages;

use App\Filament\Resources\WasteCollectingScheduleResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditWasteCollectingSchedule extends EditRecord
{
    protected static string $resource = WasteCollectingScheduleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
