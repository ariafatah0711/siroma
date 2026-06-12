<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Organization extends Model
{
    /** @use HasFactory<\Database\Factories\OrganizationFactory> */
    use HasFactory;

    public const UPDATED_AT = null;

    protected $fillable = [
        'organization_code',
        'organization_name',
        'description',
        'contact_email',
        'contact_phone',
    ];

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
        ];
    }

    public function divisions(): HasMany
    {
        return $this->hasMany(Division::class);
    }

    public function members(): HasMany
    {
        return $this->hasMany(OrganizationMember::class);
    }

    public function recruitmentPeriods(): HasMany
    {
        return $this->hasMany(RecruitmentPeriod::class);
    }
}
