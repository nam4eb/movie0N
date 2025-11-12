<?php

namespace App\Filament\Widgets;

use App\Models\Genre;
use Filament\Widgets\ChartWidget;

class GenreDistributionChart extends ChartWidget
{
    protected static ?string $heading = 'Movie Genre Distribution';

    protected static ?int $sort = 5;

    protected function getData(): array
    {
        $genres = Genre::get();

        return [
            'datasets' => [
                [
                    'label' => 'Movies',
                    'data' => $genres->pluck('movies_count'),
                    'backgroundColor' => [
                        '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF', '#FF9F40',
                        '#E7E9ED', '#8399B3', '#D93240', '#2E86AB', '#A3C644', '#F28A30'
                    ],
                ],
            ],
            'labels' => $genres->pluck('genre_name'),
        ];
    }

    protected function getType(): string
    {
        return 'pie';
    }
}

