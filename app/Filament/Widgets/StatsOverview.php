<?php

namespace App\Filament\Widgets;

use App\Models\Movie;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $totalMovies = Movie::count();
        $totalUsers = User::count();
        $viewsToday = DB::table('movie_views')->whereDate('created_at', today())->count();

        return [
            Stat::make('Total Movies', $totalMovies)
                ->description('All movies in the database')
                ->icon('heroicon-o-film'),
            Stat::make('Total Users', $totalUsers)
                ->description('All registered users')
                ->icon('heroicon-o-users'),
            Stat::make('Views Today', $viewsToday)
                ->description('Total movie views recorded today')
                ->icon('heroicon-o-eye'),
        ];
    }
}

