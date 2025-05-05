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
        Schema::create('modes_payements', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->bigIncrements('payement_id');

            $table->string('payement_no_carte', 16);
            $table->dateTime('payement_expiration');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('modes_payements');
    }
};
