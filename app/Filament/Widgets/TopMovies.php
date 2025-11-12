<?php

namespace App\Filament\Widgets;

use App\Models\Movie;
use Filament\Tables;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class TopMovies extends BaseWidget
{
    protected static ?int $sort = 2;
    protected int | string | array $columnSpan = 'full';

    public function getTableHeading(): string
    {
        return 'Top 5 Most Viewed Movies This Week';
    }

    protected function getTableQuery(): Builder
    {
        $startOfWeek = now()->startOfWeek();
        $endOfWeek = now()->endOfWeek();

        $topMovieIds = DB::table('movie_views')
            ->select('movie_id', DB::raw('COUNT(*) as views'))
            ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
            ->groupBy('movie_id')
            ->orderByDesc('views')
            ->limit(5)
            ->pluck('movie_id');

        if ($topMovieIds->isEmpty()) {
            return Movie::query()->whereRaw('1 = 0'); // Return empty query if no views
        }

        return Movie::whereIn('movie_id', $topMovieIds)
            ->selectRaw('tbl_movie.*, (SELECT COUNT(*) FROM movie_views WHERE movie_views.movie_id = tbl_movie.movie_id AND movie_views.created_at BETWEEN ? AND ?) as weekly_views', [$startOfWeek, $endOfWeek])
            ->orderByDesc('weekly_views');
    }

    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('movie_name')
                ->label('Title'),
            Tables\Columns\TextColumn::make('weekly_views')
                ->label('Views This Week')
                ->sortable(),
            Tables\Columns\TextColumn::make('category.cat_name')
                ->label('Category'),
            Tables\Columns\TextColumn::make('country.country_name')
                ->label('Country'),
        ];
    }
}

