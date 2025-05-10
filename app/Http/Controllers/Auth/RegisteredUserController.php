<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        if ($request->routeIs('inscriptionAPI')) {
            $validation = Validator::make($request->all(), [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'regex:/^([a-zA-Z0-9_.]+)([@])([a-z]+)([.])([a-z]+)$/', 'unique:'.User::class],
                'password' => ['required', 'confirmed', "regex:/(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*()_+={}\[\]:;'<>,.?'\/'-]).{8,}/", Rules\Password::defaults()],
            ], [
                'name.required' => 'Veuillez entrer un nom.',
                'email.required' => 'Veuillez entrer un email.',
                'email.regex' => 'L\'email entre n\'est pas dans un format valide.',
                'password.required' => 'Veuillez entrer un mot de passe.',
                'password.regex' => 'Le mot de passe entre n\'est pas dans un format valide. Vous devez avoir une lettre minuscule et majuscule, un chiffre et un symbole.',
                'password.confirmed' => 'Le mot de passe de confirmation doit correspondre au mot de passe entré.',
            ]);

            if ($validation->fails()) {
                // un conteneur JSON avec un code HTTP 400.
                return response()->json($validation->errors(), 400);
            }

            try {
                $user = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'id_role' => 3,
                ]);

                //event(new Registered($user));
            } catch (QueryException $erreur) {
                //report($erreur);
                return response()->json(['ERREUR' => 'L\'inscription n\'a pas fonctionne.'], 500);
            }

            return response()->json(['SUCCES' => 'L\'inscription a bien fonctionne.'], 200);
        }

        $validation = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255', 'regex:/^([a-zA-Z-]+) ([a-zA-Z-]+)$/'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'regex:/^([a-zA-Z0-9_.]+)([@])([a-z]+)([.])([a-z]+)$/', 'unique:'.User::class],
            'password' => ['required', 'confirmed', "regex:/(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*()_+={}\[\]:;'<>,.?'\/'-]).{8,}/", Rules\Password::defaults()],
            'roles' => ['required'],
        ], [
            'name.required' => 'Veuillez entrer un nom.',
            'name.regex' => 'Le nom entré n\'est pas dans le bon format. Exemple: Jean Charles.',
            'email.required' => 'Veuillez entrer un email.',
            'email.regex' => 'L\'email entré n\'est pas dans un format valide.',
            'password.required' => 'Veuillez entrer un mot de passe.',
            'password.regex' => 'Le mot de passe entré n\'est pas dans un format valide. Vous devez avoir une lettre minuscule et majuscule, un chiffre et un symbole.',
            'password.confirmed' => 'Le mot de passe de confirmation doit correspondre au mot de passe entré.',
        ]);

        if ($validation->fails()) {
            // un conteneur JSON avec un code HTTP 400.
            return back()->withErrors($validation->errors())->withInput();
        }

        $newUser = $validation->validated();

        $user = User::create([
            'name' => $newUser['name'],
            'email' => $newUser['email'],
            'password' => Hash::make($newUser['password']),
            'id_role'=>$newUser['roles'],
        ]);

        event(new Registered($user));

        return redirect(route('listEmployee', absolute: false));
    }
}
