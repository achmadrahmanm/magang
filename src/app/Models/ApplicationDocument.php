<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class ApplicationDocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'application_id',
        'document_type',
        'document_name',
        'file_path',
        'mime_type',
        'file_size',
        'description',
        'is_required',
        'is_verified',
        'verified_by',
        'verified_at',
        'uploaded_by',
    ];

    protected $casts = [
        'is_required' => 'boolean',
        'is_verified' => 'boolean',
        'verified_at' => 'datetime',
        'file_size' => 'integer',
    ];

    /**
     * Get the application this document belongs to
     */
    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class);
    }

    /**
     * Get the user who uploaded this document
     */
    public function uploadedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    /**
     * Get the user who verified this document
     */
    public function verifiedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    /**
     * Scope for specific document type
     */
    public function scopeOfType($query, string $type)
    {
        return $query->where('document_type', $type);
    }

    /**
     * Scope for required documents
     */
    public function scopeRequired($query)
    {
        return $query->where('is_required', true);
    }

    /**
     * Scope for verified documents
     */
    public function scopeVerified($query)
    {
        return $query->where('is_verified', true);
    }

    /**
     * Scope for unverified documents
     */
    public function scopeUnverified($query)
    {
        return $query->where('is_verified', false);
    }

    /**
     * Scope for specific application
     */
    public function scopeForApplication($query, int $applicationId)
    {
        return $query->where('application_id', $applicationId);
    }

    /**
     * Check if document is a PDF
     */
    public function isPdf(): bool
    {
        return $this->mime_type === 'application/pdf';
    }

    /**
     * Check if document is an image
     */
    public function isImage(): bool
    {
        return str_starts_with($this->mime_type, 'image/');
    }

    /**
     * Get file size in human readable format
     */
    public function getFileSizeHumanAttribute(): string
    {
        $bytes = $this->file_size;
        $units = ['B', 'KB', 'MB', 'GB'];
        
        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }
        
        return round($bytes, 2) . ' ' . $units[$i];
    }

    /**
     * Get file extension
     */
    public function getFileExtensionAttribute(): string
    {
        return pathinfo($this->document_name, PATHINFO_EXTENSION);
    }

    /**
     * Get download URL
     */
    public function getDownloadUrlAttribute(): string
    {
        return Storage::url($this->file_path);
    }

    /**
     * Get verification status display text
     */
    public function getVerificationStatusDisplayAttribute(): string
    {
        if ($this->is_verified) {
            return 'Terverifikasi';
        }
        return $this->is_required ? 'Belum Terverifikasi (Wajib)' : 'Belum Terverifikasi';
    }

    /**
     * Get verification badge class for UI
     */
    public function getVerificationBadgeClassAttribute(): string
    {
        if ($this->is_verified) {
            return 'badge-success';
        }
        return $this->is_required ? 'badge-danger' : 'badge-warning';
    }

    /**
     * Get document type display text
     */
    public function getDocumentTypeDisplayAttribute(): string
    {
        return match($this->document_type) {
            'purpose_letter' => 'Surat Permohonan',
            'cv' => 'Curriculum Vitae',
            'transcript' => 'Transkrip Nilai',
            'recommendation_letter' => 'Surat Rekomendasi',
            'identity_card' => 'Kartu Identitas',
            'student_card' => 'Kartu Mahasiswa',
            'portfolio' => 'Portfolio',
            'other' => 'Dokumen Lainnya',
            default => ucwords(str_replace('_', ' ', $this->document_type))
        };
    }

    /**
     * Mark document as verified
     */
    public function markAsVerified(int $verifiedBy, ?string $notes = null): bool
    {
        return $this->update([
            'is_verified' => true,
            'verified_by' => $verifiedBy,
            'verified_at' => now(),
            'description' => $notes ? $this->description . "\n\nVerification Notes: " . $notes : $this->description,
        ]);
    }

    /**
     * Mark document as unverified
     */
    public function markAsUnverified(?string $reason = null): bool
    {
        return $this->update([
            'is_verified' => false,
            'verified_by' => null,
            'verified_at' => null,
            'description' => $reason ? $this->description . "\n\nUnverification Reason: " . $reason : $this->description,
        ]);
    }

    /**
     * Delete file from storage when model is deleted
     */
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($document) {
            if (Storage::exists($document->file_path)) {
                Storage::delete($document->file_path);
            }
        });
    }
}