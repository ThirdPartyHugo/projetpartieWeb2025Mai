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
        Schema::create('commandes', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->bigIncrements('commande_id');

            $table->float('commande_total');
            $table->dateTime('commande_date');

            $table->unsignedSmallInteger('statut_id');

        });

        Schema::table("commandes", function (Blueprint $table)
        {
            $table->foreign("statut_id")->references("statut_id")->on("statuts");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commandes');
    }
};
