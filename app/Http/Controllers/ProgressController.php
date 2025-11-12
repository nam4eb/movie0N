<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\UserProgress;

class ProgressController extends Controller
{
    public function store(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['status' => 'unauthenticated'], 401);
        }
        $data = $request->validate([
            'movie_id' => 'required|integer',
            'episode_id' => 'nullable|integer',
            'position_seconds' => 'nullable|integer|min:0',
            'duration_seconds' => 'nullable|integer|min:0',
        ]);

        $data['user_id'] = $user->id;
        $data['last_seen_at'] = now();
        $data['position_seconds'] = $data['position_seconds'] ?? 0;

        UserProgress::updateOrCreate(
            [
                'user_id' => $data['user_id'],
                'movie_id' => $data['movie_id'],
                'episode_id' => $data['episode_id'] ?? null,
            ],
            [
                'position_seconds' => $data['position_seconds'],
                'duration_seconds' => $data['duration_seconds'] ?? null,
                'last_seen_at' => $data['last_seen_at'],
            ]
        );

        return response()->json(['status' => 'ok']);
    }
}

