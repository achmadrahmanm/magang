<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Application extends Model
{
    use HasFactory;

    protected $fillable = [
        'program_id',
        'internship_id',
        'company_id',
        'institution_name',
        'institution_address',
        'business_field',
        'placement_division',
        'division',
        'planned_start_date',
        'planned_end_date',
        'purpose_letter_path',
        'notes',
        'status',
        'status_note',
        'reviewed_by',
        'reviewed_at',
        'rejection_reason',
        'submitted_by',
    ];

    protected $casts = [
        'planned_start_date' => 'date',
        'planned_end_date' => 'date',
        'reviewed_at' => 'datetime',
    ];

    /**
     * Get the user who submitted this application
     */
    public function submittedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'submitted_by');
    }

    /**
     * Get the user who reviewed this application
     */
    public function reviewedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    /**
     * Get all members of this application
     */
    public function members(): HasMany
    {
        return $this->hasMany(ApplicationMember::class);
    }

    /**
     * Get students through application members
     */
    public function students(): BelongsToMany
    {
        return $this->belongsToMany(Student::class, 'application_members')
            ->withPivot(['role', 'notes', 'joined_at'])
            ->withTimestamps();
    }

    /**
     * Get the leader of this application
     */
    public function leader()
    {
        return $this->members()->where('role', 'leader')->with('student')->first();
    }

    /**
     * Get all documents for this application
     */
    public function documents(): HasMany
    {
        return $this->hasMany(ApplicationDocument::class);
    }

    /**
     * Get documents by type
     */
    public function getDocumentsByType(string $type)
    {
        return $this->documents()->where('document_type', $type)->get();
    }

    /**
     * Check if application has required documents
     */
    public function hasRequiredDocuments(): bool
    {
        $requiredCount = $this->documents()->where('is_required', true)->count();
        return $requiredCount > 0;
    }

    /**
     * Check if all required documents are verified
     */
    public function allRequiredDocumentsVerified(): bool
    {
        $requiredDocs = $this->documents()->where('is_required', true);
        return $requiredDocs->count() > 0 &&
            $requiredDocs->where('is_verified', true)->count() === $requiredDocs->count();
    }

    /**
     * Scope for filtering by status
     */
    public function scopeByStatus($query, string $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope for applications submitted by user
     */
    public function scopeSubmittedBy($query, int $userId)
    {
        return $query->where('submitted_by', $userId);
    }

    /**
     * Scope for applications in date range
     */
    public function scopeInDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('planned_start_date', [$startDate, $endDate]);
    }

    /**
     * Get duration in days
     */
    public function getDurationInDays(): int
    {
        return $this->planned_start_date->diffInDays($this->planned_end_date);
    }

    /**
     * Check if application can be edited
     */
    public function canBeEdited(): bool
    {
        return in_array($this->status, ['draft', 'submitted', 'rejected']);
    }

    /**
     * Check if application can be reviewed
     */
    public function canBeReviewed(): bool
    {
        return $this->status === 'submitted';
    }

    /**
     * Get status badge class for UI
     */
    public function getStatusBadgeClass(): string
    {
        return match ($this->status) {
            'draft' => 'badge-secondary',
            'submitted' => 'badge-warning',
            'reviewing' => 'badge-info',
            'approved' => 'badge-success',
            'rejected' => 'badge-danger',
            default => 'badge-secondary'
        };
    }

    /**
     * Get status display text
     */
    public function getStatusDisplayText(): string
    {
        return match ($this->status) {
            'draft' => 'Draft',
            'submitted' => 'Diajukan',
            'reviewing' => 'Dalam Review',
            'approved' => 'Disetujui',
            'rejected' => 'Ditolak',
            default => 'Unknown'
        };
    }
}
