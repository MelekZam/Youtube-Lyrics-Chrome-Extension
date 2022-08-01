<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetLyricsRequest;
use App\Http\Requests\GetTranslationRequest;
use App\Http\Requests\PostLyricsRequest;
use App\Http\Requests\PostTranslationRequest;
use App\Models\Lyrics;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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

    public function getTranslation(GetTranslationRequest $req) {
        $translation = DB::table('translations')
                            ->where('id', $req->id)
                            ->where('language', $req->language)
                            ->first();
        return $translation;
    }

    public function postTranslation(PostTranslationRequest $req) {
        $user = Auth::user();
        $update = [
            'translation' => $req->translation,
            'last_changed_by' => $user->username,
            'last_changed_at' => Carbon::now()
        ];
        try {
            $translation = DB::table('translations')
                                ->updateOrInsert(
                                    ['id' => $req->id, 'language' => $req->language],
                                    $update,
                                );
        } catch (\Throwable $th) {
            return response()->json(['message' => 'error'], 500);
        }
        return response()->json(['translation' => $update]);
    }
}
