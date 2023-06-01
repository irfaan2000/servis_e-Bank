<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sedekahs', function (Blueprint $table) {
            $table->id();
            $table->integer('id_user');
            $table->integer('id_outlite');
            $table->string('nama_sampah');
            $table->string('foto');
            $table->string('opsi');
            $table->double('lat')->nullable();
            $table->double('lng')->nullable();
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sedekahs');
    }
};
