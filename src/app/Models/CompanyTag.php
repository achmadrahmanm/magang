<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CompanyTag extends Model
{
    protected $fillable = [
        'company_id',
        'tag',
    ];

    /**
     * Get the company this tag belongs to
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
}
