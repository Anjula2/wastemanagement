<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SellableWasteResource\Pages;
use App\Filament\Resources\SellableWasteResource\RelationManagers;
use App\Models\SellableWaste;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SellableWasteResource extends Resource
{
    protected static ?string $model = SellableWaste::class;

    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('waste_type_id')
                ->label('Waste Type ID')
                ->unique(ignorable: fn ($record) => $record)
                ->required()
                ->placeholder('Enter a unique waste type ID'),
                Forms\Components\Select::make('waste_type')
                ->required()
                ->label('Waste Type')
                ->options([
                    'Low-Density Polyethylene (LDPE)' => 'Low-Density Polyethylene (LDPE)',
                    'Polypropylene (PP)' => 'Polypropylene (PP)',
                    'Polystyrene (PS)' => 'Polystyrene (PS)',
                    'Polyethylene Terephthalate (PET or PETE)' => 'Polyethylene Terephthalate (PET or PETE)',
                    'High-Density Polyethylene (HDPE)' => 'High-Density Polyethylene (HDPE)',
                    'Polypropylene (PP)' => 'Polypropylene (PP)',
                ]),
                Forms\Components\TextInput::make('stock_level')
                ->label('Stock Level (in Tons)')
                ->numeric()
                ->minValue(0)
                ->required()
                ->placeholder('Enter the stock level in tons'),
                Forms\Components\TextInput::make('price')
                ->label('Price (Per Ton in Rs.)')
                ->numeric()
                ->minValue(1)
                ->required()
                ->placeholder('Enter the price per ton'),
                Forms\Components\Textarea::make('description')
                ->label('Description')
                ->nullable()
                ->rows(3)
                ->placeholder('Provide additional details about the waste (optional)'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('waste_type_id')
                ->label('Waste Type ID')
                ->sortable()
                ->searchable(),
                Tables\Columns\TextColumn::make('waste_type')
                ->label('Waste Type')
                ->sortable()
                ->searchable(),
                Tables\Columns\BadgeColumn::make('stock_level')
                ->label('Stock Level (Tons)')
                ->sortable()
                ->color(function ($record) {
                    if ($record->stock_level > 50) return 'success';
                    if ($record->stock_level > 10) return 'warning';
                    return 'danger';
                }),
                Tables\Columns\TextColumn::make('price')
                ->label('Price (Rs.)')
                ->sortable()
                ->formatStateUsing(fn (string $state): string => 'Rs. ' . number_format($state, 2)),
                Tables\Columns\TextColumn::make('description')
                ->label('Description')
                ->limit(50),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSellableWastes::route('/'),
            'create' => Pages\CreateSellableWaste::route('/create'),
            'edit' => Pages\EditSellableWaste::route('/{record}/edit'),
        ];
    }
}
