<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RecruitmentPeriod extends Model
{
    /** @use HasFactory<\Database\Factories\RecruitmentPeriodFactory> */
    use HasFactory;

    protected $fillable = [
        'organization_id',
        'created_by',
        'recruitment_title',
        'academic_year',
        'registration_start_date',
        'registration_end_date',
        'total_quota',
        'recruitment_status',
        'description',
    ];

    protected function casts(): array
    {
        return [
            'registration_start_date' => 'date',
            'registration_end_date' => 'date',
            'total_quota' => 'integer',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function applications(): HasMany
    {
        return $this->hasMany(Application::class);
    }
}
