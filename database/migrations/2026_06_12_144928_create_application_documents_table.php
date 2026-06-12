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
        Schema::create('application_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id')
                ->constrained('applications', indexName: 'fk_application_documents_application')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->enum('document_type', ['cv', 'portfolio', 'certificate', 'other'])->default('other');
            $table->string('original_file_name');
            $table->string('file_path', 512);
            $table->timestamp('uploaded_at')->useCurrent();

            $table->unique(['application_id', 'file_path'], 'uq_application_documents_path');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('application_documents');
    }
};
