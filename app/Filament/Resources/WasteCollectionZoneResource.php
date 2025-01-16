<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WasteCollectionZoneResource\Pages;
use App\Filament\Resources\WasteCollectionZoneResource\RelationManagers;
use App\Models\WasteCollectionZone;
use App\Filament\Exports\WasteCollectionZoneExporter;
use Filament\Notifications\Notification;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Actions\ExportAction;
use Illuminate\Notifications\Notifiable;

class WasteCollectionZoneResource extends Resource
{
    protected static ?string $model = WasteCollectionZone::class;

    protected static ?string $navigationIcon = 'heroicon-o-home-modern';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('zone_id')
                ->label('Zone Id')
                ->unique(ignorable: fn ($record) => $record)
                ->required(),
                Forms\Components\TextInput::make('zone_name')
                    ->label('Zone Name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Repeater::make('areas')
                    ->label('Areas')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Area Name')
                            ->required()
                            ->maxLength(255),
                    ])
                    ->minItems(1)
                    ->createItemButtonLabel('Add Area')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
            Tables\Columns\TextColumn::make('zone_id')
                ->label('Zone Id')
                ->sortable()
                ->searchable(),      
            Tables\Columns\TextColumn::make('zone_name')
                ->label('Zone Name')
                ->sortable()
                ->searchable(), 
            Tables\Columns\BadgeColumn::make('areas')
            ->label('Areas')
            ->sortable()
            ->searchable()
            ->formatStateUsing(fn ($state) => is_array($state) 
                ? implode(', ', $state)
                : implode(', ', json_decode($state, true))
            )
            ])
            ->filters([
                //
            ])
            ->headerActions([
                ExportAction::make()->exporter(WasteCollectionZoneExporter::class),
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
            'index' => Pages\ListWasteCollectionZones::route('/'),
            'create' => Pages\CreateWasteCollectionZone::route('/create'),
            'edit' => Pages\EditWasteCollectionZone::route('/{record}/edit'),
        ];
    }
}
