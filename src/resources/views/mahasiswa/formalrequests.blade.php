@extends('mahasiswa.layout')

@section('title', 'Permohonan Formal')
@section('page-title', 'Permohonan Formal')

@section('content')


    <div class="assignments-header">
        <div class="filter-tabs">
            <div class="filter-tab active">
                <i class="fas fa-list"></i> Semua Permohonan
            </div>
            <div class="filter-tab">
                <i class="fas fa-clock"></i> Draft
            </div>
            <div class="filter-tab">
                <i class="fas fa-check"></i> Submitted
            </div>
            <div class="filter-tab">
                <i class="fas fa-exclamation-triangle"></i> Rejected
            </div>
            <div class="filter-tab">
                <i class="fas fa-star"></i> Approved
            </div>
        </div>

        <div class="assignments-stats">
            <div class="stat-item">
                <div class="stat-number">12</div>
                <div class="stat-label">Total</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">4</div>
                <div class="stat-label">Pending</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">6</div>
                <div class="stat-label">Submitted</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">2</div>
                <div class="stat-label">Graded</div>
            </div>
        </div>

        <div class="add-assignment">
            <a href="{{ route('mahasiswa.form-formal-requests') }}" class="btn btn-primary  w-100 my-3">
                <i class="fas fa-plus"></i> Tambah Permohonan Formal
            </a>
        </div>
    </div>
    <div class="assignments-list">
        <div class="assignment-card">
            <div class="assignment-header">
                <div class="assignment-info">
                    <div class="assignment-title">
                        <i class="fas fa-file"></i>
                        Pengajuan Proposal Kerja Praktik
                    </div>
                    <div class="assignment-course">Judul Proposal Kerja Praktik</div>
                    <div class="assignment-meta">
                        <div class="meta-item">
                            <i class="fas fa-calendar meta-icon"></i>
                            <span>Dibuat pada : Oct 23, 2025</span>
                        </div>
                        <div class="meta-item">
                            <i class="fas fa-user meta-icon"></i>
                            <span>Mahasiswa ABC</span>
                        </div>
                        <div class="meta-item">
                            <i class="fas fa-users meta-icon"></i>
                            <span>Group (3 members)</span>
                        </div>
                    </div>
                </div>
                <div class="assignment-status">
                    <div class="status-badge status-draft">Draft</div>
                    <div class="status-badge status-rejected">Rejected</div>
                    <div class="due-date">Oct 23, 2025</div>
                </div>
            </div>
            <div class="assignment-body">
                <div class="assignment-description">
                    Topic : Design a comprehensive database schema for a library management system. Include ER diagrams,
                    normalization analysis, and SQL implementation.
                    <br>
                    Instansi : PT. Pertamina
                    <br>
                    Alamat Instansi : Jl. Medan Merdeka Timur No.1A, Jakarta 10110
                    <br>
                    Pembimbing Lapangan : Budi Santoso
                </div>
                <div class="assignment-actions">
                    <div class="action-buttons">
                        <a href="#" class="btn btn-primary">
                            <i class="fas fa-edit"></i> Edit Pengajuan Proposal
                        </a>
                        <a href="#" class="btn btn-outline">
                            <i class="fas fa-users"></i> Lihat Member
                        </a>
                    </div>
                    <div class="progress-indicator">
                        <i class="fas fa-chart-pie"></i> 0% complete
                    </div>
                </div>
            </div>
        </div>

        <div class="assignment-card">
            <div class="assignment-header">
                <div class="assignment-info">
                    <div class="assignment-title">
                        <i class="fas fa-file"></i>
                        Pengajuan Proposal Kerja Praktik
                    </div>
                    <div class="assignment-course">Judul Proposal Kerja Praktik</div>
                    <div class="assignment-meta">
                        <div class="meta-item">
                            <i class="fas fa-calendar meta-icon"></i>
                            <span>Dibuat pada : Oct 20, 2025</span>
                        </div>
                        <div class="meta-item">
                            <i class="fas fa-user meta-icon"></i>
                            <span>Mahasiswa ABC</span>
                        </div>
                    </div>
                </div>
                <div class="assignment-status">
                    <div class="status-badge status-submitted">Submitted</div>
                    <div class="status-badge status-approved">Approved</div>
                    <div class="due-date">Oct 20, 2025</div>
                </div>
            </div>
            <div class="assignment-body">
                <div class="assignment-description">
                    Topic : Design a comprehensive database schema for a library management system. Include ER diagrams,
                    normalization analysis, and SQL implementation.
                    <br>
                    Instansi : PT. Pertamina
                    <br>
                    Alamat Instansi : Jl. Medan Merdeka Timur No.1A, Jakarta 10110
                    <br>
                    Pembimbing Lapangan : Budi Santoso
                </div>
                <div class="assignment-actions">
                    <div class="action-buttons">
                        <a href="#" class="btn btn-outline">
                            <i class="fas fa-eye"></i> Lihat Surat Pengantar Proposal
                        </a>
                    </div>
                    <div class="progress-indicator">
                        <i class="fas fa-chart-pie"></i> 25% complete
                    </div>
                </div>
            </div>
        </div>


    </div>
@endsection
