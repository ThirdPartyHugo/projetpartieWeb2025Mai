<?php

namespace App\Http\Controllers;

use App\Models\Magasin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\MagasinResource;

class MagasinController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $magasins = Magasin::all();
        if ($request->routeIs('magasinApi')) {
            if (empty($magasins))
                return response()->json(['ERREUR' => 'Aucun magasins.'], 400);
            return MagasinResource::collection($magasins);
        }else{
            return view('magasin/magasins', [
                'magasins' => $magasins
            ]);
        }

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('magasin/ajouterMagasin');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, int $idMagasin)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id)
    {
        return view('magasin/formulaireMagasin', [
            'magasin' => Magasin::find($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Magasin $magasin)
    {
        $validation = Validator::make($request->all(), [
            'nom' => 'required',
            'telephone' => 'required|regex:/^([0-9]{3}[- ]){2}[0-9]{4}/',
            'image' => 'required|regex:/^[a-zA-z0-9]+[.][a-zA-z0-9]+/',
            'adresse' => 'required'
        ], [
            'nom.required' => 'Veuillez entrer un nom pour le magasin.',
            'telephone.required' => 'Veuillez inscrire un numero de telephone pour le produit.',
            'telephone.regex' => 'Le numero de telephone doit etre s\'eparer par un espace un point ou un tiret.',
            'image.required' => 'Veuillez entrer le nom de l\'image.',
            'image.regex' => 'L\'image ne peut pas contenir d\'espace et doit contenir le nom du fichier, un point et l\'extension',
            'adresse.required' => 'Veuillez inscrire une adresse pour le magasin.'

        ]);
//
        if ($validation->fails())
            return back()->withErrors($validation->errors())->withInput();

        $contenuFormulaire = $validation->validated();

        $magasin = Magasin::find($request['id']);
        $magasin->nom = $contenuFormulaire['nom'];
        $magasin->telephone = $contenuFormulaire['telephone'];
        $magasin->image = $contenuFormulaire['image'];

        $magasin->save();

        return $this->index($request);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Magasin $magasin)
    {
        //
    }
}
