<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ApplicationStatusHistory extends Model
{
    /** @use HasFactory<\Database\Factories\ApplicationStatusHistoryFactory> */
    use HasFactory;

    public const CREATED_AT = 'changed_at';
    public const UPDATED_AT = null;

    protected $table = 'application_status_history';

    protected $fillable = [
        'application_id',
        'application_code',
        'old_status',
        'new_status',
        'change_note',
    ];

    protected function casts(): array
    {
        return [
            'changed_at' => 'datetime',
        ];
    }

    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class);
    }
}
