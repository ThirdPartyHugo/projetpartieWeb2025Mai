<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProduitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('produits')->insert([
            [
                'produit_nom' => 'Crayon de mine',
                'produit_description' => 'Paquet de 10 crayons de marque HB',
                'produit_prix' => 5.00,
                'produit_image' => "coffee_machine.jpg"
            ],
            [
                'produit_nom' => 'papier',
                'produit_description' => 'Paquet de 10 feuilles',
                'produit_prix' => 50.00,
                'produit_image' => "coffee_machine.jpg"
            ],
            [
                'produit_nom' => 'Calculatrice',
                'produit_description' => 'Calculatrice de comptabilité',
                'produit_prix' => 12.99,
                'produit_image' => "coffee_machine.jpg"
            ],
            [
                'produit_nom' => 'Aiguisoir électrique',
                'produit_description' => 'Aiguisoir électrique de marque GE',
                'produit_prix' => 22.98,
                'produit_image' => "coffee_machine.jpg"
            ],
        ]);
    }
}
