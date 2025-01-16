<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ComplaintResource\Pages;
use App\Models\Complaint;
use App\Filament\Exports\ComplaintExporter;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\FileUpload;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\ExportAction;
use Illuminate\Notifications\Notifiable;

class ComplaintResource extends Resource
{
    protected static ?string $model = Complaint::class;

    protected static ?string $navigationIcon = 'heroicon-o-envelope';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->label('User')
                    ->options(User::all()->pluck('name', 'id')) 
                    ->required()
                    ->searchable(),
                Forms\Components\Select::make('category')
                    ->required()
                    ->label('Category')
                    ->options([
                        'Garbage Collection Delay' => 'Garbage Collection Delay',
                        'Illegal Dumping' => 'Illegal Dumping',
                        'Recycling Query' => 'Recycling Query',
                        'Noise/Odor Issues' => 'Noise/Odor Issues',
                        'Other' => 'Other',
                    ])
                    ->default(fn ($record) => $record?->delivery_option),
                Forms\Components\Textarea::make('details')
                    ->label('Details')
                    ->nullable(),
                Forms\Components\DatePicker::make('date')
                    ->label('Date')
                    ->required()
                    ->minDate(today()) // Prevents past dates
                    ->maxDate(today()) // Prevents future dates
                    ->default(today()),
                Forms\Components\TextInput::make('address')
                    ->label('Address')
                    ->required(),
                FileUpload::make('file_path')
                    ->label('File')
                    ->directory('complaints')
                    ->nullable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user_id')->label('User Id'),
                Tables\Columns\TextColumn::make('category'),
                Tables\Columns\TextColumn::make('details')->limit(50),
                Tables\Columns\TextColumn::make('date')->date(),
                Tables\Columns\TextColumn::make('address'),
                Tables\Columns\ImageColumn::make('file_path')
                    ->label('File')
                    ->size(60, 60)
                    ->url(fn ($record) => asset('storage/' . $record->file_path)),
                Tables\Columns\TextColumn::make('status'),
                Tables\Columns\BooleanColumn::make('is_completed')
                    ->label('Completed')
                    ->sortable(),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('Complete')->label('Complete')
                    ->action(function ($record) {
                    $record->update(['is_completed' => true]);
                        Notification::make()
                            ->success()
                            ->title('Complaint Completed')
                            ->body('The Complaint has been marked as completed.')
                            ->send();
                    })
                    ->requiresConfirmation()
                    ->color('success')
                    ->icon('heroicon-o-check'),
            ])
            ->headerActions([
                ExportAction::make()->exporter(ComplaintExporter::class),
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
            'index' => Pages\ListComplaints::route('/'),
            'create' => Pages\CreateComplaint::route('/create'),
            'edit' => Pages\EditComplaint::route('/{record}/edit'),
        ];
    }
}
