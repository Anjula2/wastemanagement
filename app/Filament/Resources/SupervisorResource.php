<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SupervisorResource\Pages;
use App\Filament\Resources\SupervisorResource\RelationManagers;
use App\Models\Supervisor;
use App\Filament\Exports\SupervisorExporter;
use App\Models\WasteCollectionZone;
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

class SupervisorResource extends Resource
{
    protected static ?string $model = Supervisor::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-check';

    public static function form(Form $form): Form
    {
        return $form
    ->schema([
        Forms\Components\TextInput::make('supervisor_id')
            ->label('Supervisor ID')
            ->unique(ignorable: fn ($record) => $record)
            ->required()
            ->maxLength(255),
        
        Forms\Components\Select::make('zone_id')
            ->label('Zone')
            ->options(WasteCollectionZone::whereNotNull('zone_name')->pluck('zone_name', 'id')) 
            ->required(),
        
        Forms\Components\TextInput::make('name')
            ->label('Name')
            ->required()
            ->maxLength(255),
        
        Forms\Components\TextInput::make('phone')
            ->label('Phone Number')
            ->tel() 
            ->required()
            ->maxLength(15),
        
        Forms\Components\TextInput::make('nic_no')
            ->label('NIC Number')
            ->required()
            ->maxLength(12),
        
        Forms\Components\TextInput::make('address')
            ->label('Address')
            ->required()
            ->maxLength(255),
        
        Forms\Components\DatePicker::make('date')
            ->label('Joining Date')
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
        Tables\Columns\TextColumn::make('supervisor_id')
            ->label('Supervisor ID')
            ->sortable()
            ->searchable(),

        Tables\Columns\TextColumn::make('zone_id')
            ->label('Zone')
            ->sortable()
            ->searchable(),

        Tables\Columns\TextColumn::make('name')
            ->label('Name')
            ->sortable()
            ->searchable(),

        Tables\Columns\TextColumn::make('phone')
            ->label('Phone Number')
            ->sortable()
            ->searchable(),

        Tables\Columns\TextColumn::make('nic_no')
            ->label('NIC Number')
            ->sortable()
            ->searchable(),

        Tables\Columns\TextColumn::make('address')
            ->label('Address')
            ->wrap()
            ->sortable(),

        Tables\Columns\TextColumn::make('date')
            ->label('Joined Date')
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
                            ->title('Driver is Available')
                            ->send();
                    })
                    ->requiresConfirmation()
                    ->color('success')
                    ->icon('heroicon-o-check'),
                Tables\Actions\Action::make('Unavailable')->label('Unavailable')
                    ->action(function ($record) {
                        $record->update(['is_available' => false]);
                        Notification::make()
                            ->danger()
                            ->title('Driver is Unavailable')
                            ->send();
                    })
                    ->requiresConfirmation()
                    ->color('danger')
                    ->icon('heroicon-o-x-mark'),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->headerActions([
                ExportAction::make()->exporter(SupervisorExporter::class),
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
            'index' => Pages\ListSupervisors::route('/'),
            'create' => Pages\CreateSupervisor::route('/create'),
            'edit' => Pages\EditSupervisor::route('/{record}/edit'),
        ];
    }
}
