<?php

namespace App\Http\Controllers\Auth;

use App\Events\AuthEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\Counter;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): Response
    {

        $request->authenticate();  // Authenticates the user based on the provided credentials (via the LoginRequest)

        $request->session()->regenerate();  // Regenerates the session to avoid session fixation attacks

        $user = $request->user();  // Retrieves the authenticated user

        $token = $user->createToken('API Token')->plainTextToken;  // Creates a new API token for the user

        if ($user->role == 'employee') {
            $counter = Counter::where('user_id', '=', $user->id)->first();
            $counter->counter_status = 'idle';
            $counter->save();
        }

        $response = new response();

        $response->cookie('token', $token, 60);

        return $response;
    }


    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): Response
    {
        $user = $request->user();

        if ($user->role == 'employee') {
            $counter = Counter::where('user_id', '=', $user->id)->first();
            $counter->counter_status = 'closed';
            $counter->save();
        }

        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return response()->noContent();
    }
}
