<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('commandes_produits', function (Blueprint $table) {

            $table->engine = 'InnoDB';

            $table->unsignedBigInteger('commande_id');
            $table->unsignedBigInteger('produit_id');

            $table->integer('qte');


            $table->primary(['commande_id', 'produit_id']);

        });

        Schema::table("commandes_produits", function (Blueprint $table)
        {
            $table->foreign("commande_id")->references("commande_id")->on("commandes")->onDelete("cascade");
            $table->foreign("produit_id")->references("produit_id")->on("produits")->onDelete("cascade");

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commandes_produits');
    }
};
