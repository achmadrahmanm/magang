<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CompanyMou extends Model
{
    protected $fillable = [
        'company_id',
        'mou_number',
        'start_date',
        'end_date',
        'file_path',
        'status',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    /**
     * Get the company this MOU belongs to
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
}
