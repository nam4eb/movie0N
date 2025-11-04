<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MovieResource\Pages;
use App\Filament\Resources\MovieResource\RelationManagers;
use App\Models\Movie;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MovieResource extends Resource
{
    protected static ?string $model = Movie::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('movie_name')->label('Name')->required()->maxLength(255),
                Forms\Components\TextInput::make('image')->label('Image filename')->helperText('Đặt tên file trong public/img, ví dụ: wall-e.jpg')->required()->maxLength(255),
                Forms\Components\Textarea::make('description')->rows(4),
                Forms\Components\TextInput::make('cat_id')->numeric()->label('Category ID'),
                Forms\Components\TextInput::make('genre_id')->numeric()->label('Genre ID'),
                Forms\Components\TextInput::make('country_id')->numeric()->label('Country ID'),
                Forms\Components\TextInput::make('eps_id')->numeric()->label('Episode ID'),
                Forms\Components\Toggle::make('status')->label('Active')->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('movie_id')->sortable()->label('ID'),
                Tables\Columns\TextColumn::make('movie_name')->searchable()->sortable()->label('Name'),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn ($state) => (int)$state === 1 ? 'Active' : 'Inactive')
                    ->color(fn ($state) => (int)$state === 1 ? 'success' : 'danger'),
                Tables\Columns\TextColumn::make('created_at')->dateTime()->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListMovies::route('/'),
            'create' => Pages\CreateMovie::route('/create'),
            'edit' => Pages\EditMovie::route('/{record}/edit'),
        ];
    }    
}
