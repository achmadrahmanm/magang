<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
        'business_field',
        'placement_divisions',
        'website',
        'is_verified',
        'status',
        'source',
        'notes',
        'created_by',
    ];

    protected $casts = [
        'is_verified' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get applications for this company
     */
    public function applications(): HasMany
    {
        return $this->hasMany(Application::class);
    }

    /**
     * Get contacts for this company
     */
    public function contacts(): HasMany
    {
        return $this->hasMany(CompanyContact::class);
    }

    /**
     * Get MOUs for this company
     */
    public function mous(): HasMany
    {
        return $this->hasMany(CompanyMou::class);
    }

    /**
     * Get tags for this company
     */
    public function tags(): HasMany
    {
        return $this->hasMany(CompanyTag::class);
    }

    /**
     * Get ratings for this company
     */
    public function ratings(): HasMany
    {
        return $this->hasMany(CompanyRating::class);
    }

    /**
     * Get the user who created this company
     */
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Scope for verified companies
     */
    public function scopeVerified($query)
    {
        return $query->where('is_verified', true);
    }

    /**
     * Scope for active companies
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Check if company is verified
     */
    public function isVerified(): bool
    {
        return $this->is_verified;
    }

    /**
     * Check if company is active
     */
    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    /**
     * Get status badge class for UI
     */
    public function getStatusBadgeClass(): string
    {
        return match ($this->status) {
            'active' => 'badge-success',
            'inactive' => 'badge-secondary',
            'blacklisted' => 'badge-danger',
            default => 'badge-light'
        };
    }

    /**
     * Get status display text
     */
    public function getStatusDisplayText(): string
    {
        return match ($this->status) {
            'active' => 'Active',
            'inactive' => 'Inactive',
            'blacklisted' => 'Blacklisted',
            default => 'Unknown'
        };
    }
}
