<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ApplicationDocument extends Model
{
    /** @use HasFactory<\Database\Factories\ApplicationDocumentFactory> */
    use HasFactory;

    public const CREATED_AT = 'uploaded_at';
    public const UPDATED_AT = null;

    protected $fillable = [
        'application_id',
        'document_type',
        'original_file_name',
        'file_path',
    ];

    protected function casts(): array
    {
        return [
            'uploaded_at' => 'datetime',
        ];
    }

    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class);
    }
}
