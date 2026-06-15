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
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->string('application_code', 30)->default('')->unique('uq_applications_code');
            $table->foreignId('recruitment_period_id')
                ->constrained('recruitment_periods', indexName: 'fk_applications_recruitment')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->foreignId('user_id')
                ->constrained('users', indexName: 'fk_applications_user')
                ->cascadeOnUpdate()
                ->restrictOnDelete();
            $table->text('motivation');
            $table->decimal('final_score', 5, 2)->nullable();
            $table->enum('application_status', ['submitted', 'under_review', 'interview', 'accepted', 'rejected', 'withdrawn'])->default('submitted');
            $table->string('reviewer_notes', 500)->nullable();
            $table->timestamp('submitted_at')->useCurrent();
            $table->dateTime('reviewed_at')->nullable();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();

            $table->unique(['recruitment_period_id', 'user_id'], 'uq_applications_recruitment_user');
            $table->index(
                ['recruitment_period_id', 'application_status', 'submitted_at'],
                'idx_applications_recruitment_status_date'
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};
