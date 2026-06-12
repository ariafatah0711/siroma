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
        Schema::create('divisions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_id')
                ->constrained('organizations', indexName: 'fk_divisions_organization')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->string('division_name', 100);
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);

            $table->unique(['organization_id', 'division_name'], 'uq_divisions_organization_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('divisions');
    }
};
