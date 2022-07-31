<?php

namespace App\Http\Controllers;

use App\Helpers\Otp;
use App\Http\Requests\ActivateRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\SignupRequest;
use App\Models\User;
use App\Notifications\OtpNotification;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function signup(SignupRequest $req) {
        $user = User::create([
            'username' => $req->username,
            'email' => $req->email,
            'password' => Hash::make($req->password)
        ]);
        $otp = Otp::generate();
        $user->activation()->create($otp);
        $token = $user->createToken('token')->plainTextToken;
        $user->notify(new OtpNotification($otp));
        return response()->json([
            'user' => $user,
            'token' => $token
        ]);
    }

    public function login(LoginRequest $req) {
        $user = User::where('username', $req->username)->first();
        if (!$user)
            return response()->json(['message' => 'wrong credentials'], 404);
        if (!Hash::check($req->password, $user->password))
            return response()->json(['message' => 'wrong credentials'], 404);
        $token = $user->createToken('token')->plainTextToken;
        return response()->json([
            'user' => $user,
            'token' => $token
        ]);
    }

    public function activate(ActivateRequest $req) {
        $user = Auth::user();
        if ($user->activated)
            return response()->json(['message' => 'unauthorized'], 403);
        $otp = $req->otp;
        $activation = $user->activation;
        if ($activation->otp != $req->otp)
            return response()->json(['message' => 'otp invalid'], 400);
        if (Carbon::now()->gte($activation->expires_at))
            return response()->json(['message' => 'otp expired'], 400);
        try {
            $user->update([
                'activated' => 1
            ]);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'error'], 500);
        }
        return response()->json(['message' => 'success']);
    }

    public function resend() {
        $user = Auth::user();
        $otp = Otp::generate();
        if ($user->activated)
            return response()->json(['message' => 'unauthorized'], 403);
        try {
            $user->activation()->update($otp);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'error'], 500);
        }
        $user->notify(new OtpNotification($otp));
        return response()->json(['message' => 'success']);
    }

}
