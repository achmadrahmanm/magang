<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BusinessField extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'name_en',
        'description',
        'icon',
        'color',
        'is_active',
        'sort_order',
        'metadata',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
        'metadata' => 'array',
    ];

    /**
     * Get applications that use this business field
     */
    public function applications(): HasMany
    {
        return $this->hasMany(Application::class, 'business_field', 'code');
    }

    /**
     * Scope for active business fields only
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for ordering by sort_order
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }

    /**
     * Scope for search by name or code
     */
    public function scopeSearch($query, string $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('name_en', 'like', "%{$search}%")
              ->orWhere('code', 'like', "%{$search}%")
              ->orWhere('description', 'like', "%{$search}%");
        });
    }

    /**
     * Get display name (with fallback to English)
     */
    public function getDisplayNameAttribute(): string
    {
        return $this->name ?: $this->name_en ?: $this->code;
    }

    /**
     * Get icon with default fallback
     */
    public function getDisplayIconAttribute(): string
    {
        return $this->icon ?: 'fas fa-building';
    }

    /**
     * Get color with default fallback
     */
    public function getDisplayColorAttribute(): string
    {
        return $this->color ?: '#6c757d';
    }

    /**
     * Check if this field is used by any applications
     */
    public function isUsedByApplications(): bool
    {
        return $this->applications()->exists();
    }

    /**
     * Get applications count
     */
    public function getApplicationsCountAttribute(): int
    {
        return $this->applications()->count();
    }

    /**
     * Static method to get active fields for select options
     */
    public static function getSelectOptions(): array
    {
        return static::active()
                    ->ordered()
                    ->get()
                    ->pluck('name', 'code')
                    ->toArray();
    }

    /**
     * Static method to get active fields with additional info
     */
    public static function getFormattedOptions(): array
    {
        return static::active()
                    ->ordered()
                    ->get()
                    ->map(function ($field) {
                        return [
                            'code' => $field->code,
                            'name' => $field->name,
                            'name_en' => $field->name_en,
                            'description' => $field->description,
                            'icon' => $field->display_icon,
                            'color' => $field->display_color,
                        ];
                    })
                    ->toArray();
    }

    /**
     * Get business field by code
     */
    public static function findByCode(string $code): ?self
    {
        return static::where('code', $code)->first();
    }

    /**
     * Create or update business field
     */
    public static function createOrUpdateField(array $data): self
    {
        return static::updateOrCreate(
            ['code' => $data['code']],
            $data
        );
    }

    /**
     * Toggle active status
     */
    public function toggleActive(): bool
    {
        $this->is_active = !$this->is_active;
        return $this->save();
    }

    /**
     * Update sort order
     */
    public function updateSortOrder(int $order): bool
    {
        $this->sort_order = $order;
        return $this->save();
    }
}