<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EpisodeResource\Pages;
use App\Models\Episode;
use App\Models\Movie;
use Filament\Resources\Resource;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Forms;
use Filament\Tables;

class EpisodeResource extends Resource
{
    protected static ?string $model = Episode::class;

    protected static ?string $navigationIcon = 'heroicon-o-video-camera';
    protected static ?string $navigationGroup = 'Content';
    protected static ?int $navigationSort = 40;
    protected static ?string $modelLabel = 'Episode';
    protected static ?string $pluralModelLabel = 'Episodes';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('movie_id')
                    ->label('Movie')
                    ->options(fn()=> Movie::orderBy('movie_name')->pluck('movie_name','movie_id')->toArray())
                    ->searchable()
                    ->required(),
                Forms\Components\TextInput::make('eps_num')->numeric()->label('Episode Number')->required(),
                Forms\Components\TextInput::make('link')->label('Stream Link (YouTube/MP4/HLS .m3u8)')->required(),
            ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('movie_id')->label('Movie')->formatStateUsing(function($state){
                    $m = Movie::where('movie_id', $state)->first();
                    return $m?->movie_name ?: $state;
                })->searchable(),
                Tables\Columns\TextColumn::make('eps_num')->label('Ep#')->sortable(),
                Tables\Columns\TextColumn::make('link')->limit(40)->toggleable(),
                Tables\Columns\TextColumn::make('updated_at')->dateTime()->since(),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEpisodes::route('/'),
            'create' => Pages\CreateEpisode::route('/create'),
            'edit' => Pages\EditEpisode::route('/{record}/edit'),
        ];
    }
}

