<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Tables;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;

class MostActiveUsers extends BaseWidget
{
    protected static ?int $sort = 6;
    protected int | string | array $columnSpan = 'full';

    public function getTableHeading(): string
    {
        return 'Most Active Users (Last 30 Days)';
    }

    protected function getTableQuery(): Builder
    {
        return User::withCount([
                'comments' => fn ($query) => $query->where('created_at', '>=', now()->subDays(30)),
                'ratings' => fn ($query) => $query->where('created_at', '>=', now()->subDays(30)),
            ])
            ->havingRaw('(comments_count + ratings_count) > 0')
            ->orderByRaw('(comments_count + ratings_count) DESC')
            ->limit(10);
    }

    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('name')
                ->label('User'),
            Tables\Columns\TextColumn::make('comments_count')
                ->label('Comments')
                ->sortable(),
            Tables\Columns\TextColumn::make('ratings_count')
                ->label('Ratings')
                ->sortable(),
        ];
    }
}

