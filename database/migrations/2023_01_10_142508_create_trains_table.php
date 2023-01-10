<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trains', function (Blueprint $table) {
            $table->id();
            $table->string('azienda', 20);
            $table->string('stazione_di_partenza', 40);
            $table->string('stazione_di_arrivo', 40);
            $table->time('orario_di_partenza');
            $table->time('orario_di_arrivo');
            $table->string('tipo_treno');
            $table->smallInteger('codice_treno');
            $table->tinyInteger('numero_carrozze')->nullable();
            $table->tinyInteger('in_orario')->default(1);
            /*
            azineda
            stazione di partenza
            stazione di arrivo
            orario di partenza
            orario di arrivo
            codice treno
            numero carrozze
            in orario
            cancellato DIMENTICATO
            */
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trains');
    }
};
