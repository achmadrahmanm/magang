<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nrp',
        'nama_resmi',
        'email_kampus',
        'prodi',
        'fakultas',
        'angkatan',
        'semester_berjalan',
        'sks_total',
        'status_akademik'
    ];

    protected $casts = [
        'semester_berjalan' => 'integer',
        'sks_total' => 'integer',
        'status_akademik' => 'string',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * Get the user that owns the student record
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all application memberships for this student
     */
    public function applicationMemberships(): HasMany
    {
        return $this->hasMany(ApplicationMember::class);
    }

    /**
     * Get applications through application members
     */
    public function applications(): BelongsToMany
    {
        return $this->belongsToMany(Application::class, 'application_members')
                    ->withPivot(['role', 'notes', 'joined_at'])
                    ->withTimestamps();
    }

    /**
     * Get applications where this student is the leader
     */
    public function ledApplications(): BelongsToMany
    {
        return $this->applications()->wherePivot('role', 'leader');
    }

    /**
     * Get applications where this student is a member
     */
    public function memberApplications(): BelongsToMany
    {
        return $this->applications()->wherePivot('role', 'member');
    }

    /**
     * Scope to filter by active status
     */
    public function scopeActive($query)
    {
        return $query->where('status_akademik', 'aktif');
    }

    /**
     * Scope to filter by program of study
     */
    public function scopeByProdi($query, $prodi)
    {
        return $query->where('prodi', $prodi);
    }

    /**
     * Scope to filter by faculty
     */
    public function scopeByFakultas($query, $fakultas)
    {
        return $query->where('fakultas', $fakultas);
    }

    /**
     * Scope to filter by academic year
     */
    public function scopeByAngkatan($query, $angkatan)
    {
        return $query->where('angkatan', $angkatan);
    }

    /**
     * Scope to filter by academic status
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status_akademik', $status);
    }

    /**
     * Get academic status badge class
     */
    public function getStatusBadgeAttribute(): string
    {
        return match($this->status_akademik) {
            'aktif' => 'badge-success',
            'cuti' => 'badge-warning',
            'lulus' => 'badge-primary',
            'nonaktif' => 'badge-danger',
            default => 'badge-secondary'
        };
    }

    /**
     * Get academic status display text
     */
    public function getStatusDisplayAttribute(): string
    {
        return match($this->status_akademik) {
            'aktif' => 'Aktif',
            'cuti' => 'Cuti',
            'lulus' => 'Lulus',
            'nonaktif' => 'Non-Aktif',
            default => ucfirst($this->status_akademik)
        };
    }

    /**
     * Get semester display
     */
    public function getSemesterDisplayAttribute(): string
    {
        if (!$this->semester_berjalan) {
            return 'Belum ditentukan';
        }
        return "Semester {$this->semester_berjalan}";
    }

    /**
     * Get SKS progress percentage
     */
    public function getSksProgressAttribute(): int
    {
        if (!$this->sks_total) {
            return 0;
        }
        
        // Assuming 144 SKS as graduation requirement (can be configurable)
        $requiredSks = 144;
        return min(100, round(($this->sks_total / $requiredSks) * 100));
    }

    /**
     * Check if student is eligible for internship
     */
    public function isEligibleForInternship(): bool
    {
        return $this->status_akademik === 'aktif' && 
               $this->semester_berjalan >= 6 && 
               $this->sks_total >= 100;
    }

    /**
     * Get academic year from angkatan
     */
    public function getAcademicYearAttribute(): string
    {
        if (!$this->angkatan) {
            return 'Unknown';
        }
        
        $startYear = (int) $this->angkatan;
        $endYear = $startYear + 4; // Assuming 4-year program
        
        return "{$startYear}/{$endYear}";
    }

    /**
     * Get full name with NRP
     */
    public function getFullNameWithNrpAttribute(): string
    {
        return "{$this->nama_resmi} ({$this->nrp})";
    }

    /**
     * Static method to get available status options
     */
    public static function getStatusOptions(): array
    {
        return [
            'aktif' => 'Aktif',
            'cuti' => 'Cuti',
            'lulus' => 'Lulus',
            'nonaktif' => 'Non-Aktif'
        ];
    }

    /**
     * Static method to get available faculties
     */
    public static function getFakultasOptions(): array
    {
        return [
            'Fakultas Teknologi Informasi dan Komunikasi' => 'FTIK',
            'Fakultas Teknik Sipil, Perencanaan, dan Kebumian' => 'FTSPK',
            'Fakultas Teknologi Industri dan Rekayasa Sistem' => 'FTIRS',
            'Fakultas Teknologi Kelautan' => 'FTK',
            'Fakultas Teknologi Elektro dan Informatika Cerdas' => 'FTEIC',
            'Fakultas Sains dan Analitika Data' => 'FSAD',
            'Fakultas Desain Kreatif dan Bisnis Digital' => 'FDKBD',
            'Fakultas Vokasi' => 'FV'
        ];
    }

    /**
     * Static method to get prodi options by fakultas
     */
    public static function getProdiByFakultas(string $fakultas): array
    {
        $prodiMapping = [
            'Fakultas Teknologi Informasi dan Komunikasi' => [
                'Teknik Informatika',
                'Sistem Informasi',
                'Teknologi Informasi',
                'Teknik Komputer'
            ],
            'Fakultas Teknik Sipil, Perencanaan, dan Kebumian' => [
                'Teknik Sipil',
                'Arsitektur',
                'Teknik Lingkungan',
                'Perencanaan Wilayah dan Kota',
                'Teknik Geomatika'
            ],
            // Add more mappings as needed
        ];

        return $prodiMapping[$fakultas] ?? [];
    }
}