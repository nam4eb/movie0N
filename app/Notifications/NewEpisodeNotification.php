<?php

namespace App\Notifications;

use App\Models\Episode;
use App\Models\Movie;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewEpisodeNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public Movie $movie;
    public Episode $episode;

    public function __construct(Movie $movie, Episode $episode)
    {
        $this->movie = $movie;
        $this->episode = $episode;
    }

    public function via($notifiable): array
    {
        return ['database']; // We'll start with just database notifications
    }

    public function toArray($notifiable): array
    {
        return [
            'movie_id' => $this->movie->movie_id,
            'movie_name' => $this->movie->movie_name,
            'episode_number' => $this->episode->eps_num,
            'episode_id' => $this->episode->eps_id,
            'message' => "Tập mới {$this->episode->eps_num} của phim {$this->movie->movie_name} đã được thêm.",
            'url' => route('movie.watch', ['movie' => $this->movie->movie_id, 'ep' => $this->episode->eps_id]),
        ];
    }
}

