@extends('mahasiswa.layout')

@section('title', 'Student Dashboard')
@section('page-title', 'Dashboard Overview')

@section('content')
<style>
    .welcome-card {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        color: white;
        padding: 2rem;
        border-radius: 16px;
        margin-bottom: 2rem;
        text-align: center;
        box-shadow: 0 8px 25px rgba(40, 167, 69, 0.2);
    }

    .welcome-card h2 {
        margin-bottom: 0.5rem;
        font-size: 2rem;
        font-weight: 700;
    }

    .welcome-card p {
        font-size: 1.1rem;
        opacity: 0.9;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .stat-card {
        background: white;
        padding: 2rem;
        border-radius: 16px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        text-align: center;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
        border: 1px solid #f0f0f0;
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(135deg, #28a745, #20c997);
    }

    .stat-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.15);
    }

    .stat-icon {
        font-size: 2.5rem;
        color: #28a745;
        margin-bottom: 1rem;
    }

    .stat-card h3 {
        color: #333;
        font-size: 1.1rem;
        margin-bottom: 1rem;
        font-weight: 600;
    }

    .stat-number {
        font-size: 3rem;
        font-weight: bold;
        color: #28a745;
        margin-bottom: 0.5rem;
        line-height: 1;
    }

    .stat-description {
        color: #666;
        font-size: 0.9rem;
    }

    .sections-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
        gap: 2rem;
    }

    .section-card {
        background: white;
        padding: 2rem;
        border-radius: 16px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        border: 1px solid #f0f0f0;
    }

    .section-header {
        display: flex;
        align-items: center;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid #f8f9fa;
    }

    .section-icon {
        font-size: 1.5rem;
        color: #28a745;
        margin-right: 0.75rem;
    }

    .section-title {
        color: #333;
        font-size: 1.3rem;
        font-weight: 700;
        margin: 0;
    }

    .item-list {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .list-item {
        display: flex;
        align-items: center;
        padding: 1.25rem;
        border: 2px solid #f8f9fa;
        border-radius: 12px;
        transition: all 0.3s ease;
        cursor: pointer;
        background: #fafafa;
    }

    .list-item:hover {
        border-color: #28a745;
        background: white;
        transform: translateX(5px);
        box-shadow: 0 4px 15px rgba(40, 167, 69, 0.1);
    }

    .item-icon {
        width: 50px;
        height: 50px;
        background: linear-gradient(135deg, #28a745, #20c997);
        color: white;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 1rem;
        font-size: 1.3rem;
    }

    .item-content {
        flex: 1;
    }

    .item-title {
        color: #333;
        font-weight: 600;
        margin-bottom: 0.25rem;
        font-size: 1rem;
    }

    .item-desc {
        color: #666;
        font-size: 0.85rem;
        line-height: 1.4;
    }

    .status-badge {
        padding: 0.4rem 0.8rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .badge-excellent {
        background: #d4edda;
        color: #155724;
    }

    .badge-good {
        background: #d1ecf1;
        color: #0c5460;
    }

    .badge-warning {
        background: #fff3cd;
        color: #856404;
    }

    .badge-pending {
        background: #f8d7da;
        color: #721c24;
    }

    @media (max-width: 768px) {
        .stats-grid {
            grid-template-columns: 1fr;
        }

        .sections-grid {
            grid-template-columns: 1fr;
        }

        .stat-number {
            font-size: 2.5rem;
        }

        .welcome-card h2 {
            font-size: 1.5rem;
        }

        .section-card {
            padding: 1.5rem;
        }
    }
</style>

<div class="welcome-card">
    <h2><i class="fas fa-graduation-cap"></i> Welcome Back, Student!</h2>
    <p>Track your academic progress and manage your studies effectively</p>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon"><i class="fas fa-calendar-check"></i></div>
        <h3>Current Semester</h3>
        <div class="stat-number">5</div>
        <div class="stat-description">Active Semester</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon"><i class="fas fa-certificate"></i></div>
        <h3>Total Credits</h3>
        <div class="stat-number">98</div>
        <div class="stat-description">Credits Earned</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon"><i class="fas fa-chart-line"></i></div>
        <h3>Current GPA</h3>
        <div class="stat-number">3.75</div>
        <div class="stat-description">Cumulative GPA</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon"><i class="fas fa-book-open"></i></div>
        <h3>Active Courses</h3>
        <div class="stat-number">6</div>
        <div class="stat-description">This Semester</div>
    </div>
</div>

<div class="sections-grid">
    <div class="section-card">
        <div class="section-header">
            <div class="section-icon"><i class="fas fa-book"></i></div>
            <h3 class="section-title">Current Courses</h3>
        </div>
        <div class="item-list">
            <div class="list-item">
                <div class="item-icon"><i class="fas fa-code"></i></div>
                <div class="item-content">
                    <div class="item-title">Web Programming</div>
                    <div class="item-desc">Prof. Dr. John Doe • 3 Credits • CS301</div>
                </div>
                <div class="status-badge badge-excellent">A</div>
            </div>
            <div class="list-item">
                <div class="item-icon"><i class="fas fa-database"></i></div>
                <div class="item-content">
                    <div class="item-title">Database Systems</div>
                    <div class="item-desc">Dr. Jane Smith • 3 Credits • CS401</div>
                </div>
                <div class="status-badge badge-good">B+</div>
            </div>
            <div class="list-item">
                <div class="item-icon"><i class="fas fa-project-diagram"></i></div>
                <div class="item-content">
                    <div class="item-title">Data Structures</div>
                    <div class="item-desc">Prof. Mike Johnson • 4 Credits • CS201</div>
                </div>
                <div class="status-badge badge-excellent">A-</div>
            </div>
        </div>
    </div>

    <div class="section-card">
        <div class="section-header">
            <div class="section-icon"><i class="fas fa-tasks"></i></div>
            <h3 class="section-title">Assignments & Tasks</h3>
        </div>
        <div class="item-list">
            <div class="list-item">
                <div class="item-icon"><i class="fas fa-laptop-code"></i></div>
                <div class="item-content">
                    <div class="item-title">Laravel Project</div>
                    <div class="item-desc">Web Programming • Due: Tomorrow</div>
                </div>
                <div class="status-badge badge-pending">Due Soon</div>
            </div>
            <div class="list-item">
                <div class="item-icon"><i class="fas fa-file-alt"></i></div>
                <div class="item-content">
                    <div class="item-title">Database Design Report</div>
                    <div class="item-desc">Database Systems • Due: Next Week</div>
                </div>
                <div class="status-badge badge-warning">In Progress</div>
            </div>
            <div class="list-item">
                <div class="item-icon"><i class="fas fa-search"></i></div>
                <div class="item-content">
                    <div class="item-title">Research Proposal</div>
                    <div class="item-desc">Research Methods • Due: 2 Weeks</div>
                </div>
                <div class="status-badge badge-good">Draft Ready</div>
            </div>
        </div>
    </div>

    <div class="section-card">
        <div class="section-header">
            <div class="section-icon"><i class="fas fa-calendar-alt"></i></div>
            <h3 class="section-title">Today's Schedule</h3>
        </div>
        <div class="item-list">
            <div class="list-item">
                <div class="item-icon"><i class="fas fa-clock"></i></div>
                <div class="item-content">
                    <div class="item-title">Web Programming</div>
                    <div class="item-desc">09:00 AM - 11:00 AM • Room A301</div>
                </div>
                <div class="status-badge badge-excellent">Next</div>
            </div>
            <div class="list-item">
                <div class="item-icon"><i class="fas fa-clock"></i></div>
                <div class="item-content">
                    <div class="item-title">Database Systems</div>
                    <div class="item-desc">01:00 PM - 03:00 PM • Lab B202</div>
                </div>
                <div class="status-badge badge-good">Later</div>
            </div>
        </div>
    </div>

    <div class="section-card">
        <div class="section-header">
            <div class="section-icon"><i class="fas fa-trophy"></i></div>
            <h3 class="section-title">Academic Progress</h3>
        </div>
        <div class="item-list">
            <div class="list-item">
                <div class="item-icon"><i class="fas fa-chart-bar"></i></div>
                <div class="item-content">
                    <div class="item-title">Semester GPA</div>
                    <div class="item-desc">Current semester performance</div>
                </div>
                <div class="status-badge badge-excellent">3.85</div>
            </div>
            <div class="list-item">
                <div class="item-icon"><i class="fas fa-medal"></i></div>
                <div class="item-content">
                    <div class="item-title">Academic Standing</div>
                    <div class="item-desc">Dean's List qualification</div>
                </div>
                <div class="status-badge badge-excellent">Excellent</div>
            </div>
            <div class="list-item">
                <div class="item-icon"><i class="fas fa-graduation-cap"></i></div>
                <div class="item-content">
                    <div class="item-title">Graduation Progress</div>
                    <div class="item-desc">68% towards graduation</div>
                </div>
                <div class="status-badge badge-good">On Track</div>
            </div>
        </div>
    </div>
</div>
@endsection