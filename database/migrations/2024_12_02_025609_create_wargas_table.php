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
        Schema::create('warga', function (Blueprint $table) {
            $table->id();
            $table->string('no_kk', 50)->unique();
            $table->string('nik', 50)->unique();
            $table->string('nama', 50);
            $table->string('tempat_lahir', 50);
            $table->char('Jenis_Kelamin', 1);
            $table->date('tgl_lahir');
            $table->integer('Anak_ke')->nullable(); // Make nullable if it's optional
            $table->integer('relasi_keluarga_id')->nullable(); // Make nullable if it's optional
            $table->string('alamat', 255);
            $table->string('rt_alamat', 2);
            $table->string('no_telp_hp', 20);
            $table->boolean('is_deleted')->default(false); // Default to false if not deleted
            $table->boolean('is_meninggal')->default(false); // Default to false if not deceased
            
            // Automatically add created_at and updated_at timestamps
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('warga');
    }
};