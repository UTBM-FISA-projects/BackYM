<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUtilisateurTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('utilisateur', function (Blueprint $table) {
            $table->id('id_utilisateur');
            $table->string('nom');
            $table->string('description')->nullable();
            $table->enum('type', ['moa', 'ets', 'cdt']);
            $table->string('mail')->unique();
            $table->string('telephone')->nullable();
            $table->string('password');
            $table->string('token')->nullable();
            $table->dateTime('token_gentime')->nullable();
            $table
                ->foreignId('id_entreprise')
                ->nullable()
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
        Schema::dropIfExists('utilisateur');
    }
}
