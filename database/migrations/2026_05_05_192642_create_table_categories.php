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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');                      // contoh: "SKI", "Fiqih", "Aqidah"
            $table->string('slug')->unique();            // contoh: "ski", "fiqih"
            $table->text('description')->nullable();
            $table->string('icon')->nullable();          // nama icon atau path gambar
            $table->string('color')->nullable();         // hex color buat UI, contoh: "#4F46E5"
            $table->integer('order')->default(0);        // urutan tampil
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
