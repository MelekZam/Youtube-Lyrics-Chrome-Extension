<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetLyricsRequest;
use App\Http\Requests\PostLyricsRequest;
use App\Models\Lyrics;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LyricsController extends Controller
{
    public function postLyrics(PostLyricsRequest $req) {
        $user = Auth::user();
        if (!$user->activated)
            return response()->json(['message' => 'unauthorized'], 403);
        try {
            $lyrics = Lyrics::updateOrCreate(
                ['id' => $req->id],
                [
                    'lyrics' => $req->lyrics,
                    'last_changed_by' => $user->username,
                    'last_changed_at' => Carbon::now()
                ]
            );
            return response()->json(['lyrics' => $lyrics]);
        } catch (\Throwable $th) {
            return $th;
            return response()->json(['message' => 'error'], 500);
        }
    }

    public function getLyrics(GetLyricsRequest $req) {
        try {
            $lyrics = Lyrics::find($req->id);
            if ($lyrics)
                return response()->json(['lyrics' => $lyrics]);
            return response()->json(['message' => 'not found'], 404);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'error'], 500);
        }
    }
}
