<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Application extends Model
{
    /** @use HasFactory<\Database\Factories\ApplicationFactory> */
    use HasFactory;

    public const CREATED_AT = 'submitted_at';

    protected $fillable = [
        'application_code',
        'recruitment_period_id',
        'user_id',
        'motivation',
        'final_score',
        'application_status',
        'reviewer_notes',
        'reviewed_at',
    ];

    protected function casts(): array
    {
        return [
            'final_score' => 'decimal:2',
            'submitted_at' => 'datetime',
            'reviewed_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    public function recruitmentPeriod(): BelongsTo
    {
        return $this->belongsTo(RecruitmentPeriod::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function preferences(): HasMany
    {
        return $this->hasMany(ApplicationPreference::class);
    }

    public function documents(): HasMany
    {
        return $this->hasMany(ApplicationDocument::class);
    }

    public function statusHistory(): HasMany
    {
        return $this->hasMany(ApplicationStatusHistory::class);
    }
}
