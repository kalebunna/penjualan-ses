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
        Schema::create('forcas_result', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parameter_id')->constrained('parameters')->cascadeOnDelete();
            $table->double('actual');
            $table->float('MAP');
            $table->double('forcas_result');
            $table->double('MAD');
            $table->double('MSE');
            $table->double('err');
            $table->date('preode');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('forcas_result');
    }
};
