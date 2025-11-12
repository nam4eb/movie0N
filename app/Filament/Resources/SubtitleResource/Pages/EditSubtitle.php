<?php

namespace App\Filament\Resources\SubtitleResource\Pages;

use App\Filament\Resources\SubtitleResource;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Storage;

class EditSubtitle extends EditRecord
{
    protected static string $resource = SubtitleResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        if (!empty($data['vtt_upload'])) {
            $url = Storage::disk('public')->url($data['vtt_upload']);
            $data['vtt_url'] = $url;
        }
        unset($data['vtt_upload']);
        return $data;
    }
}

