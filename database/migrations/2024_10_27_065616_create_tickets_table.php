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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string('ticket_number')->unique();
            $table->enum('ticket_status', ['waiting', 'in_progress', 'completed', 'canceled'])->default('waiting');
            $table->unsignedBigInteger('service_id');
            $table->unsignedBigInteger('counter_id');
            $table->foreign('service_id')->references('id')->on('services')->cascadeOnDelete();
            $table->foreign('counter_id')->references('id')->on('counters')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
