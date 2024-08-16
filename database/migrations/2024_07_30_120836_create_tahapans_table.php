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
        Schema::create('tahapans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_project')->constrained('projects')->cascadeOnDelete();
            $table->string('name');
            $table->date('tanggal_start');
            $table->date('deadline');
            $table->string('status');
            $table->string('persen')->nullable();
            $table->date('tgl_actual')->nullable();
            $table->string('hasil_tahapan')->nullable();
            $table->date('tgl_hasil')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tahapans');
    }
};
