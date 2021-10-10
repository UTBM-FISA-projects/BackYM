<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDisponibiliteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('disponibilite', function (Blueprint $table) {
            $table->id('id_disponibilite');
            $table->dateTime('start');
            $table->dateTime('end');
            $table
                ->foreignId('id_utilisateur')
                ->constrained('utilisateur', 'id_utilisateur')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('disponibilite');
    }
}
