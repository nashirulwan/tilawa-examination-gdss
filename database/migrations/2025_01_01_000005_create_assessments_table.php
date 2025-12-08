<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('assessments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('appraiser_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('participant_id')->constrained()->cascadeOnDelete();
            $table->foreignId('criteria_id')->constrained('criteria')->cascadeOnDelete();
            $table->foreignId('sub_criteria_id')->nullable()->constrained('sub_criteria')->nullOnDelete();
            $table->float('value'); // The numerical value (e.g. 85 or 65)
            $table->timestamps();

            $table->unique(['appraiser_id', 'participant_id', 'criteria_id'], 'unique_assessment');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('assessments');
    }
};
