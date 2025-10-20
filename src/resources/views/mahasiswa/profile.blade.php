@extends('mahasiswa.layout')

@section('title', 'My Profile')
@section('page-title', 'My Profile')

@section('content')
<style>
    .profile-container {
        max-width: 800px;
        margin: 0 auto;
    }

    .profile-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        overflow: hidden;
        border: 1px solid #f0f0f0;
    }

    .profile-header {
        background: linear-gradient(135deg, #29166F, #4c2c91);
        color: white;
        padding: 2rem;
        text-align: center;
    }

    .profile-avatar {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.2);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 3rem;
        font-weight: 600;
        margin: 0 auto 1rem;
        border: 4px solid rgba(255, 255, 255, 0.3);
    }

    .profile-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 50%;
    }

    .profile-name {
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }

    .profile-id {
        font-size: 1rem;
        opacity: 0.9;
        margin-bottom: 0.5rem;
    }

    .profile-role {
        background: rgba(255, 255, 255, 0.2);
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.85rem;
        display: inline-block;
    }

    .profile-body {
        padding: 2rem;
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 2rem;
    }

    .info-section {
        background: #f8f9fa;
        padding: 1.5rem;
        border-radius: 12px;
    }

    .section-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: #333;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .info-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.75rem 0;
        border-bottom: 1px solid #e9ecef;
    }

    .info-item:last-child {
        border-bottom: none;
    }

    .info-label {
        color: #666;
        font-size: 0.9rem;
    }

    .info-value {
        color: #333;
        font-weight: 500;
    }

    @media (max-width: 768px) {
        .profile-body {
            padding: 1rem;
        }

        .info-grid {
            grid-template-columns: 1fr;
            gap: 1rem;
        }
    }
</style>

<div class="profile-container">
    <div class="profile-card">
        <div class="profile-header">
            <div class="profile-avatar">
                @if($identity && $identity->image)
                    <img src="{{ $identity->image_url }}" alt="Profile">
                @else
                    {{ $identity ? $identity->initials : substr($user->name, 0, 2) }}
                @endif
            </div>
            <div class="profile-name">{{ $user->name }}</div>
            <div class="profile-id">ID: {{ $identity->user_id ?? 'N/A' }}</div>
            <div class="profile-role">{{ ucfirst($user->role) }}</div>
        </div>

        <div class="profile-body">
            <div class="info-grid">
                <div class="info-section">
                    <div class="section-title">
                        <i class="fas fa-user"></i>
                        Personal Information
                    </div>
                    <div class="info-item">
                        <span class="info-label">Full Name</span>
                        <span class="info-value">{{ $identity->name ?? $user->name }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Email</span>
                        <span class="info-value">{{ $user->email }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Phone</span>
                        <span class="info-value">{{ $identity->phone ?? 'N/A' }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Gender</span>
                        <span class="info-value">{{ $identity->gender ? ucfirst($identity->gender) : 'N/A' }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Date of Birth</span>
                        <span class="info-value">{{ $identity->dob ? $identity->dob->format('M d, Y') : 'N/A' }}</span>
                    </div>
                </div>

                <div class="info-section">
                    <div class="section-title">
                        <i class="fas fa-graduation-cap"></i>
                        Academic Information
                    </div>
                    <div class="info-item">
                        <span class="info-label">Student ID</span>
                        <span class="info-value">{{ $identity->user_id ?? 'N/A' }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Department</span>
                        <span class="info-value">{{ $identity->department ?? 'N/A' }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Major</span>
                        <span class="info-value">{{ $identity->major ?? 'N/A' }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Campus ID</span>
                        <span class="info-value">{{ $identity->campus_id ?? 'N/A' }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Join Date</span>
                        <span class="info-value">{{ $identity->join_date ? $identity->join_date->format('M d, Y') : 'N/A' }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Total Credits (SKS)</span>
                        <span class="info-value">{{ $identity->sks_score ?? 0 }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
