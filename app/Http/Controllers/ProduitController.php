<?php

namespace App\Http\Controllers;

use App\Models\Produit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\QueryException;


class ProduitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return view('produit/produits', [
            'produits' => Produit::All()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('produit/ajouterProduit');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validation = Validator::make($request->all(), [
            'nom' => 'required',
            'description' => 'required|max:250',
            'prix' => 'required|regex:/^\d+\.\d\d$/',
            'image' => 'required|regex:/^[a-zA-z0-9]+[.][a-zA-z0-9]+/'
        ], [
            'nom.required' => 'Veuillez entrer un nom pour le produit.',
            'description.required' => 'Veuillez inscrire une description pour le produit.',
            'description.max' => 'Votre description de produit ne peut pas dépasser 250 caractères.',
            'prix.required' => 'Veuillez inscrire un prix pour le produit.',
            'prix.regex' => 'Le prix doit être un montant valide avec un point comme délimitateur.',
            'image.required' => 'Veuillez entrer un nom de l\'image.',
            'image.regex' => 'L\'image ne peut pas contenir d\'espace et doit contenir le nom du fichier, un point et l\'extension'
        ]);
        if ($validation->fails()) {
            return back()->withErrors($validation->errors())->withInput();
        }

        $contenuDecode = $validation->validated();
        try {
            Produit::create([
                'produit_nom' => $contenuDecode['nom'],
                'produit_description' => $contenuDecode['description'],
                'produit_prix' => $contenuDecode['prix'],
                'produit_image' => $contenuDecode['image']
            ]);
        } catch (QueryException $erreur) {
            report($erreur);

            return response()->json(['ERREUR' => $erreur], 500);
        }
        return $this->index($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, int $idProduit)
    {

        $produit = Produit::find($idProduit);

        if ($request->routeIs('produitApi')) {
            if (empty($produit))
                return response()->json(['ERREUR' => 'Le produit demandé est introuvable.'], 400);
            return response()->json(['SUCCES' => $produit], 200);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('produit/formulaireProduit', [
            'produit' => Produit::find($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'produit_nom' => 'required',
            'produit_id' => 'required',
            'produit_description' => 'required|max:250',
            'produit_prix' => 'required|regex:/^\d+\.\d\d$/',
            'produit_stock' => 'required|regex:/[0-9]+/',
            'produit_site' => 'required|regex:/[0-9]+/'
        ], [
            'produit_id.required' => 'Ce produit n\'a aucun id.',
            'produit_nom.required' => 'Veuillez entrer un nom pour le produit.',
            'produit_description.required' => 'Veuillez inscrire une description pour le produit.',
            'produit_description.max' => 'Votre description de produit ne peut pas dépasser 250 caractères.',
            'produit_prix.required' => 'Veuillez inscrire un prix pour le produit.',
            'produit_prix.regex' => 'Le prix doit être un montant valide avec un point comme délimitateur.',
            'produit_stock.required' => 'Veuillez inscrire un stock pour le produit',
            'produit_stock.regex' => 'Le stock doit etre un chiffre ou un nombre',
            'produit_site.required' => 'Veuillez inscrire un site pour le produit',
            'produit_site.regex' => 'Le site doit etre un chiffre ou un nombre'
        ]);

        if ($validation->fails())
            return back()->withErrors($validation->errors())->withInput();
        $contenuFormulaire = $validation->validated();
        $produit = Produit::find($contenuFormulaire['produit_id']);
        $produit->produit_prix = $contenuFormulaire['produit_prix'];
        $produit->produit_nom = $contenuFormulaire['produit_nom'];
        $produit->produit_description = $contenuFormulaire['produit_description'];

        $produit->save();
        return $this->index($request);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $ids = $request->input('ids');
        $message = "Le ou les produits on été supprimer";
        foreach ($ids as $id) {
            if (Produit::find($id) != null) {
                Produit::destroy($id);
            } else {
                $message = " Le produit avec l'id " . $id . " n'existe pas";
            }
        }
        if ($message != "Le ou les produits on été supprimer") {
            return response()->json(['ECHEC' => $message], 400);
        }
        return response()->json(['SUCCES' => $message], 200);
    }
    public function showFiltreId(Request $request, int $id)
    {
        $produits = Produit::where("produit_id", 'LIKE', '%' . $id . '%')->get("produit_id");
        return response()->json($produits, 200);
    }
    public function showFiltreName(Request $request, string $name)
    {
        $produits = Produit::where("produit_nom",  'LIKE', '%' . $name . '%')->get("produit_id");
        return response()->json($produits, 200);
    }
}
