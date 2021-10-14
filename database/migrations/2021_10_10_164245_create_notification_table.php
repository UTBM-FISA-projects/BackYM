<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateNotificationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notification', function (Blueprint $table) {
            $table->id('id_notification');
            $table->dateTime('creation')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->boolean('is_read')->nullable();
            $table->json('parameters');
            $table
                ->foreignId('id_recipient')
                ->constrained('user', 'id_user')
                ->onDelete('cascade');
            $table
                ->foreignId('id_notification_type')
                ->constrained('notification_type', 'id_notification_type')
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
        Schema::dropIfExists('notification');
    }
}
