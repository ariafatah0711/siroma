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
        Schema::create('application_status_history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id')
                ->nullable()
                ->constrained('applications', indexName: 'fk_application_status_history_application')
                ->cascadeOnUpdate()
                ->nullOnDelete();
            $table->string('application_code', 30);
            $table->string('old_status', 30)->nullable();
            $table->string('new_status', 30);
            $table->string('change_note', 500)->nullable();
            $table->timestamp('changed_at')->useCurrent();

            $table->index(['application_id', 'changed_at'], 'idx_application_status_history_app_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('application_status_history');
    }
};
