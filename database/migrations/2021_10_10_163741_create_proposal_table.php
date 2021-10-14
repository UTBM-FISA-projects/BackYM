<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProposalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proposal', function (Blueprint $table) {
            $table->id('id_proposal');
            $table
                ->foreignId('id_yard')
                ->constrained('yard', 'id_yard')
                ->onDelete('cascade');
            $table
                ->foreignId('id_recipient')
                ->constrained('user', 'id_user')
                ->onDelete('cascade');
            $table->boolean('accepted')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('proposal');
    }
}
