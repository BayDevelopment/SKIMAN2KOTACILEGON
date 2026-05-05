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
        // Satu materi bisa punya BANYAK video
        Schema::create('material_videos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('material_id')->constrained()->cascadeOnDelete();
            $table->string('title');                     // judul video
            $table->string('youtube_url');               // link YT asli: https://youtu.be/xxx
            $table->string('youtube_id');                // ID video: dQw4w9WgXcQ (buat embed)
            $table->text('description')->nullable();
            $table->integer('order')->default(0);        // urutan video dalam materi
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('material_videos');
    }
};
