<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateYardTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('yard', function (Blueprint $table) {
            $table->id('id_yard');
            $table->string('name');
            $table->string('description')->nullable();
            $table->dateTime('deadline')->nullable();
            $table->boolean('archived')->nullable();
            $table
                ->foreignId('id_project_owner')
                ->constrained('user', 'id_user')
                ->onDelete('cascade');
            $table
                ->foreignId('id_supervisor')
                ->nullable()
                ->constrained('user', 'id_user')
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
        Schema::dropIfExists('yard');
    }
}
