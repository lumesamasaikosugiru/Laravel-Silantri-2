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
        Schema::create('report_month_summaries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('report_month_id')->constrained('report_months')->cascadeOnDelete();
            $table->unsignedBigInteger('total_sicks');
            $table->unsignedBigInteger('total_violations');
            $table->unsignedBigInteger('total_permissions');
            $table->unsignedBigInteger('total_points');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('report_month_summaries');
    }
};
