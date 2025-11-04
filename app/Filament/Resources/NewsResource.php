<?php

namespace App\Filament\Resources;

use App\Filament\Resources\NewsResource\Pages;
use App\Models\News;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Tables;
use Illuminate\Support\Str;

class NewsResource extends Resource
{
    protected static ?string $model = News::class;

    protected static ?string $navigationIcon = 'heroicon-o-newspaper';
    protected static ?string $navigationGroup = 'Content';
    protected static ?string $navigationLabel = 'News';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('title')
                ->required()
                ->maxLength(255)
                ->reactive()
                ->afterStateUpdated(function ($state, callable $set) {
                    $set('slug', Str::slug($state));
                }),
            Forms\Components\TextInput::make('slug')
                ->required()
                ->unique(News::class, 'slug', ignoreRecord: true)
                ->maxLength(255),
            Forms\Components\TextInput::make('excerpt')->maxLength(255),
            Forms\Components\Textarea::make('content')->rows(8),
            Forms\Components\TextInput::make('image_path')->label('Image path (public/img/...)')->maxLength(255),
            Forms\Components\Toggle::make('is_published')->label('Published'),
            Forms\Components\DateTimePicker::make('published_at'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('title')->searchable()->sortable(),
            Tables\Columns\BadgeColumn::make('is_published')->enum([0=>'Draft',1=>'Published'])->colors(['danger'=>0,'success'=>1]),
            Tables\Columns\TextColumn::make('published_at')->dateTime()->sortable(),
            Tables\Columns\TextColumn::make('created_at')->dateTime()->sortable(),
        ])->actions([
            Tables\Actions\EditAction::make(),
            Tables\Actions\DeleteAction::make(),
        ])->bulkActions([
            Tables\Actions\DeleteBulkAction::make(),
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListNews::route('/'),
            'create' => Pages\CreateNews::route('/create'),
            'edit' => Pages\EditNews::route('/{record}/edit'),
        ];
    }
}

