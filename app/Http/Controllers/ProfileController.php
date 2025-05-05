<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Role;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Mail\ResetPassword;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redis;
use Illuminate\Validation\Rules;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Mail;
use App\Http\Resources\UserResource;
use Illuminate\Validation\Rule;

use function Laravel\Prompts\form;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $id = $request->input('id_user');

        return view('profile.edit', [
            'user' => User::find($id),
            'roles' => Role::All()->where('id_role', '!=', 3),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request)//: RedirectResponse
    {
        if ($request->routeIs('modificationProfilAPI')) {
            try {
                $validation = Validator::make($request->all(), [
                    'name' => ['required', 'string', 'max:255'],
                    'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'regex:/^([a-zA-Z0-9_.]+)([@])([a-z]+)([.])([a-z]+)$/', Rule::unique(User::class)->ignore($request->user()->id)],
                ], [
                    'name.required' => 'Veuillez entrer un nom.',
                    'email.required' => 'Veuillez entrer un email.',
                    'email.regex' => 'L\'email entré n\'est pas dans un format valide.',
                ]);

                if ($validation->fails()) {
                    // un conteneur JSON avec un code HTTP 400.
                    return back()->withErrors($validation->errors())->withInput();
                }

                $form = $validation->validated();

                $user = $request->user();

                $user->name = $form['name'];
                $user->email = $form['email'];

                $user->save();
            } catch (QueryException $erreur) {
                report($erreur);
                return response()->json(['ERREUR' => 'La modification du profil n\'a pas fonctionné.'], 500);
            }

            return response()->json(['SUCCÈS' => 'La modification du profil a bien fonctionné.'], 200);
        }

        $validation = Validator::make($request->all(), [
            'id_user' => ['required'],
            'name' => ['required', 'string', 'max:255', 'regex:/^([a-zA-Z-]+) ([a-zA-Z-]+)$/'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'regex:/^([a-zA-Z0-9_.]+)([@])([a-z]+)([.])([a-z]+)$/', Rule::unique(User::class)->ignore($request->all()['id_user'])],
            'roles' => ['required'],
            'password' => ['required', 'confirmed', "regex:/(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*()_+={}\[\]:;'<>,.?'\/'-]).{8,}/", Rules\Password::defaults()],
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

        $form = $validation->validated();

        $user = User::find($form['id_user']);

        $user->name = $form['name'];
        $user->email = $form['email'];
        $user->id_role = $form['roles'];

        $user->save();

        return Redirect::route('listEmployee');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::route('profile.edit');
    }

    public function list(Request $request): View
    {
        return view('user/listEmployee', ['users' => User::All()->where('id_role', '!=', 3)]);
    }

    public function showRegister(): View
    {
        return view('user/register', ['roles' => Role::All()->where('id_role', '!=', 3)]);
    }

    public function delete(Request $request)
    {
        if ($request->routeIs('supprimeCompteAPI')) {
            try {
                $id = $request->user()->id;

                User::destroy($id);
            } catch (QueryException $erreur) {
                report($erreur);
                return response()->json(['ERREUR' => 'La suppression du compte n\'a pas fonctionné.'], 500);
            }

            return response()->json(['SUCCÈS' => 'La suppression du compte a fonctionné.'], 200);

        }elseif($request->routeIs('deleteEmployee')){

            $id = $request->input('id_user');

            if(Auth::user()->id != $id){
                User::destroy($id);
            }

            return back();
        }
    }

    public function envoiCourriel(Request $request)
    {
        if ($request->routeIs('resetPasswordCourrielAPI')) {
            try {
                $user = User::find($request->user()->id);

                Mail::to($user->email)->send(new ResetPassword($user));
            } catch (QueryException $erreur) {
                report($erreur);
                return response()->json(['ERREUR' => 'L\'envoi du courriel pour réinitialisé le mot de passe n\'a pas fonctionné.'], 500);
            }
        }
    }

    public function formReset($id): View
    {
        return view('user.passwordReset', [
            'compte' => User::find($id)
        ]);
    }

    public function updatePassword(Request $request): View
    {
        $request->validate([
            'id_user' => ['required', 'string'],
            'password' => ['required', 'confirmed', "regex:/(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*()_+={}\[\]:;'<>,.?'\/'-]).{8,}/", Rules\Password::defaults()],
        ], [
            'password.required' => 'Veuillez entrer un mot de passe.',
            'password.regex' => 'Le mot de passe entré n\'est pas dans un format valide. Vous devez avoir une lettre minuscule et majuscule, un chiffre et un symbole.',
            'password.confirmed' => 'Le mot de passe de confirmation doit correspondre au mot de passe entré.',
        ]);

        try {
            $user = User::find($request->id_user);

            $user->password = Hash::make($request->password);

            $user->save();
        } catch (QueryException $erreur) {
            report($erreur);
            return view('user.updatePasswordErreur', [
                'user' => User::find($request->id_user)
            ]);
        }

        return view('user.updatePasswordSucces');
    }

    public function search(Request $request)
    {
        $requete = $request->all();

        $motCle = $requete['mots_cles'];

        $users = User::where('id_role', '!=', 3)->where('name', 'like', "%$motCle%")->get();

        if($users->isEmpty()){
            return response()->json(['ÉCHEC' => 'Aucun employé ne correspond à votre recherche.'], 500);
        }else{
            return json_encode($users, JSON_PRETTY_PRINT);
        }
    }

    public function recupInfoCompte(Request $request)
    {
        if ($request->routeIs('recupInfoCompteAPI')) {
            try {
                $user = User::find($request->user()->id);

                return new UserResource($user);
            } catch (QueryException $erreur) {
                report($erreur);
                return response()->json(['ERREUR' => 'La récupération des données n\'a pas fonctionné.'], 500);
            }
        }
    }
}
