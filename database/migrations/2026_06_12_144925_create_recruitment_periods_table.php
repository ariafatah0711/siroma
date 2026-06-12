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
        Schema::create('recruitment_periods', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_id')
                ->constrained('organizations', indexName: 'fk_recruitment_periods_organization')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users', indexName: 'fk_recruitment_periods_creator')
                ->cascadeOnUpdate()
                ->nullOnDelete();
            $table->string('recruitment_title', 150);
            $table->string('academic_year', 9);
            $table->date('registration_start_date');
            $table->date('registration_end_date');
            $table->unsignedInteger('total_quota')->default(1);
            $table->enum('recruitment_status', ['draft', 'open', 'closed', 'completed'])->default('draft');
            $table->text('description')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();

            $table->index(
                ['organization_id', 'recruitment_status', 'registration_start_date', 'registration_end_date'],
                'idx_recruitment_periods_org_status_dates'
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recruitment_periods');
    }
};
