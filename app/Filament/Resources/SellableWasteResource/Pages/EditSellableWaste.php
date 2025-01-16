<?php

namespace App\Filament\Resources\SellableWasteResource\Pages;

use App\Filament\Resources\SellableWasteResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSellableWaste extends EditRecord
{
    protected static string $resource = SellableWasteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
