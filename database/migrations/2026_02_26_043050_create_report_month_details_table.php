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
        Schema::create('report_month_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('report_month_id')->constrained('report_months')->cascadeOnDelete();
            $table->foreignId('santri_id')->constrained('santris')->cascadeOnDelete();
            $table->enum('type', ['sakit', 'ijin', 'pelanggaran']);
            $table->enum('source_table', [
                'santri_sicks',
                'santri_permissions',
                'violation_details',
            ]);
            $table->unsignedBigInteger('source_id');
            $table->date('date');
            $table->text('summary_text')->nullable();
            $table->index(['source_table', 'source_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('report_month_details');
    }
};
