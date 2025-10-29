<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CompanyContact extends Model
{
    protected $fillable = [
        'company_id',
        'name',
        'email',
        'phone',
        'role_title',
        'is_primary',
    ];

    protected $casts = [
        'is_primary' => 'boolean',
    ];

    /**
     * Get the company this contact belongs to
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
}
