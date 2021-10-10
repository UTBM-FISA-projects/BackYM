<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChantierTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chantier', function (Blueprint $table) {
            $table->id('id_chantier');
            $table->string('nom');
            $table->string('description')->nullable();
            $table->dateTime('deadline')->nullable();
            $table->boolean('archiver')->nullable();
            $table
                ->foreignId('id_moa')
                ->constrained('utilisateur', 'id_utilisateur')
                ->onDelete('cascade');
            $table
                ->foreignId('id_cdt')
                ->nullable()
                ->constrained('utilisateur', 'id_utilisateur')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('chantier');
    }
}
