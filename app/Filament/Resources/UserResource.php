<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use App\Filament\Exports\UserExporter;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Actions\ExportAction;
use Illuminate\Notifications\Notifiable;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')->required()->type('text'),
                Forms\Components\TextInput::make('email')
                ->unique(ignorable: fn ($record) => $record)
                ->required()->type('email'),
                Forms\Components\TextInput::make('phone')->type('tel'),
                Forms\Components\TextInput::make('address')->type('text'),
                Forms\Components\Select::make('role')
                ->required()
                ->label('Role')
                ->options([
                    'Resident' => 'Resident',
                    'Company' => 'Company',
                    'Admin' => 'Admin',
                ]),
                Forms\Components\TextInput::make('password')
                ->type('password')
                ->dehydrateStateUsing(fn ($state) => !empty($state) ? bcrypt($state) : null) 
                ->helperText('Leave blank to keep the current password.')
                ->dehydrated(fn ($state) => !empty($state)),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('email'),
                Tables\Columns\TextColumn::make('phone'),
                Tables\Columns\TextColumn::make('address'),
                Tables\Columns\TextColumn::make('role'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->headerActions([
                ExportAction::make()->exporter(UserExporter::class),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
