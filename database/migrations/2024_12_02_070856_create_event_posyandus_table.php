<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_posyandus', function (Blueprint $table) {
            $table->id();
            $table->string('event_name');
            $table->string('lokasi');
            $table->date('start_datetime');
            $table->date('end_datetime');
            $table->json('foto_event');
        
            $table->timestamps();
            
            $table->boolean('is_deleted');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('event_posyandus');
    }
};