<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserSignature extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'signature_path',
        'original_filename',
        'file_type',
        'file_size',
        'signature_data',
        'is_active',
        'purpose',
        'notes'
    ];

    protected $casts = [
        'signature_data' => 'array',
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * Get the user that owns the signature
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the full URL to the signature file
     */
    public function getSignatureUrlAttribute(): string
    {
        if ($this->signature_path) {
            return asset('storage/' . $this->signature_path);
        }
        return '';
    }

    /**
     * Get active signature for a user
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Get signatures by purpose
     */
    public function scopeByPurpose($query, $purpose)
    {
        return $query->where('purpose', $purpose);
    }

    /**
     * Get the latest signature for a user
     */
    public function scopeLatest($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    /**
     * Format file size for display
     */
    public function getFormattedFileSizeAttribute(): string
    {
        if (!$this->file_size) {
            return 'Unknown';
        }
        
        $bytes = $this->file_size;
        $units = ['B', 'KB', 'MB', 'GB'];
        
        for ($i = 0; $bytes > 1024; $i++) {
            $bytes /= 1024;
        }
        
        return round($bytes, 2) . ' ' . $units[$i];
    }
}