<?php

namespace App\Http\Controllers\Api\v1\auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\v1\auth\StoreEmailVerificationRequest;
use App\Http\Resources\v1\auth\UserResource;
use App\Models\auth\EmailVerification;
use App\Models\auth\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $credentials['email'])->first();

        if (! $user || ! Hash::check($credentials['password'], $user->password)) {
            return response([
                'message' => 'Invalid credentials',
            ], 401);
        }

        if (! $user->is_active) {
            return response()->json([
                'message' => 'Account is inactive',
            ], 403);
        }

        // Optional: delete old tokens (if you want single session)
        $user->tokens()->delete();

        $token = $user->createToken('mobile')->plainTextToken;

        return response([
            'user' => new UserResource($user),
            'token' => $token,
        ]);
    }

    /**
     * User Log Out.
     */
    public function logout(Request $request)
    {
        try {
            $user = $request->user();

            if ($user && $user->currentAccessToken()) {
                $user->currentAccessToken()?->delete();
            }

            return response()->json([
                'status' => true,
                'message' => 'Logged out successfully',
            ], 200);

        } catch (\Throwable $e) {
            return response()->json([
                'status' => false,
                'message' => 'Logout failed',
                'error' => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        }
    }

    public function verify(StoreEmailVerificationRequest $request)
    {
        $record = EmailVerification::where('token', $request->token)
            ->where('email', $request->email)
            ->first();

        if (!$record) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid verification link'
            ], 400);
        }

        // check expiry (optional)
        if ($record->expires_at && Carbon::now()->isAfter($record->expires_at)) {
            return response()->json([
                'status' => false,
                'message' => 'Verification link expired'
            ], 400);
        }

        $user = User::find($record->user_id);

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'User not found'
            ], 404);
        }

        $user->email_verified_at = now();
        $user->is_active = true;
        $user->save();

        // delete token after verification
        $record->delete();

        return response()->json([
            'status' => true,
            'message' => 'Email verified successfully'
        ]);
    }
}
