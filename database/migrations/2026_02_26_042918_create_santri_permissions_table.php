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
            $table->string('ticket_permission');
            $table->dateTime('date_started');
            $table->unique(['santri_id', 'date_started', 'ticket_permission'], 'santri_perm_unique');
            $table->dateTime('date_ended');
            $table->string('reason', 50);
            $table->enum('submitted_by', ['wali_santri', 'staf']);
            $table->string('wali_name', 30)->nullable();
            $table->string('wali_phone', 20)->nullable();
            $table->enum('wali_relation', [
                'orangtua',
                'saudara_kandung',
                'saudara_keluarga',
            ])->nullable();
            $table->enum('status', [
                'menunggu',
                'disetujui',
                'ditolak',
                'expired',
            ])->default('menunggu');
            $table->string('description', 50)->nullable();
            $table->foreignId('inputed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->dateTime('date_approved')->nullable();
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
