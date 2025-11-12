<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SubtitleResource\Pages;
use App\Models\Subtitle;
use App\Models\Movie;
use App\Models\Episode;
use Filament\Forms;
use Filament\Forms\Get;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables;
use Illuminate\Support\Facades\Storage;

class SubtitleResource extends Resource
{
    protected static ?string $model = Subtitle::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationGroup = 'Content';
    protected static ?int $navigationSort = 45;
    protected static ?string $modelLabel = 'Subtitle';
    protected static ?string $pluralModelLabel = 'Subtitles';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('movie_id')
                    ->label('Movie')
                    ->options(fn() => Movie::orderBy('movie_name')->pluck('movie_name', 'movie_id')->toArray())
                    ->required()
                    ->live(),
                Forms\Components\Select::make('episode_id')
                    ->label('Episode (optional)')
                    ->options(function (Get $get) {
                        $mid = (int) $get('movie_id');
                        if (!$mid) return [];
                        return Episode::where('movie_id', $mid)->orderBy('eps_num')->pluck('eps_num', 'eps_id')->toArray();
                    })
                    ->helperText('Chọn nếu là phụ đề cho một tập cụ thể. Để trống nếu phụ đề cho cả phim.')
                    ->searchable(),
                Forms\Components\TextInput::make('lang')
                    ->label('Language code (e.g. vi, en-US)')
                    ->required()
                    ->maxLength(12),
                Forms\Components\TextInput::make('label')
                    ->label('Label (e.g. Tiếng Việt)')
                    ->required()
                    ->maxLength(64),
                Forms\Components\TextInput::make('vtt_url')
                    ->label('VTT URL (nếu dùng URL ngoài)')
                    ->url()
                    ->maxLength(2048)
                    ->helperText('Hoặc upload file VTT bên dưới.'),
                Forms\Components\FileUpload::make('vtt_upload')
                    ->label('Upload VTT')
                    ->disk('public')
                    ->directory('subtitles')
                    ->acceptedFileTypes(['text/vtt','.vtt'])
                    ->helperText('Nếu upload, hệ thống sẽ tự lưu URL vào trường VTT URL khi lưu.')
                    ->preserveFilenames()
                    ->columnSpan('full'),
                Forms\Components\Toggle::make('is_default')->label('Default')->default(false),
            ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('movie_id')->label('Movie')->formatStateUsing(function ($state) {
                    $m = Movie::where('movie_id', $state)->first();
                    return $m?->movie_name ?: $state;
                })->searchable(),
                Tables\Columns\TextColumn::make('episode_id')->label('Ep')->formatStateUsing(function ($state) {
                    if (!$state) return '-';
                    $ep = Episode::find($state);
                    return $ep?->eps_num ?: $state;
                }),
                Tables\Columns\TextColumn::make('label')->searchable(),
                Tables\Columns\TextColumn::make('lang')->label('Lang')->searchable(),
                Tables\Columns\IconColumn::make('is_default')->boolean()->label('Default'),
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
            'index' => Pages\ListSubtitles::route('/'),
            'create' => Pages\CreateSubtitle::route('/create'),
            'edit' => Pages\EditSubtitle::route('/{record}/edit'),
        ];
    }
}

