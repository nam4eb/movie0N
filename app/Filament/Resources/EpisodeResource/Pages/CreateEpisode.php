<?php

namespace App\Filament\Resources\EpisodeResource\Pages;

use App\Filament\Resources\EpisodeResource;
use App\Models\Movie;
use App\Notifications\NewEpisodeNotification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Notification;

class CreateEpisode extends CreateRecord
{
    protected static string $resource = EpisodeResource::class;

    protected function afterCreate(): void
    {
        $episode = $this->record;
        $movie = Movie::find($episode->movie_id);

        if ($movie && $movie->followers()->exists()) {
            Notification::send($movie->followers, new NewEpisodeNotification($movie, $episode));
        }
    }
}
