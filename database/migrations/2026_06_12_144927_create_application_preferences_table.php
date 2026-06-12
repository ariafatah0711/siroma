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
        Schema::create('application_preferences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id')
                ->constrained('applications', indexName: 'fk_application_preferences_application')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->foreignId('division_id')
                ->constrained('divisions', indexName: 'fk_application_preferences_division')
                ->cascadeOnUpdate()
                ->restrictOnDelete();
            $table->unsignedTinyInteger('preference_order');

            $table->unique(['application_id', 'division_id'], 'uq_application_preferences_division');
            $table->unique(['application_id', 'preference_order'], 'uq_application_preferences_order');
            $table->index(['division_id', 'preference_order'], 'idx_application_preferences_division_order');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('application_preferences');
    }
};
