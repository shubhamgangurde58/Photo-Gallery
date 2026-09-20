<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   
    public function up(): void
    {
            Schema::create('photos', function (Blueprint $table) {
                $table->id();
                $table->foreignId('album_id')->constrained()->cascadeOnDelete();
                $table->string('original_name');
                $table->string('path');
                $table->string('thumbnail_path');
                $table->unsignedInteger('width');
                $table->unsignedInteger('height');
                $table->unsignedBigInteger('size');
                $table->timestamps();
            });
    }

    public function down(): void
    {
        Schema::dropIfExists('photos');
    }
};
