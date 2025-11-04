<?php

namespace App\Filament\Resources\PlaylistResource\Pages;

use App\Filament\Resources\PlaylistResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPlaylists extends ListRecords
{
    protected static string $resource = PlaylistResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
