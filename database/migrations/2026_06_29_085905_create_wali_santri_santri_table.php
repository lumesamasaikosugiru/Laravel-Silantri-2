<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('wali_santri_santri', function (Blueprint $table) {
            $table->id();
            $table->foreignId('wali_santri_id')->constrained('wali_santris')->cascadeOnDelete();
            $table->foreignId('santri_id')->constrained('santris')->cascadeOnDelete();
            $table->enum('relation', [
                'orangtua',
                'saudara_kandung',
                'saudara_keluarga',
            ]);
            $table->unique(['wali_santri_id', 'santri_id'], 'wali_santri_unique');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('wali_santri_santri');
    }
};