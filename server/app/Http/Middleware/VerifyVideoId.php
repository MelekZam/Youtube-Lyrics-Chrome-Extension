<?php

namespace App\Http\Middleware;

use Closure;
use GuzzleHttp\TransferStats;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Request;

class VerifyVideoId
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next)
    {
        $id = $request->id;
        if (strlen($id) != 11 || !preg_match('/[a-zA-Z0-9_-]{11}/', $id))
            return response()->json(['message' => 'video id not valid'], 400);
        $key = config('app.youtube_key');
        $response = Http::get('https://www.googleapis.com/youtube/v3/videos?id=' . $id . '&key=' . $key);
        if ($response->object()->pageInfo->totalResults)
            return $next($request);
        return response()->json(['message' => 'video does not exist'], 404);
    }
}
