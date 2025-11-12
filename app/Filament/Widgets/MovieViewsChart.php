<?php

namespace App\Filament\Widgets;

use App\Models\MovieView;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class MovieViewsChart extends ChartWidget
{
    protected static ?string $heading = 'Movie Views - Last 30 Days';

    protected static ?int $sort = 4;

    protected function getData(): array
    {
        $data = Trend::model(MovieView::class)
            ->between(
                start: now()->subDays(29),
                end: now(),
            )
            ->perDay()
            ->count();

        return [
            'datasets' => [
                [
                    'label' => 'Movie Views',
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                    'borderColor' => '#ff9800',
                    'tension' => 0.2,
                ],
            ],
            'labels' => $data->map(fn (TrendValue $value) => $value->date),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}

