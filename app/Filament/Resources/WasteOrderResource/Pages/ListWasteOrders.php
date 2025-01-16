<?php

namespace App\Filament\Resources\WasteOrderResource\Pages;

use App\Filament\Resources\WasteOrderResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListWasteOrders extends ListRecords
{
    protected static string $resource = WasteOrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
