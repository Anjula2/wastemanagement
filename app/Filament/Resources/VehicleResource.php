<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VehicleResource\Pages;
use App\Filament\Resources\VehicleResource\RelationManagers;
use App\Models\Vehicle;
use App\Filament\Exports\VehicleExporter;
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

class VehicleResource extends Resource
{
    protected static ?string $model = Vehicle::class;

    protected static ?string $navigationIcon = 'heroicon-o-truck';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('vehicle_no')
                ->label('Vehicle No')
                ->unique(ignorable: fn ($record) => $record)
                ->required(),
            Forms\Components\Select::make('type')
                ->label('Type')
                ->options([
                    'Tractor' => 'Tractor',
                    'Compactor Truck' => 'Compactor Truck',
                    'Dump Truck' => 'Dump Truck',
                ])
                ->default('Tractor')
                ->required(),
            Forms\Components\DatePicker::make('date')
                ->label('Date of joining the service')
                ->maxDate(today())
                ->default(now())
                ->required(),
            Forms\Components\Toggle::make('is_available')
                ->label('Is Available')
                ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('vehicle_no')->label('Vehicle No'),
                Tables\Columns\TextColumn::make('type')
                ->label('Type'),
                Tables\Columns\TextColumn::make('date')
                      ->label('Date of joining the service')
                      ->dateTime('Y-m-d'),
                Tables\Columns\TextColumn::make('status'),
                Tables\Columns\BooleanColumn::make('is_available')
                      ->label('Availability')
                      ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\Action::make('Available')->label('Available')
                    ->action(function ($record) {
                        $record->update(['is_available' => true]);
                        Notification::make()
                            ->success()
                            ->title('Vehicle is Available')
                            ->send();
                    })
                    ->requiresConfirmation()
                    ->color('success')
                    ->icon('heroicon-o-check'),
                Tables\Actions\Action::make('Under Maintenance')->label('Under Maintenance')
                    ->action(function ($record) {
                        $record->update(['is_available' => false]);
                        Notification::make()
                            ->danger()
                            ->title('Vehicle is Under Maintenance')
                            ->send();
                    })
                    ->requiresConfirmation()
                    ->color('danger')
                    ->icon('heroicon-o-wrench-screwdriver'),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->headerActions([
                ExportAction::make()->exporter(VehicleExporter::class),
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
            'index' => Pages\ListVehicles::route('/'),
            'create' => Pages\CreateVehicle::route('/create'),
            'edit' => Pages\EditVehicle::route('/{record}/edit'),
        ];
    }
}
