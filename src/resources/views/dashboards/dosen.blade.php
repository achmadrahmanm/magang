@extends('dosen.layout')

@section('title', 'Dosen Dashboard')
@section('page-title', 'Dashboard Overview')

@section('content')
    <!-- Welcome Card -->
    <div class="welcome-card">
        <div class="welcome-content">
            <div class="logo-container">
                <img src="{{ asset('icons/logo.svg') }}" alt="Logo" class="welcome-logo">
            </div>
            <div class="text-content">
                <h2>Halo {{ Auth::user()->name }}!</h2>
                <p>Selamat datang di Portal Pengajuan Kerja Praktek - Elektro ITS</p>
            </div>
        </div>
    </div>

    <!-- Applications Overview -->
    <div class="assignments-list mb-4">
        <!-- Recent Applications -->
        <div class="assignment-card"
            style="border-left: 4px solid #8A2BE2; border-top-left-radius: 8px; border-bottom-left-radius: 8px;">
            <div class="assignment-header pt-2 pb-1">
                <div class="assignment-info my-auto">
                    <div class="assignment-title">
                        Aplikasi Terbaru
                    </div>
                </div>
                <div class="assignment-status">
                    <div class="status-badge status-draft">{{ $recentApplications->count() ?? 0 }} Aplikasi</div>
                    <div class="due-date">{{ now()->format('d M Y') }}</div>
                </div>
            </div>
            <div class="assignment-body py-3">
                <div class="d-flex align-items-center mb-3">
                    <img src="{{ asset('icons/speaker.svg') }}" alt="Applications" class="mx-3 my-auto"
                        style="width: 54px; height: 54px;">
                    <div class="assignment-description mb-0">
                        Review Aplikasi Kerja Praktik Mahasiswa
                        <br>
                        <span>Ada {{ $pendingApplications ?? 0 }} aplikasi menunggu persetujuan Anda</span>
                    </div>
                </div>

                <div class="assignment-actions">
                    <div class="action-buttons">
                        <a href="{{ route('dosen.applications') }}" class="btn btn-primary">
                            <i class="fas fa-eye"></i> Lihat Semua Aplikasi
                        </a>
                        <a href="{{ route('dosen.approvals') }}" class="btn btn-outline">
                            <i class="fas fa-check-circle"></i> Lihat Persetujuan
                        </a>
                    </div>
                    <div class="progress-indicator">
                        <i class="fas fa-clock"></i> Last Update : {{ now()->diffForHumans() }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Stats Row -->
        <div class="row m-0">
            <div class="assignment-card col me-2"
                style="border-left: 4px solid #007bff; border-top-left-radius: 8px; border-bottom-left-radius: 8px;">
                <div class="assignment-header pt-2 pb-1">
                    <div class="assignment-info my-auto">
                        <div class="assignment-title">
                            Total Aplikasi
                        </div>
                    </div>
                </div>
                <div class="assignment-body pt-2 pb-2 text-center">
                    <div class="stat-number" style="font-size: 32px; color: #007bff;">
                        {{ $totalApplications ?? 0 }}
                    </div>
                    <div class="stat-description">Aplikasi Masuk</div>
                </div>
            </div>

            <div class="assignment-card col me-2"
                style="border-left: 4px solid #28a745; border-top-left-radius: 8px; border-bottom-left-radius: 8px;">
                <div class="assignment-header pt-2 pb-1">
                    <div class="assignment-info my-auto">
                        <div class="assignment-title">
                            Disetujui
                        </div>
                    </div>
                </div>
                <div class="assignment-body pt-2 pb-2 text-center">
                    <div class="stat-number" style="font-size: 32px; color: #28a745;">
                        {{ $approvedApplications ?? 0 }}
                    </div>
                    <div class="stat-description">Aplikasi Disetujui</div>
                </div>
            </div>

            <div class="assignment-card col me-2"
                style="border-left: 4px solid #ffc107; border-top-left-radius: 8px; border-bottom-left-radius: 8px;">
                <div class="assignment-header pt-2 pb-1">
                    <div class="assignment-info my-auto">
                        <div class="assignment-title">
                            Menunggu
                        </div>
                    </div>
                </div>
                <div class="assignment-body pt-2 pb-2 text-center">
                    <div class="stat-number" style="font-size: 32px; color: #ffc107;">
                        {{ $pendingApplications ?? 0 }}
                    </div>
                    <div class="stat-description">Perlu Review</div>
                </div>
            </div>

            <div class="assignment-card col me-2"
                style="border-left: 4px solid #dc3545; border-top-left-radius: 8px; border-bottom-left-radius: 8px;">
                <div class="assignment-header pt-2 pb-1">
                    <div class="assignment-info my-auto">
                        <div class="assignment-title">
                            Ditolak
                        </div>
                    </div>
                </div>
                <div class="assignment-body pt-2 pb-2 text-center">
                    <div class="stat-number" style="font-size: 32px; color: #dc3545;">
                        {{ $rejectedApplications ?? 0 }}
                    </div>
                    <div class="stat-description">Aplikasi Ditolak</div>
                </div>
            </div>
        </div>

        <!-- Recent Applications Table -->
        <div class="assignment-card"
            style="border-left: 4px solid #17a2b8; border-top-left-radius: 8px; border-bottom-left-radius: 8px;">
            <div class="assignment-header pt-2 pb-1">
                <div class="assignment-info my-auto">
                    <div class="assignment-title">
                        Aplikasi Terbaru
                    </div>
                </div>
                <div class="assignment-status">
                    <div class="status-badge status-draft">{{ $recentApplications->count() ?? 0 }} Item</div>
                    <div class="due-date">{{ now()->format('d M Y') }}</div>
                </div>
            </div>
            <div class="assignment-body py-3">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Mahasiswa</th>
                                <th>Institusi</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Tanggal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentApplications ?? [] as $application)
                                <tr>
                                    <td>{{ $application->submittedBy->name ?? 'N/A' }}</td>
                                    <td>{{ $application->institution_name ?? 'N/A' }}</td>
                                    <td>
                                        <div class="text-center status-badge status-{{ $application->status }}">
                                            {{ ucfirst($application->status ?? 'unknown') }}
                                        </div>
                                    </td>
                                    <td class="text-center">{{ $application->created_at->format('d M Y') }}</td>
                                    <td>
                                        <a href="{{ route('dosen.applications.show', $application->id) }}"
                                            class="btn btn-outline">
                                            <i class="fas fa-eye"></i> Lihat
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted">Belum ada aplikasi</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row g-4 mb-4">
        <div class="col-xl-4 col-lg-6 col-md-6">
            <div class="card-modern">
                <div class="section-header">
                    <div class="section-icon"><i class="fas fa-book"></i></div>
                    <h3 class="section-title">Kelola Aplikasi</h3>
                </div>
                <div class="list-modern">
                    <div class="list-item">
                        <div class="item-icon"><i class="fas fa-eye"></i></div>
                        <div class="item-content">
                            <div class="item-title">Review Aplikasi</div>
                            <div class="item-desc">Periksa dan setujui aplikasi mahasiswa</div>
                        </div>
                        <a href="{{ route('dosen.applications') }}" class="btn btn-sm btn-primary">Lihat</a>
                    </div>
                    <div class="list-item">
                        <div class="item-icon"><i class="fas fa-check-circle"></i></div>
                        <div class="item-content">
                            <div class="item-title">Riwayat Persetujuan</div>
                            <div class="item-desc">Lihat aplikasi yang sudah disetujui</div>
                        </div>
                        <a href="{{ route('dosen.approvals') }}" class="btn btn-sm btn-success">Lihat</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-lg-6 col-md-6">
            <div class="card-modern">
                <div class="section-header">
                    <div class="section-icon"><i class="fas fa-cog"></i></div>
                    <h3 class="section-title">Pengaturan</h3>
                </div>
                <div class="list-modern">
                    <div class="list-item">
                        <div class="item-icon"><i class="fas fa-user"></i></div>
                        <div class="item-content">
                            <div class="item-title">Profil Dosen</div>
                            <div class="item-desc">Kelola informasi pribadi Anda</div>
                        </div>
                        <a href="{{ route('dosen.settings') }}" class="btn btn-sm btn-info">Edit</a>
                    </div>
                    <div class="list-item">
                        <div class="item-icon"><i class="fas fa-bell"></i></div>
                        <div class="item-content">
                            <div class="item-title">Notifikasi</div>
                            <div class="item-desc">Atur preferensi notifikasi</div>
                        </div>
                        <a href="{{ route('dosen.settings') }}" class="btn btn-sm btn-secondary">Atur</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-lg-6 col-md-6">
            <div class="card-modern">
                <div class="section-header">
                    <div class="section-icon"><i class="fas fa-chart-line"></i></div>
                    <h3 class="section-title">Statistik</h3>
                </div>
                <div class="list-modern">
                    <div class="list-item">
                        <div class="item-icon"><i class="fas fa-calendar-week"></i></div>
                        <div class="item-content">
                            <div class="item-title">Aktivitas Minggu Ini</div>
                            <div class="item-desc">{{ $weeklyActivity ?? 0 }} aplikasi diproses</div>
                        </div>
                        <span class="badge bg-primary">{{ $weeklyActivity ?? 0 }}</span>
                    </div>
                    <div class="list-item">
                        <div class="item-icon"><i class="fas fa-clock"></i></div>
                        <div class="item-content">
                            <div class="item-title">Rata-rata Response</div>
                            <div class="item-desc">{{ $avgResponseTime ?? '2 hari' }} waktu response</div>
                        </div>
                        <span class="badge bg-success">{{ $avgResponseTime ?? '2 hari' }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
