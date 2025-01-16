<?php

namespace App\Filament\Resources\SellableWasteResource\Pages;

use App\Filament\Resources\SellableWasteResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSellableWastes extends ListRecords
{
    protected static string $resource = SellableWasteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
