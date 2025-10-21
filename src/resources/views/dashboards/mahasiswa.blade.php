@extends('mahasiswa.layout')

@section('title', 'Mahasiswa Dashboard')
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


    <div class="assignments-list mb-4">
        <div class="assignment-card"
            style="border-left: 4px solid #8A2BE2; border-top-left-radius: 8px; border-bottom-left-radius: 8px;">
            <div class="assignment-header pt-2 pb-1">
                <div class="assignment-info my-auto">
                    <div class="assignment-title">
                        Pengumuman Terbaru
                    </div>
                </div>
                <div class="assignment-status">
                    <div class="status-badge status-draft">Mr. XXX (Dosen Pembimbing)</div>
                    <div class="due-date">12 Agustus 2025</div>
                </div>
            </div>
            <div class="assignment-body py-3">
                <div class="d-flex align-items-center mb-3">
                    <img src="{{ asset('icons/speaker.svg') }}" alt="Speaker" class="mx-3 my-auto"
                        style="width: 54px; height: 54px;">
                    <div class="assignment-description mb-0">
                        Proposal Kerja Praktik <span class="badge text-bg-danger">Rejected</span>
                        <br>
                        <span>Proposal Kerja Praktik dengan judul "Kerja Praktik di Pertamina"</span>
                    </div>
                </div>

                <div class="assignment-actions">
                    <div class="action-buttons">
                        <a href="#" class="btn btn-primary">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="#" class="btn btn-outline">
                            <i class="fas fa-eye"></i> Lihat Surat Pengantar Proposal
                        </a>
                    </div>
                    <div class="progress-indicator">
                        <i class="fas fa-clock"></i> Last Update : 18 hours Ago
                    </div>
                </div>
            </div>
        </div>

        <div class="assignment-card"
            style="border-left: 4px solid #8A2BE2; border-top-left-radius: 8px; border-bottom-left-radius: 8px;">
            <div class="assignment-header pt-2 pb-1">
                <div class="assignment-info my-auto">
                    <div class="assignment-title">
                        Pengumuman Terbaru
                    </div>
                </div>
                <div class="assignment-status">
                    <div class="status-badge status-draft">Mr. XXX (Dosen Pembimbing)</div>
                    <div class="due-date">12 Agustus 2025</div>
                </div>
            </div>
            <div class="assignment-body py-3">
                <div class="d-flex align-items-center mb-3">
                    <img src="{{ asset('icons/speaker.svg') }}" alt="Speaker" class="mx-3 my-auto"
                        style="width: 54px; height: 54px;">
                    <div class="assignment-description mb-0">
                        Proposal Kerja Praktik <span class="badge text-bg-secondary">Draft</span>
                        <br>
                        <span>Proposal Kerja Praktik dengan judul "Kerja Praktik di Pertamina"</span>
                    </div>
                </div>

                <div class="assignment-actions">
                    <div class="action-buttons">
                        <a href="#" class="btn btn-primary">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="#" class="btn btn-outline">
                            <i class="fas fa-eye"></i> Lihat Surat Pengantar Proposal
                        </a>
                    </div>
                    <div class="progress-indicator">
                        <i class="fas fa-clock"></i> Last Update : 18 hours Ago
                    </div>
                </div>
            </div>
        </div>


        <div class="row m-0">
            <div class="assignment-card col-9 me-2"
                style="border-left: 4px solid #8A2BE2; border-top-left-radius: 8px; border-bottom-left-radius: 8px;">
                <div class="assignment-header pt-2 pb-1">
                    <div class="assignment-info my-auto">
                        <div class="assignment-title">
                            Pengumuman Terbaru
                        </div>
                    </div>

                </div>
                <div class="assignment-body pt-2 pb-2">
                    <div class="d-flex align-items-center mb-3">
                        <img src="{{ asset('icons/cancel.svg') }}" alt="Speaker" class="mx-3 my-auto"
                            style="width: 54px; height: 54px;">
                        <div class="assignment-description mb-0">
                            Mahasiswa belum memenuhi syarat Kerja Praktik
                            <br>
                            <span>Mahasiswa yang diperbolehkan melakukan Kerja Praktik adalah mahasiswa yang sudah
                                setidaknya
                                menempuh 90 SKS dengan Semester yang berjalan minimal Semester 5</span>
                        </div>
                    </div>


                </div>
            </div>

            <div class="assignment-card col"
                style="border-left: 4px solid #8A2BE2; border-top-left-radius: 8px; border-bottom-left-radius: 8px;">
                <div class="assignment-header pt-2 pb-1">
                    <div class="assignment-info my-auto">
                        <div class="assignment-title">
                            Syarat untuk request Kerja Praktik
                        </div>
                    </div>
                </div>
                <div class="assignment-body pt-2 pb-2">
                    <div class="d-flex align-items-center mb-3">
                        <div class="assignment-description my-auto mx-auto" style="width: 350px; font-size: 24px;">
                            <div class="d-flex align-items-center mb-2">
                                <img src="{{ asset('icons/checker.svg') }}" alt="Checker" class="me-2"
                                    style="width: 20px; height: 20px; filter: brightness(0) saturate(100%) invert(35%) sepia(85%) saturate(2578%) hue-rotate(100deg) brightness(97%) contrast(86%);">
                                <span>90/90 SKS</span>
                            </div>
                            <div class="d-flex align-items-center">
                                <img src="{{ asset('icons/checker-gray.svg') }}" alt="Cancel" class="me-2"
                                    style="width: 20px; height: 20px; filter: grayscale(100%) brightness(70%);">
                                <span>4/5 Semester</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row m-0">
            <div class="assignment-card col-9 me-2"
                style="border-left: 4px solid #8A2BE2; border-top-left-radius: 8px; border-bottom-left-radius: 8px;">
                <div class="assignment-header pt-2 pb-1">
                    <div class="assignment-info my-auto">
                        <div class="assignment-title">
                            Pengumuman Terbaru
                        </div>
                    </div>

                </div>
                <div class="assignment-body py-3">
                    <div class="d-flex align-items-center mb-3">
                        <img src="{{ asset('icons/allow.svg') }}" alt="Allow" class="mx-3 my-auto"
                            style="width: 54px; height: 54px;">
                        <div class="assignment-description mb-0">
                            Mahasiswa memenuhi syarat Kerja Praktik, Silahkan mengajukan proposal Kerja Praktik
                            <br>
                            <span>Mahasiswa yang diperbolehkan melakukan Kerja Praktik adalah mahasiswa yang sudah
                                setidaknya menempuh 90 SKS dengan Semester yang berjalan minimal Semester 5</span>
                        </div>
                    </div>
                    <div class="assignment-actions">
                        <div class="action-buttons">
                            <a href="{{ route('mahasiswa.form-formal-requests') }}" class="btn btn-primary">
                                <i class="fas fa-edit"></i> Buat Permohonan Proposal
                            </a>
                            <a href="#" class="btn btn-outline">
                                <i class="fas fa-signature"></i> Submit Signature
                            </a>
                        </div>

                    </div>

                </div>
            </div>

            <div class="assignment-card col"
                style="border-left: 4px solid #8A2BE2; border-top-left-radius: 8px; border-bottom-left-radius: 8px;">
                <div class="assignment-header pt-2 pb-1">
                    <div class="assignment-info my-auto">
                        <div class="assignment-title">
                            Syarat untuk request Kerja Praktik
                        </div>
                    </div>
                </div>
                <div class="assignment-body pt-2 pb-2">
                    <div class="d-flex align-items-center mb-3">
                        <div class="assignment-description my-auto mx-auto" style="width: 350px; font-size: 24px;">
                            <div class="d-flex align-items-center mb-2">
                                <img src="{{ asset('icons/checker.svg') }}" alt="Checker" class="me-2"
                                    style="width: 20px; height: 20px; filter: brightness(0) saturate(100%) invert(35%) sepia(85%) saturate(2578%) hue-rotate(100deg) brightness(97%) contrast(86%);">
                                <span>102/90 SKS</span>
                            </div>
                            <div class="d-flex align-items-center">
                                <img src="{{ asset('icons/checker.svg') }}" alt="Checker" class="me-2"
                                    style="width: 20px; height: 20px; filter: brightness(0) saturate(100%) invert(35%) sepia(85%) saturate(2578%) hue-rotate(100deg) brightness(97%) contrast(86%);">
                                <span>6/5 Semester</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Section -->
    <div class="row g-4 mb-4 d-none">
        <div class="col-xl-3 col-lg-6 col-md-6">
            <div class="card-stat slide-up">
                <div class="stat-icon"><i class="fas fa-calendar-check"></i></div>
                <h3>Current Semester</h3>
                <div class="stat-number">5</div>
                <div class="stat-description">Active Semester</div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6">
            <div class="card-stat slide-up">
                <div class="stat-icon"><i class="fas fa-certificate"></i></div>
                <h3>Total Credits</h3>
                <div class="stat-number">98</div>
                <div class="stat-description">Credits Earned</div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6">
            <div class="card-stat slide-up">
                <div class="stat-icon"><i class="fas fa-chart-line"></i></div>
                <h3>Current GPA</h3>
                <div class="stat-number">3.75</div>
                <div class="stat-description">Cumulative GPA</div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6">
            <div class="card-stat slide-up">
                <div class="stat-icon"><i class="fas fa-book-open"></i></div>
                <h3>Active Courses</h3>
                <div class="stat-number">6</div>
                <div class="stat-description">This Semester</div>
            </div>
        </div>
    </div>

    <!-- Sections Grid -->
    <div class="row g-4 d-none">
        <div class="col-xl-3 col-lg-6 col-md-6">
            <div class="card-modern">
                <div class="section-header">
                    <div class="section-icon"><i class="fas fa-book"></i></div>
                    <h3 class="section-title">Current Courses</h3>
                </div>
                <div class="list-modern">
                    <div class="list-item">
                        <div class="item-icon"><i class="fas fa-code"></i></div>
                        <div class="item-content">
                            <div class="item-title">Web Programming</div>
                            <div class="item-desc">Prof. Dr. John Doe • 3 Credits • CS301</div>
                        </div>
                        <span class="badge bg-success">A</span>
                    </div>
                    <div class="list-item">
                        <div class="item-icon"><i class="fas fa-project-diagram"></i></div>
                        <div class="item-content">
                            <div class="item-title">Data Structures</div>
                            <div class="item-desc">Prof. Mike Johnson • 4 Credits • CS201</div>
                        </div>
                        <span class="badge bg-success">A-</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-lg-6 col-md-6">
            <div class="card-modern">
                <div class="section-header">
                    <div class="section-icon"><i class="fas fa-tasks"></i></div>
                    <h3 class="section-title">Assignments & Tasks</h3>
                </div>
                <div class="list-modern">
                    <div class="list-item">
                        <div class="item-icon"><i class="fas fa-laptop-code"></i></div>
                        <div class="item-content">
                            <div class="item-title">Laravel Project</div>
                            <div class="item-desc">Web Programming • Due: Tomorrow</div>
                        </div>
                        <span class="badge bg-danger">Due Soon</span>
                    </div>
                    <div class="list-item">
                        <div class="item-icon"><i class="fas fa-file-alt"></i></div>
                        <div class="item-content">
                            <div class="item-title">Database Design Report</div>
                            <div class="item-desc">Database Systems • Due: Next Week</div>
                        </div>
                        <span class="badge bg-warning">In Progress</span>
                    </div>
                    <div class="list-item">
                        <div class="item-icon"><i class="fas fa-search"></i></div>
                        <div class="item-content">
                            <div class="item-title">Research Proposal</div>
                            <div class="item-desc">Research Methods • Due: 2 Weeks</div>
                        </div>
                        <span class="badge bg-info">Draft Ready</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-lg-6 col-md-6">
            <div class="card-modern">
                <div class="section-header">
                    <div class="section-icon"><i class="fas fa-calendar-alt"></i></div>
                    <h3 class="section-title">Today's Schedule</h3>
                </div>
                <div class="list-modern">
                    <div class="list-item">
                        <div class="item-icon"><i class="fas fa-clock"></i></div>
                        <div class="item-content">
                            <div class="item-title">Web Programming</div>
                            <div class="item-desc">09:00 AM - 11:00 AM • Room A301</div>
                        </div>
                        <span class="badge badge-primary-custom">Next</span>
                    </div>
                    <div class="list-item">
                        <div class="item-icon"><i class="fas fa-clock"></i></div>
                        <div class="item-content">
                            <div class="item-title">Database Systems</div>
                            <div class="item-desc">01:00 PM - 03:00 PM • Lab B202</div>
                        </div>
                        <span class="badge bg-secondary">Later</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-lg-6 col-md-6">
            <div class="card-modern">
                <div class="section-header">
                    <div class="section-icon"><i class="fas fa-trophy"></i></div>
                    <h3 class="section-title">Academic Progress</h3>
                </div>
                <div class="list-modern">
                    <div class="list-item">
                        <div class="item-icon"><i class="fas fa-chart-bar"></i></div>
                        <div class="item-content">
                            <div class="item-title">Semester GPA</div>
                            <div class="item-desc">Current semester performance</div>
                        </div>
                        <span class="badge bg-success">3.85</span>
                    </div>
                    <div class="list-item">
                        <div class="item-icon"><i class="fas fa-medal"></i></div>
                        <div class="item-content">
                            <div class="item-title">Academic Standing</div>
                            <div class="item-desc">Dean's List qualification</div>
                        </div>
                        <span class="badge bg-success">Excellent</span>
                    </div>
                    <div class="list-item">
                        <div class="item-icon"><i class="fas fa-graduation-cap"></i></div>
                        <div class="item-content">
                            <div class="item-title">Graduation Progress</div>
                            <div class="item-desc">68% towards graduation</div>
                        </div>
                        <span class="badge bg-info">On Track</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
