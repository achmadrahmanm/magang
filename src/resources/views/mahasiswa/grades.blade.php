@extends('mahasiswa.layout')

@section('title', 'My Grades')
@section('page-title', 'Academic Grades')

@section('content')
<style>
    .grades-summary {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .summary-card {
        background: white;
        padding: 2rem 1.5rem;
        border-radius: 16px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        text-align: center;
        border: 1px solid #f0f0f0;
        transition: all 0.3s ease;
    }

    .summary-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.15);
    }

    .summary-icon {
        font-size: 2.5rem;
        margin-bottom: 1rem;
    }

    .gpa-icon { color: #29166F; }
    .semester-icon { color: #007bff; }
    .credits-icon { color: #ffc107; }
    .standing-icon { color: #6f42c1; }

    .summary-value {
        font-size: 2.5rem;
        font-weight: bold;
        margin-bottom: 0.5rem;
        color: #333;
    }

    .summary-label {
        color: #666;
        font-size: 0.9rem;
        font-weight: 500;
    }

    .grades-container {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 2rem;
        margin-bottom: 2rem;
    }

    .grades-table-container {
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        overflow: hidden;
        border: 1px solid #f0f0f0;
    }

    .table-header {
        background: linear-gradient(135deg, #29166F, #4c2c91);
        color: white;
        padding: 1.5rem;
    }

    .table-title {
        font-size: 1.3rem;
        font-weight: 700;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .grades-table {
        width: 100%;
        border-collapse: collapse;
    }

    .grades-table th,
    .grades-table td {
        padding: 1rem;
        text-align: left;
        border-bottom: 1px solid #f0f0f0;
    }

    .grades-table th {
        background: #f8f9fa;
        font-weight: 600;
        color: #333;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .grades-table td {
        color: #666;
    }

    .grades-table tr:hover {
        background: #f8f9fa;
    }

    .course-code {
        font-weight: 600;
        color: #333;
    }

    .course-name {
        color: #666;
        font-size: 0.9rem;
    }

    .grade-badge {
        display: inline-block;
        padding: 0.3rem 0.8rem;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.8rem;
        text-align: center;
        min-width: 50px;
    }

    .grade-a { background: #d4edda; color: #155724; }
    .grade-b { background: #d1ecf1; color: #0c5460; }
    .grade-c { background: #fff3cd; color: #856404; }
    .grade-d { background: #f8d7da; color: #721c24; }

    .gpa-chart {
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        padding: 1.5rem;
        border: 1px solid #f0f0f0;
    }

    .chart-title {
        font-size: 1.2rem;
        font-weight: 700;
        color: #333;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .semester-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 1rem;
        border: 1px solid #f0f0f0;
        border-radius: 8px;
        margin-bottom: 0.75rem;
        transition: all 0.3s ease;
    }

    .semester-item:hover {
        border-color: #29166F;
        background: #f8fff9;
    }

    .semester-info {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .semester-number {
        width: 40px;
        height: 40px;
        background: linear-gradient(135deg, #29166F, #4c2c91);
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        font-size: 0.9rem;
    }

    .semester-details {
        flex: 1;
    }

    .semester-name {
        font-weight: 600;
        color: #333;
        margin-bottom: 0.25rem;
    }

    .semester-credits {
        color: #666;
        font-size: 0.85rem;
    }

    .semester-gpa {
        font-size: 1.1rem;
        font-weight: 700;
        color: #29166F;
    }

    .transcript-section {
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        padding: 2rem;
        border: 1px solid #f0f0f0;
        text-align: center;
    }

    .transcript-icon {
        font-size: 3rem;
        color: #29166F;
        margin-bottom: 1rem;
    }

    .transcript-title {
        font-size: 1.3rem;
        font-weight: 700;
        color: #333;
        margin-bottom: 0.5rem;
    }

    .transcript-desc {
        color: #666;
        margin-bottom: 1.5rem;
    }

    .btn-download {
        background: linear-gradient(135deg, #29166F, #4c2c91);
        color: white;
        border: none;
        padding: 0.75rem 2rem;
        border-radius: 25px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-download:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(40, 167, 69, 0.3);
        color: white;
        text-decoration: none;
    }

    @media (max-width: 768px) {
        .grades-container {
            grid-template-columns: 1fr;
        }

        .grades-table {
            font-size: 0.85rem;
        }

        .grades-table th,
        .grades-table td {
            padding: 0.75rem 0.5rem;
        }

        .summary-card {
            padding: 1.5rem 1rem;
        }
    }
</style>

<div class="grades-summary">
    <div class="summary-card">
        <div class="summary-icon gpa-icon"><i class="fas fa-chart-line"></i></div>
        <div class="summary-value">3.75</div>
        <div class="summary-label">Cumulative GPA</div>
    </div>
    <div class="summary-card">
        <div class="summary-icon semester-icon"><i class="fas fa-calendar-alt"></i></div>
        <div class="summary-value">3.85</div>
        <div class="summary-label">Current Semester GPA</div>
    </div>
    <div class="summary-card">
        <div class="summary-icon credits-icon"><i class="fas fa-certificate"></i></div>
        <div class="summary-value">98</div>
        <div class="summary-label">Total Credits</div>
    </div>
    <div class="summary-card">
        <div class="summary-icon standing-icon"><i class="fas fa-medal"></i></div>
        <div class="summary-value">Dean's List</div>
        <div class="summary-label">Academic Standing</div>
    </div>
</div>

<div class="grades-container">
    <div class="grades-table-container">
        <div class="table-header">
            <h3 class="table-title">
                <i class="fas fa-graduation-cap"></i>
                Current Semester Grades
            </h3>
        </div>
        <table class="grades-table">
            <thead>
                <tr>
                    <th>Course Code</th>
                    <th>Course Name</th>
                    <th>Credits</th>
                    <th>Grade</th>
                    <th>Points</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="course-code">CS301</td>
                    <td>
                        <div class="course-name">Web Programming</div>
                    </td>
                    <td>3</td>
                    <td><span class="grade-badge grade-a">A</span></td>
                    <td>4.0</td>
                </tr>
                <tr>
                    <td class="course-code">CS401</td>
                    <td>
                        <div class="course-name">Database Systems</div>
                    </td>
                    <td>3</td>
                    <td><span class="grade-badge grade-b">B+</span></td>
                    <td>3.5</td>
                </tr>
                <tr>
                    <td class="course-code">CS201</td>
                    <td>
                        <div class="course-name">Data Structures</div>
                    </td>
                    <td>4</td>
                    <td><span class="grade-badge grade-a">A-</span></td>
                    <td>3.7</td>
                </tr>
                <tr>
                    <td class="course-code">CS501</td>
                    <td>
                        <div class="course-name">Research Methodology</div>
                    </td>
                    <td>2</td>
                    <td><span class="grade-badge grade-a">A</span></td>
                    <td>4.0</td>
                </tr>
                <tr>
                    <td class="course-code">CS302</td>
                    <td>
                        <div class="course-name">Software Engineering</div>
                    </td>
                    <td>3</td>
                    <td><span class="grade-badge grade-b">B+</span></td>
                    <td>3.5</td>
                </tr>
                <tr>
                    <td class="course-code">CS402</td>
                    <td>
                        <div class="course-name">Computer Networks</div>
                    </td>
                    <td>3</td>
                    <td><span class="grade-badge grade-a">A-</span></td>
                    <td>3.7</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div>
        <div class="gpa-chart">
            <div class="chart-title">
                <i class="fas fa-chart-area"></i>
                GPA Progress
            </div>
            <div class="semester-item">
                <div class="semester-info">
                    <div class="semester-number">1</div>
                    <div class="semester-details">
                        <div class="semester-name">Semester 1</div>
                        <div class="semester-credits">18 Credits</div>
                    </div>
                </div>
                <div class="semester-gpa">3.45</div>
            </div>
            <div class="semester-item">
                <div class="semester-info">
                    <div class="semester-number">2</div>
                    <div class="semester-details">
                        <div class="semester-name">Semester 2</div>
                        <div class="semester-credits">20 Credits</div>
                    </div>
                </div>
                <div class="semester-gpa">3.62</div>
            </div>
            <div class="semester-item">
                <div class="semester-info">
                    <div class="semester-number">3</div>
                    <div class="semester-details">
                        <div class="semester-name">Semester 3</div>
                        <div class="semester-credits">19 Credits</div>
                    </div>
                </div>
                <div class="semester-gpa">3.78</div>
            </div>
            <div class="semester-item">
                <div class="semester-info">
                    <div class="semester-number">4</div>
                    <div class="semester-details">
                        <div class="semester-name">Semester 4</div>
                        <div class="semester-credits">21 Credits</div>
                    </div>
                </div>
                <div class="semester-gpa">3.82</div>
            </div>
            <div class="semester-item">
                <div class="semester-info">
                    <div class="semester-number">5</div>
                    <div class="semester-details">
                        <div class="semester-name">Semester 5</div>
                        <div class="semester-credits">18 Credits</div>
                    </div>
                </div>
                <div class="semester-gpa">3.85</div>
            </div>
        </div>
    </div>
</div>

<div class="transcript-section">
    <div class="transcript-icon"><i class="fas fa-file-alt"></i></div>
    <div class="transcript-title">Academic Transcript</div>
    <div class="transcript-desc">Download your official academic transcript with all course grades and GPA history</div>
    <a href="#" class="btn-download">
        <i class="fas fa-download"></i>
        Download Transcript
    </a>
</div>
@endsection
