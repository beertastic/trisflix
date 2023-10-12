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
        Schema::create('media_paths', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->enum('media', ['movie', 'tv']);
            $table->integer('media_id')->nullable();
            $table->string('path')->nullable();
            $table->timestamps();


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tv_paths');
    }
};
