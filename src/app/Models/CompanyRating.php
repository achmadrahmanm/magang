<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CompanyRating extends Model
{
    protected $fillable = [
        'company_id',
        'rating',
        'notes',
        'rated_by',
    ];

    /**
     * Get the company this rating belongs to
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Get the user who gave this rating
     */
    public function ratedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'rated_by');
    }
}
