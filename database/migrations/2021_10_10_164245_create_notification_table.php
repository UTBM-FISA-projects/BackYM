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
            $table
                ->foreignId('id_destinataire')
                ->constrained('utilisateur', 'id_utilisateur')
                ->onDelete('cascade');
            $table
                ->foreignId('id_type_notification')
                ->constrained('type_notification', 'id_type_notification')
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
