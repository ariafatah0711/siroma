<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ApplicationPreference extends Model
{
    /** @use HasFactory<\Database\Factories\ApplicationPreferenceFactory> */
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'application_id',
        'division_id',
        'preference_order',
    ];

    protected function casts(): array
    {
        return [
            'preference_order' => 'integer',
        ];
    }

    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class);
    }

    public function division(): BelongsTo
    {
        return $this->belongsTo(Division::class);
    }
}
