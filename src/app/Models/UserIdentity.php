<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserIdentity extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'email',
        'campus_id',
        'department',
        'major',
        'name',
        'gender',
        'dob',
        'phone',
        'image',
        'join_date',
        'sks_score',
    ];

    protected $casts = [
        'dob' => 'date',
        'join_date' => 'date',
    ];

    /**
     * Get the user that owns the identity
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'email', 'email');
    }

    /**
     * Get the full image URL
     */
    public function getImageUrlAttribute()
    {
        if ($this->image) {
            return asset('storage/' . $this->image);
        }

        return asset('images/default-avatar.png');
    }

    /**
     * Get user initials for avatar
     */
    public function getInitialsAttribute()
    {
        $names = explode(' ', $this->name);
        $initials = '';

        foreach ($names as $name) {
            $initials .= strtoupper(substr($name, 0, 1));
        }

        return substr($initials, 0, 2);
    }
}
