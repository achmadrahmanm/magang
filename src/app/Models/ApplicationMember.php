<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ApplicationMember extends Model
{
    use HasFactory;

    protected $fillable = [
        'application_id',
        'student_id',
        'role',
        'notes',
        'joined_at',
    ];

    protected $casts = [
        'joined_at' => 'datetime',
    ];

    /**
     * Get the application this member belongs to
     */
    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class);
    }

    /**
     * Get the student for this member
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * Get the user through student relationship
     */
    public function user(): BelongsTo
    {
        return $this->student->user();
    }

    /**
     * Scope for leaders only
     */
    public function scopeLeaders($query)
    {
        return $query->where('role', 'leader');
    }

    /**
     * Scope for members only
     */
    public function scopeMembers($query)
    {
        return $query->where('role', 'member');
    }

    /**
     * Scope for specific application
     */
    public function scopeForApplication($query, int $applicationId)
    {
        return $query->where('application_id', $applicationId);
    }

    /**
     * Scope for specific student
     */
    public function scopeForStudent($query, int $studentId)
    {
        return $query->where('student_id', $studentId);
    }

    /**
     * Check if this member is the leader
     */
    public function isLeader(): bool
    {
        return $this->role === 'leader';
    }

    /**
     * Check if this member is a regular member
     */
    public function isMember(): bool
    {
        return $this->role === 'member';
    }

    /**
     * Get role display text
     */
    public function getRoleDisplayText(): string
    {
        return match($this->role) {
            'leader' => 'Ketua',
            'member' => 'Anggota',
            default => 'Unknown'
        };
    }

    /**
     * Get role badge class for UI
     */
    public function getRoleBadgeClass(): string
    {
        return match($this->role) {
            'leader' => 'badge-primary',
            'member' => 'badge-secondary',
            default => 'badge-light'
        };
    }

    /**
     * Static method to create a leader
     */
    public static function createLeader(int $applicationId, int $studentId, ?string $notes = null): self
    {
        return self::create([
            'application_id' => $applicationId,
            'student_id' => $studentId,
            'role' => 'leader',
            'notes' => $notes,
            'joined_at' => now(),
        ]);
    }

    /**
     * Static method to create a member
     */
    public static function createMember(int $applicationId, int $studentId, ?string $notes = null): self
    {
        return self::create([
            'application_id' => $applicationId,
            'student_id' => $studentId,
            'role' => 'member',
            'notes' => $notes,
            'joined_at' => now(),
        ]);
    }

    /**
     * Get student name through relationship
     */
    public function getStudentNameAttribute(): string
    {
        return $this->student->nama_resmi ?? 'Unknown';
    }

    /**
     * Get student NRP through relationship
     */
    public function getStudentNrpAttribute(): string
    {
        return $this->student->nrp ?? 'Unknown';
    }

    /**
     * Get student program through relationship
     */
    public function getStudentProgramAttribute(): string
    {
        return $this->student->prodi ?? 'Unknown';
    }
}