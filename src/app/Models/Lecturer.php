<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lecturer extends Model
{
    protected $fillable = [
        'user_id',
        'nip',
        'nama_resmi',
        'email_kampus',
        'prodi',
        'fakultas',
        'jabatan',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
