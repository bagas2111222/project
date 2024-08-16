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
        Schema::create('details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_tahapan')->constrained('tahapans')->cascadeOnDelete();
            $table->string('name');
            $table->string('desc');
            $table->string('status');
            $table->date('deadline');
            $table->string('hasil')->nullable();
            $table->date('tgl_kumpul')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('details');
    }
};
