<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user', function (Blueprint $table) {
            $table->id('id_user');
            $table->string('name');
            $table->string('description')->nullable();
            $table->enum('type', ['project_owner', 'enterprise', 'supervisor']);
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->string('password');
            $table->string('token')->nullable()->unique();
            $table->dateTime('token_gentime')->nullable();
            $table->integer('siret');
            $table
                ->foreignId('id_enterprise')
                ->nullable()
                ->constrained('user', 'id_user')
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
        Schema::dropIfExists('user');
    }
}
