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
        Schema::create('organization_members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_id')
                ->constrained('organizations', indexName: 'fk_organization_members_organization')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->foreignId('user_id')
                ->constrained('users', indexName: 'fk_organization_members_user')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->enum('member_role', ['chairperson', 'recruitment_admin', 'interviewer', 'member'])->default('member');
            $table->date('joined_at');
            $table->boolean('is_active')->default(true);

            $table->unique(['organization_id', 'user_id'], 'uq_organization_members');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('organization_members');
    }
};
