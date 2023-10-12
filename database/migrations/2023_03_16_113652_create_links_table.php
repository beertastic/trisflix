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
        Schema::create('links', function (Blueprint $table) {
            $table->id();
            $table->integer('owner');
            $table->string('slug')->unique();
            $table->timestamp('expires_at');
            $table->string('pass');
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('link_items', function (Blueprint $table) {
            $table->id();
            $table->integer('link_id');
            $table->integer('file_id');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('links');
        Schema::dropIfExists('link_items');
    }
};
