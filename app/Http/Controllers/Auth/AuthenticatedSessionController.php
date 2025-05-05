<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\UserResource;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;
use App\Models\User;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request)
    {
        if ($request->routeIs('loginAPI')) {
            try {
                $request->ensureIsNotRateLimited();

                if (! Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {

                    RateLimiter::hit($request->throttleKey());

                    return response()->json(['ERREUR' => 'Courriel ou Mot de passe invalide'], 500);
                }

                RateLimiter::clear($request->throttleKey());
            } catch (QueryException $erreur) {
                report($erreur);
                return response()->json(['ERREUR' => 'La connexion n\'a pas fonctionné.'], 500);
            }

            $login = $request->all();
            $user = User::where('email', '=', $login['email'])->first();

            return response()->json(['SUCCÈS' => $user->createToken('login')->plainTextToken], 200);
        }

        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
