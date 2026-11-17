<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->dropColumn([
                'judul_deskripsi',
                'judul_point',
                'point',
                'content',
            ]);
        });
    }

    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->text('judul_deskripsi')->nullable();
            $table->text('judul_point')->nullable();
            $table->text('point')->nullable();
            $table->longText('content')->nullable();
        });
    }
};