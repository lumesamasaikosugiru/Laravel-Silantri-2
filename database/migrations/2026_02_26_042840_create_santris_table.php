<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use function Laravel\Prompts\table;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('santris', function (Blueprint $table) {
            $table->id();
            $table->string('nisn', 10)->unique();
            $table->string('name', 50);
            $table->enum('gender', ['l', 'p']);
            $table->date('date_birth');
            $table->string('address_street', 50);
            $table->string('address_district', 50);
            $table->string('address_city', 50);
            $table->foreignId('classroom_id')->nullable()->constrained()->nullOnDelete();
            $table->enum('status', ['active', 'nonactive'])->default('active');
            $table->string('file_path')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('santris');
    }
};
