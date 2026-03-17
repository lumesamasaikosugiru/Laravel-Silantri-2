<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('santri_permissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('santri_id')->constrained('santris')->cascadeOnDelete();
            $table->enum('type', ['pulang', 'keluar', 'lainnya']);
            $table->date('date_started');
            $table->date('date_ended');
            $table->string('reason', 30);
            $table->enum('submitted_by', ['wali_santri', 'staf']);
            $table->string('wali_name', 30)->nullable();
            $table->string('wali_phone', 15)->nullable();
            $table->enum('wali_relation', [
                'ibu',
                'ayah',
                'saudara_kandung',
                'saudara_keluarga',
            ])->nullable();
            $table->enum('status', [
                'menunggu',
                'disetujui',
                'ditolak',
            ])->default('menunggu');
            $table->foreignId('inputed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->date('date_approved')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('santri_permissions');
    }
};
