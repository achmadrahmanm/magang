@extends('layouts.app')

@section('title', 'Management Mahasiswa - Sistem Terdepan Indonesia')

@push('styles')
<style>
    body {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    
    .main-content {
        padding-top: 0;
    }

    /* Hero Section Styles */
    .hero-section {
        min-height: 100vh;
        display: flex;
        align-items: center;
        padding: 50px 0;
        padding-top: 100px;
    }

    .hero-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
    }

    .hero-content {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 50px;
        align-items: center;
    }

    .hero-text h1 {
        font-family: 'Poppins', sans-serif;
        font-size: 3.5rem;
        font-weight: 700;
        color: white;
        margin-bottom: 10px;
        line-height: 1.2;
    }

    .hero-text h2 {
        font-size: 1.5rem;
        color: #f0f8ff;
        margin-bottom: 20px;
        font-weight: 300;
    }

    .hero-text p {
        font-size: 1.1rem;
        color: #e6f3ff;
        line-height: 1.6;
        margin-bottom: 30px;
    }

    .hero-features {
        margin-bottom: 30px;
    }

    .feature {
        display: flex;
        align-items: center;
        margin-bottom: 15px;
        color: white;
    }

    .check {
        background: #4ade80;
        color: white;
        border-radius: 50%;
        width: 20px;
        height: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        margin-right: 15px;
    }

    .cta-button {
        background: linear-gradient(45deg, #ff6b6b, #ffa500);
        color: white;
        border: none;
        padding: 15px 35px;
        border-radius: 30px;
        font-size: 1.1rem;
        font-weight: 600;
        cursor: pointer;
        transition: transform 0.3s ease;
        text-decoration: none;
        display: inline-block;
    }

    .cta-button:hover {
        transform: translateY(-2px);
        color: white;
    }

    .hero-image img {
        width: 100%;
        border-radius: 15px;
        box-shadow: 0 20px 40px rgba(0,0,0,0.3);
    }

    /* Features Section */
    .features-section {
        background: white;
        padding: 80px 0;
    }

    .features-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
        text-align: center;
    }

    .section-title {
        font-family: 'Poppins', sans-serif;
        font-size: 2.5rem;
        font-weight: 700;
        color: #333;
        margin-bottom: 1rem;
    }

    .section-subtitle {
        font-size: 1.1rem;
        color: #666;
        margin-bottom: 3rem;
        max-width: 600px;
        margin-left: auto;
        margin-right: auto;
    }

    .features-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 2rem;
        margin-top: 3rem;
    }

    .feature-card {
        background: white;
        padding: 2rem;
        border-radius: 1rem;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        text-align: center;
        transition: all 0.3s ease;
        border: 1px solid #f0f0f0;
    }

    .feature-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
    }

    .feature-icon {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem;
        font-size: 2rem;
    }

    .feature-card h3 {
        font-family: 'Poppins', sans-serif;
        font-size: 1.5rem;
        font-weight: 600;
        margin-bottom: 1rem;
        color: #333;
    }

    .feature-card p {
        color: #666;
        line-height: 1.6;
    }

    /* Statistics Section */
    .stats-section {
        padding: 80px 0;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }

    .stats-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
        text-align: center;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 2rem;
        margin-top: 3rem;
    }

    .stat-item {
        padding: 2rem;
        border-radius: 1rem;
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        transition: transform 0.3s ease;
    }

    .stat-item:hover {
        transform: translateY(-5px);
    }

    .stat-number {
        font-family: 'Poppins', sans-serif;
        font-size: 3rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }

    .stat-label {
        font-size: 1.1rem;
        opacity: 0.9;
    }

    /* Testimonials Section */
    .testimonials-section {
        padding: 80px 0;
        background: #f8f9fa;
    }

    .testimonials-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
        text-align: center;
    }

    .testimonials-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
        gap: 2rem;
        margin-top: 3rem;
    }

    .testimonial-card {
        background: white;
        padding: 2rem;
        border-radius: 1rem;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }

    .testimonial-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
    }

    .testimonial-content .stars {
        font-size: 1.2rem;
        margin-bottom: 1rem;
    }

    .testimonial-content p {
        color: #666;
        line-height: 1.6;
        margin-bottom: 1.5rem;
        font-style: italic;
    }

    .testimonial-author {
        display: flex;
        align-items: center;
        gap: 1rem;
        text-align: left;
    }

    .testimonial-author img {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        object-fit: cover;
    }

    .author-info h4 {
        font-weight: 600;
        color: #333;
        margin-bottom: 0.25rem;
    }

    .author-info p {
        color: #666;
        font-size: 0.9rem;
        margin: 0;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .hero-content {
            grid-template-columns: 1fr;
            text-align: center;
        }
        
        .hero-text h1 {
            font-size: 2.5rem;
        }
        
        .section-title {
            font-size: 2rem;
        }

        .features-grid {
            grid-template-columns: 1fr;
        }
        
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .testimonials-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 480px) {
        .hero-text h1 {
            font-size: 2rem;
        }

        .stats-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush

@section('content')
<section class="hero-section">
    <div class="hero-container">
        <div class="hero-content">
            <div class="hero-text">
                <h1>Management Mahasiswa Terdepan</h1>
                <h2>Solusi Digital untuk Institusi Pendidikan</h2>
                <p>Platform manajemen mahasiswa yang komprehensif untuk membantu universitas dan perguruan tinggi mengelola data mahasiswa, mata kuliah, nilai, dan jadwal dengan efisien dan modern.</p>
                <div class="hero-features">
                    <div class="feature">
                        <span class="check">✓</span>
                        <span>Dashboard Real-time</span>
                    </div>
                    <div class="feature">
                        <span class="check">✓</span>
                        <span>Keamanan Data Terjamin</span>
                    </div>
                    <div class="feature">
                        <span class="check">✓</span>
                        <span>Mobile Responsive</span>
                    </div>
                </div>
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="cta-button">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="cta-button">Mulai Sekarang</a>
                    @endauth
                @endif
            </div>
            <div class="hero-image">
                <img src="https://images.unsplash.com/photo-1523240795612-9a054b0db644?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Student Management Dashboard">
            </div>
        </div>
    </div>
</section>


<!-- Features Section -->
<section class="features-section" id="features">
    <div class="features-container">
        <h2 class="section-title">Fitur Unggulan Sistem Kami</h2>
        <p class="section-subtitle">Solusi lengkap untuk manajemen mahasiswa modern dengan teknologi terdepan</p>
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">�</div>
                <h3>Manajemen Profil Mahasiswa</h3>
                <p>Kelola data lengkap mahasiswa termasuk informasi pribadi, akademik, dan riwayat pendidikan dengan sistem yang terintegrasi.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">�</div>
                <h3>Sistem Mata Kuliah</h3>
                <p>Atur mata kuliah, kurikulum, dan program studi dengan mudah. Kelola prerequisite dan jadwal kuliah secara otomatis.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">📊</div>
                <h3>Manajemen Nilai & Transkrip</h3>
                <p>Sistem penilaian yang komprehensif dengan perhitungan GPA otomatis dan generate transkrip dalam berbagai format.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">�</div>
                <h3>Jadwal & Kalender Akademik</h3>
                <p>Kelola jadwal kuliah, ujian, dan kegiatan akademik lainnya dengan sistem kalender yang terintegrasi dan notifikasi otomatis.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">�</div>
                <h3>Tugas & Assignment</h3>
                <p>Platform untuk distribusi tugas, pengumpulan, dan penilaian assignment dengan sistem feedback yang interaktif.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">📈</div>
                <h3>Analytics & Reporting</h3>
                <p>Dashboard analytics dengan laporan komprehensif untuk monitoring progress akademik dan performa institusi.</p>
            </div>
        </div>
    </div>
</section>


<!-- Statistics Section -->
<section class="stats-section" id="about">
    <div class="stats-container">
        <h2 class="section-title" style="color: white;">Dipercaya Oleh Institusi Pendidikan Terkemuka</h2>
        <p class="section-subtitle" style="color: rgba(255,255,255,0.9);">Telah melayani ribuan mahasiswa dan ratusan institusi di seluruh Indonesia</p>
        <div class="stats-grid">
            <div class="stat-item">
                <div class="stat-number" data-target="150">0</div>
                <div class="stat-label">Institusi Aktif</div>
            </div>
            <div class="stat-item">
                <div class="stat-number" data-target="25000">0</div>
                <div class="stat-label">Mahasiswa Terdaftar</div>
            </div>
            <div class="stat-item">
                <div class="stat-number" data-target="99">0</div>
                <div class="stat-label">% Kepuasan Pengguna</div>
            </div>
            <div class="stat-item">
                <div class="stat-number" data-target="24">0</div>
                <div class="stat-label">Jam Support</div>
            </div>
        </div>
    </div>
</section>

<!-- Testimonials Section -->
<section class="testimonials-section">
    <div class="testimonials-container">
        <h2 class="section-title">Testimoni Institusi Partner</h2>
        <p class="section-subtitle">Pengalaman nyata dari institusi pendidikan yang telah menggunakan sistem kami</p>
        <div class="testimonials-grid">
            <div class="testimonial-card">
                <div class="testimonial-content">
                    <div class="stars">⭐⭐⭐⭐⭐</div>
                    <p>"Sistem management mahasiswa ini sangat membantu kami dalam mengelola 15,000+ mahasiswa. Efisiensi administrasi meningkat drastis dan mahasiswa lebih puas dengan layanan digital kami."</p>
                </div>
                <div class="testimonial-author">
                    <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-4.0.3&auto=format&fit=crop&w=150&q=80" alt="Rektor Photo">
                    <div class="author-info">
                        <h4>Prof. Dr. Ahmad Sutrisno</h4>
                        <p>Rektor, Universitas Teknologi Indonesia</p>
                    </div>
                </div>
            </div>
            <div class="testimonial-card">
                <div class="testimonial-content">
                    <div class="stars">⭐⭐⭐⭐⭐</div>
                    <p>"Implementasi yang sangat smooth dan support team yang responsif. Fitur-fitur yang disediakan sangat sesuai dengan kebutuhan institusi pendidikan modern."</p>
                </div>
                <div class="testimonial-author">
                    <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-4.0.3&auto=format&fit=crop&w=150&q=80" alt="Direktur Photo">
                    <div class="author-info">
                        <h4>Dr. Sari Indrawati, M.Pd</h4>
                        <p>Direktur Akademik, Politeknik Negeri Jakarta</p>
                    </div>
                </div>
            </div>
            <div class="testimonial-card">
                <div class="testimonial-content">
                    <div class="stars">⭐⭐⭐⭐⭐</div>
                    <p>"ROI yang luar biasa! Sistem ini tidak hanya menghemat biaya operasional tapi juga meningkatkan kualitas layanan pendidikan secara keseluruhan."</p>
                </div>
                <div class="testimonial-author">
                    <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-4.0.3&auto=format&fit=crop&w=150&q=80" alt="Ketua Photo">
                    <div class="author-info">
                        <h4>Budi Hartono, S.Kom, M.T</h4>
                        <p>Ketua Program Studi, STMIK Bandung</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Contact Section -->
<section class="stats-section" id="contact" style="background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);">
    <div class="stats-container">
        <h2 class="section-title" style="color: white;">Siap Memulai Transformasi Digital?</h2>
        <p class="section-subtitle" style="color: rgba(255,255,255,0.9); margin-bottom: 2rem;">Hubungi tim kami untuk demo gratis dan konsultasi kebutuhan institusi Anda</p>
        <div style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap;">
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}" class="btn-primary" style="background: white; color: #667eea;">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="btn-primary" style="background: white; color: #667eea;">Login Sekarang</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn-secondary" style="border-color: white; color: white;">Daftar Gratis</a>
                    @endif
                @endauth
            @endif
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
    // Counter animation
    function animateCounters() {
        const counters = document.querySelectorAll('.stat-number');
        
        counters.forEach(counter => {
            const target = +counter.getAttribute('data-target');
            const increment = target / 200;
            let current = 0;
            
            const updateCounter = () => {
                if (current < target) {
                    current += increment;
                    if (target >= 1000) {
                        counter.textContent = Math.ceil(current).toLocaleString();
                    } else {
                        counter.textContent = Math.ceil(current);
                    }
                    setTimeout(updateCounter, 10);
                } else {
                    if (target >= 1000) {
                        counter.textContent = target.toLocaleString();
                    } else {
                        counter.textContent = target;
                    }
                }
            };
            
            updateCounter();
        });
    }

    // Intersection Observer for scroll trigger
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                animateCounters();
                observer.unobserve(entry.target);
            }
        });
    });

    // Start observing when DOM is loaded
    document.addEventListener('DOMContentLoaded', () => {
        const statsSection = document.querySelector('.stats-section');
        if (statsSection) {
            observer.observe(statsSection);
        }
    });
</script>
@endpush