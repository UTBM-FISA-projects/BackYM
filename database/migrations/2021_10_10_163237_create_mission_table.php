<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMissionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mission', function (Blueprint $table) {
            $table->id('id_mission');
            $table->string('titre');
            $table->string('description')->nullable();
            $table->enum('etat', ['todo', 'doing', 'done'])->default('todo');
            $table->time('temps_estime')->nullable();
            $table->time('temps_passe')->nullable();
            $table->date('debut_date_prevu')->nullable();
            $table->date('fin_date_prevu')->nullable();
            $table->boolean('valider_cdt')->nullable();
            $table->boolean('valider_executant')->nullable();
            $table
                ->foreignId('id_executant')
                ->nullable()
                ->constrained('utilisateur', 'id_utilisateur')
                ->onDelete('set null');
            $table
                ->foreignId('id_chantier')
                ->constrained('chantier', 'id_chantier')
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
        Schema::dropIfExists('mission');
    }
}
