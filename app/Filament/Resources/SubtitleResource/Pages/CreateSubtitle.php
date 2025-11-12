<?php

namespace App\Filament\Resources\SubtitleResource\Pages;

use App\Filament\Resources\SubtitleResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Storage;

class CreateSubtitle extends CreateRecord
{
    protected static string $resource = SubtitleResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if (!empty($data['vtt_upload'])) {
            // vtt_upload is a path relative to disk root
            $disk = config('filesystems.disks.public.root');
            $path = $data['vtt_upload'];
            $url = Storage::disk('public')->url($path);
            $data['vtt_url'] = $url;
        }
        unset($data['vtt_upload']);
        return $data;
    }
}

