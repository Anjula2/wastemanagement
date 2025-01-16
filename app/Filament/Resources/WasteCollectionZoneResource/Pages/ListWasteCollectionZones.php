<?php

namespace App\Filament\Resources\WasteCollectionZoneResource\Pages;

use App\Filament\Resources\WasteCollectionZoneResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListWasteCollectionZones extends ListRecords
{
    protected static string $resource = WasteCollectionZoneResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
