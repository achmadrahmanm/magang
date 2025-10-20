@extends('mahasiswa.layout')

@section('title', 'My Courses')
@section('page-title', 'My Courses')

@section('content')
<style>
    .courses-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        gap: 2rem;
        margin-bottom: 2rem;
    }

    .course-card {
        background: white;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        border: 1px solid #f0f0f0;
    }

    .course-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.15);
    }

    .course-header {
        padding: 1.5rem;
        background: linear-gradient(135deg, #29166F, #4c2c91);
        color: white;
        position: relative;
    }

    .course-code {
        font-size: 0.9rem;
        opacity: 0.9;
        font-weight: 500;
    }

    .course-title {
        font-size: 1.3rem;
        font-weight: 700;
        margin: 0.5rem 0;
    }

    .course-lecturer {
        font-size: 0.95rem;
        opacity: 0.9;
    }

    .course-body {
        padding: 1.5rem;
    }

    .course-info {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .info-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .info-icon {
        color: #29166F;
        width: 20px;
    }

    .info-text {
        color: #666;
        font-size: 0.9rem;
    }

    .course-progress {
        margin-bottom: 1.5rem;
    }

    .progress-label {
        display: flex;
        justify-content: space-between;
        margin-bottom: 0.5rem;
        font-size: 0.9rem;
        color: #333;
        font-weight: 600;
    }

    .progress-bar {
        height: 8px;
        background: #f0f0f0;
        border-radius: 4px;
        overflow: hidden;
    }

    .progress-fill {
        height: 100%;
        background: linear-gradient(135deg, #29166F, #4c2c91);
        border-radius: 4px;
        transition: width 0.3s ease;
    }

    .course-actions {
        display: flex;
        gap: 0.75rem;
    }

    .btn {
        padding: 0.5rem 1rem;
        border: none;
        border-radius: 8px;
        font-size: 0.85rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-primary {
        background: #29166F;
        color: white;
    }

    .btn-primary:hover {
        background: #1f0e4f;
        transform: translateY(-2px);
    }

    .btn-outline {
        background: transparent;
        color: #29166F;
        border: 2px solid #29166F;
    }

    .btn-outline:hover {
        background: #29166F;
        color: white;
    }

    .semester-filter {
        background: white;
        padding: 1.5rem;
        border-radius: 12px;
        margin-bottom: 2rem;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }

    .filter-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: #333;
        margin-bottom: 1rem;
    }

    .filter-tabs {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
    }

    .filter-tab {
        padding: 0.5rem 1rem;
        border: 2px solid #e9ecef;
        border-radius: 25px;
        background: white;
        color: #666;
        cursor: pointer;
        transition: all 0.3s ease;
        font-size: 0.9rem;
        font-weight: 500;
    }

    .filter-tab.active,
    .filter-tab:hover {
        border-color: #29166F;
        background: #29166F;
        color: white;
    }

    @media (max-width: 768px) {
        .courses-grid {
            grid-template-columns: 1fr;
        }

        .course-info {
            grid-template-columns: 1fr;
        }

        .course-actions {
            flex-direction: column;
        }
    }
</style>

<div class="semester-filter">
    <div class="filter-title"><i class="fas fa-filter"></i> Filter by Semester</div>
    <div class="filter-tabs">
        <div class="filter-tab active">All Courses</div>
        <div class="filter-tab">Current Semester</div>
        <div class="filter-tab">Semester 1</div>
        <div class="filter-tab">Semester 2</div>
        <div class="filter-tab">Semester 3</div>
        <div class="filter-tab">Semester 4</div>
        <div class="filter-tab">Semester 5</div>
    </div>
</div>

<div class="courses-grid">
    <div class="course-card">
        <div class="course-header">
            <div class="course-code">CS301</div>
            <div class="course-title">Web Programming</div>
            <div class="course-lecturer">Prof. Dr. John Doe</div>
        </div>
        <div class="course-body">
            <div class="course-info">
                <div class="info-item">
                    <i class="fas fa-calendar info-icon"></i>
                    <span class="info-text">Semester 5</span>
                </div>
                <div class="info-item">
                    <i class="fas fa-certificate info-icon"></i>
                    <span class="info-text">3 Credits</span>
                </div>
                <div class="info-item">
                    <i class="fas fa-clock info-icon"></i>
                    <span class="info-text">Mon, Wed 09:00</span>
                </div>
                <div class="info-item">
                    <i class="fas fa-map-marker-alt info-icon"></i>
                    <span class="info-text">Room A301</span>
                </div>
            </div>
            <div class="course-progress">
                <div class="progress-label">
                    <span>Course Progress</span>
                    <span>85%</span>
                </div>
                <div class="progress-bar">
                    <div class="progress-fill" style="width: 85%"></div>
                </div>
            </div>
            <div class="course-actions">
                <a href="#" class="btn btn-primary">
                    <i class="fas fa-book-open"></i> View Details
                </a>
                <a href="#" class="btn btn-outline">
                    <i class="fas fa-tasks"></i> Assignments
                </a>
            </div>
        </div>
    </div>

    <div class="course-card">
        <div class="course-header">
            <div class="course-code">CS401</div>
            <div class="course-title">Database Systems</div>
            <div class="course-lecturer">Dr. Jane Smith</div>
        </div>
        <div class="course-body">
            <div class="course-info">
                <div class="info-item">
                    <i class="fas fa-calendar info-icon"></i>
                    <span class="info-text">Semester 5</span>
                </div>
                <div class="info-item">
                    <i class="fas fa-certificate info-icon"></i>
                    <span class="info-text">3 Credits</span>
                </div>
                <div class="info-item">
                    <i class="fas fa-clock info-icon"></i>
                    <span class="info-text">Tue, Thu 13:00</span>
                </div>
                <div class="info-item">
                    <i class="fas fa-map-marker-alt info-icon"></i>
                    <span class="info-text">Lab B202</span>
                </div>
            </div>
            <div class="course-progress">
                <div class="progress-label">
                    <span>Course Progress</span>
                    <span>72%</span>
                </div>
                <div class="progress-bar">
                    <div class="progress-fill" style="width: 72%"></div>
                </div>
            </div>
            <div class="course-actions">
                <a href="#" class="btn btn-primary">
                    <i class="fas fa-book-open"></i> View Details
                </a>
                <a href="#" class="btn btn-outline">
                    <i class="fas fa-tasks"></i> Assignments
                </a>
            </div>
        </div>
    </div>

    <div class="course-card">
        <div class="course-header">
            <div class="course-code">CS201</div>
            <div class="course-title">Data Structures & Algorithms</div>
            <div class="course-lecturer">Prof. Mike Johnson</div>
        </div>
        <div class="course-body">
            <div class="course-info">
                <div class="info-item">
                    <i class="fas fa-calendar info-icon"></i>
                    <span class="info-text">Semester 5</span>
                </div>
                <div class="info-item">
                    <i class="fas fa-certificate info-icon"></i>
                    <span class="info-text">4 Credits</span>
                </div>
                <div class="info-item">
                    <i class="fas fa-clock info-icon"></i>
                    <span class="info-text">Wed, Fri 10:00</span>
                </div>
                <div class="info-item">
                    <i class="fas fa-map-marker-alt info-icon"></i>
                    <span class="info-text">Room C105</span>
                </div>
            </div>
            <div class="course-progress">
                <div class="progress-label">
                    <span>Course Progress</span>
                    <span>90%</span>
                </div>
                <div class="progress-bar">
                    <div class="progress-fill" style="width: 90%"></div>
                </div>
            </div>
            <div class="course-actions">
                <a href="#" class="btn btn-primary">
                    <i class="fas fa-book-open"></i> View Details
                </a>
                <a href="#" class="btn btn-outline">
                    <i class="fas fa-tasks"></i> Assignments
                </a>
            </div>
        </div>
    </div>

    <div class="course-card">
        <div class="course-header">
            <div class="course-code">CS501</div>
            <div class="course-title">Research Methodology</div>
            <div class="course-lecturer">Dr. Sarah Wilson</div>
        </div>
        <div class="course-body">
            <div class="course-info">
                <div class="info-item">
                    <i class="fas fa-calendar info-icon"></i>
                    <span class="info-text">Semester 5</span>
                </div>
                <div class="info-item">
                    <i class="fas fa-certificate info-icon"></i>
                    <span class="info-text">2 Credits</span>
                </div>
                <div class="info-item">
                    <i class="fas fa-clock info-icon"></i>
                    <span class="info-text">Fri 14:00</span>
                </div>
                <div class="info-item">
                    <i class="fas fa-map-marker-alt info-icon"></i>
                    <span class="info-text">Room D201</span>
                </div>
            </div>
            <div class="course-progress">
                <div class="progress-label">
                    <span>Course Progress</span>
                    <span>65%</span>
                </div>
                <div class="progress-bar">
                    <div class="progress-fill" style="width: 65%"></div>
                </div>
            </div>
            <div class="course-actions">
                <a href="#" class="btn btn-primary">
                    <i class="fas fa-book-open"></i> View Details
                </a>
                <a href="#" class="btn btn-outline">
                    <i class="fas fa-tasks"></i> Assignments
                </a>
            </div>
        </div>
    </div>

    <div class="course-card">
        <div class="course-header">
            <div class="course-code">CS302</div>
            <div class="course-title">Software Engineering</div>
            <div class="course-lecturer">Prof. Alex Brown</div>
        </div>
        <div class="course-body">
            <div class="course-info">
                <div class="info-item">
                    <i class="fas fa-calendar info-icon"></i>
                    <span class="info-text">Semester 5</span>
                </div>
                <div class="info-item">
                    <i class="fas fa-certificate info-icon"></i>
                    <span class="info-text">3 Credits</span>
                </div>
                <div class="info-item">
                    <i class="fas fa-clock info-icon"></i>
                    <span class="info-text">Mon, Thu 15:00</span>
                </div>
                <div class="info-item">
                    <i class="fas fa-map-marker-alt info-icon"></i>
                    <span class="info-text">Room A205</span>
                </div>
            </div>
            <div class="course-progress">
                <div class="progress-label">
                    <span>Course Progress</span>
                    <span>78%</span>
                </div>
                <div class="progress-bar">
                    <div class="progress-fill" style="width: 78%"></div>
                </div>
            </div>
            <div class="course-actions">
                <a href="#" class="btn btn-primary">
                    <i class="fas fa-book-open"></i> View Details
                </a>
                <a href="#" class="btn btn-outline">
                    <i class="fas fa-tasks"></i> Assignments
                </a>
            </div>
        </div>
    </div>

    <div class="course-card">
        <div class="course-header">
            <div class="course-code">CS402</div>
            <div class="course-title">Computer Networks</div>
            <div class="course-lecturer">Dr. Lisa Wang</div>
        </div>
        <div class="course-body">
            <div class="course-info">
                <div class="info-item">
                    <i class="fas fa-calendar info-icon"></i>
                    <span class="info-text">Semester 5</span>
                </div>
                <div class="info-item">
                    <i class="fas fa-certificate info-icon"></i>
                    <span class="info-text">3 Credits</span>
                </div>
                <div class="info-item">
                    <i class="fas fa-clock info-icon"></i>
                    <span class="info-text">Tue, Fri 08:00</span>
                </div>
                <div class="info-item">
                    <i class="fas fa-map-marker-alt info-icon"></i>
                    <span class="info-text">Lab C301</span>
                </div>
            </div>
            <div class="course-progress">
                <div class="progress-label">
                    <span>Course Progress</span>
                    <span>82%</span>
                </div>
                <div class="progress-bar">
                    <div class="progress-fill" style="width: 82%"></div>
                </div>
            </div>
            <div class="course-actions">
                <a href="#" class="btn btn-primary">
                    <i class="fas fa-book-open"></i> View Details
                </a>
                <a href="#" class="btn btn-outline">
                    <i class="fas fa-tasks"></i> Assignments
                </a>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script>
    // Filter functionality
    const filterTabs = document.querySelectorAll('.filter-tab');
    
    filterTabs.forEach(tab => {
        tab.addEventListener('click', function() {
            // Remove active class from all tabs
            filterTabs.forEach(t => t.classList.remove('active'));
            
            // Add active class to clicked tab
            this.classList.add('active');
            
            // Here you would implement the actual filtering logic
            console.log('Filter by:', this.textContent);
        });
    });
</script>
@endsection
@endsection
