<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\GenreDistributionChart;
use App\Filament\Widgets\MostActiveUsers;
use App\Filament\Widgets\MovieViewsChart;
use App\Filament\Widgets\StatsOverview;
use App\Filament\Widgets\TopMovies;
use App\Filament\Widgets\UserRegistrationsChart;
use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    public static function canAccess(): bool
    {
        return auth()->user()->can('view admin dashboard');
    }


    public function getWidgets(): array
    {
        return [
            StatsOverview::class,
            TopMovies::class,
            UserRegistrationsChart::class,
            MovieViewsChart::class,
            GenreDistributionChart::class,
            MostActiveUsers::class,
        ];
    }
}
