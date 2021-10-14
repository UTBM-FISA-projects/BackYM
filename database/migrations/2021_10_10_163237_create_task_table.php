<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaskTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('task', function (Blueprint $table) {
            $table->id('id_task');
            $table->string('title');
            $table->string('description')->nullable();
            $table->enum('state', ['todo', 'doing', 'done'])->default('todo');
            $table->time('estimated_time')->nullable();
            $table->time('time_spent')->nullable();
            $table->date('start_planned_date')->nullable();
            $table->date('end_planned_date')->nullable();
            $table->boolean('supervisor_validated')->nullable();
            $table->boolean('executor_validated')->nullable();
            $table
                ->foreignId('id_executor')
                ->nullable()
                ->constrained('user', 'id_user')
                ->onDelete('set null');
            $table
                ->foreignId('id_yard')
                ->constrained('yard', 'id_yard')
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
        Schema::dropIfExists('task');
    }
}
