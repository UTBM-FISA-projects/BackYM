<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePropositionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proposition', function (Blueprint $table) {
            $table->id('id_proposition');
            $table
                ->foreignId('id_chantier')
                ->constrained('chantier', 'id_chantier')
                ->onDelete('cascade');
            $table
                ->foreignId('id_destinataire')
                ->constrained('utilisateur', 'id_utilisateur')
                ->onDelete('cascade');
            $table->boolean('accepter')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('proposition');
    }
}
