<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dosen Dashboard - Laravel App</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f8f9fa;
            min-height: 100vh;
        }

        .header {
            background: linear-gradient(135deg, #6f42c1 0%, #6610f2 100%);
            padding: 1rem 2rem;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .header h1 {
            font-size: 1.8rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .role-badge {
            background: rgba(255, 255, 255, 0.2);
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .user-name {
            font-weight: 500;
        }

        .logout-btn {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            border: 1px solid rgba(255, 255, 255, 0.3);
            padding: 0.5rem 1rem;
            border-radius: 6px;
            cursor: pointer;
            font-size: 0.9rem;
            transition: all 0.3s ease;
        }

        .logout-btn:hover {
            background: rgba(255, 255, 255, 0.3);
        }

        .main-content {
            padding: 2rem;
            max-width: 1400px;
            margin: 0 auto;
        }

        .welcome-card {
            background: white;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 2rem;
            text-align: center;
            border-left: 5px solid #6f42c1;
        }

        .welcome-card h2 {
            color: #333;
            margin-bottom: 0.5rem;
            font-size: 2rem;
        }

        .welcome-card p {
            color: #666;
            font-size: 1.1rem;
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
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            text-align: center;
            transition: transform 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(135deg, #6f42c1, #6610f2);
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .stat-card h3 {
            color: #333;
            font-size: 1.1rem;
            margin-bottom: 1rem;
        }

        .stat-number {
            font-size: 3rem;
            font-weight: bold;
            color: #6f42c1;
            margin-bottom: 0.5rem;
        }

        .stat-description {
            color: #666;
            font-size: 0.9rem;
        }

        .dosen-sections {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 2rem;
        }

        .dosen-section {
            background: white;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .dosen-section h3 {
            color: #333;
            margin-bottom: 1.5rem;
            font-size: 1.3rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .dosen-item {
            display: flex;
            align-items: center;
            padding: 1rem;
            border: 1px solid #e1e5e9;
            border-radius: 8px;
            margin-bottom: 1rem;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .dosen-item:hover {
            background: #f8f9fa;
            border-color: #6f42c1;
        }

        .dosen-item:last-child {
            margin-bottom: 0;
        }

        .dosen-icon {
            width: 45px;
            height: 45px;
            background: linear-gradient(135deg, #6f42c1, #6610f2);
            color: white;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1rem;
            font-size: 1.2rem;
        }

        .dosen-content {
            flex: 1;
        }

        .dosen-title {
            color: #333;
            font-weight: 600;
            margin-bottom: 0.25rem;
        }

        .dosen-desc {
            color: #666;
            font-size: 0.85rem;
        }

        .class-indicator {
            padding: 0.25rem 0.75rem;
            border-radius: 15px;
            font-size: 0.8rem;
            font-weight: 600;
            margin-left: auto;
        }

        .class-active {
            background: #d4edda;
            color: #155724;
        }

        .class-scheduled {
            background: #d1ecf1;
            color: #0c5460;
        }

        .class-pending {
            background: #fff3cd;
            color: #856404;
        }

        .class-grading {
            background: #f8d7da;
            color: #721c24;
        }

        @media (max-width: 768px) {
            .header {
                padding: 1rem;
                flex-direction: column;
                gap: 1rem;
            }

            .main-content {
                padding: 1rem;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .dosen-sections {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>
    <div class="header">
        <div>
            <h1>
                👨‍🏫 Lecturer Dashboard
                <span class="role-badge">DOSEN</span>
            </h1>
        </div>
        <div class="user-info">
            <span class="user-name">{{ Auth::user()->name }}</span>
            <form method="POST" action="{{ route('logout.post') }}" style="display: inline;">
                @csrf
                <button type="submit" class="logout-btn">Logout</button>
            </form>
        </div>
    </div>

    <div class="main-content">
        <div class="welcome-card">
            <h2>Welcome, Professor!</h2>
            <p>Manage your courses, students, and academic activities</p>
        </div>

        <div class="stats-grid">
            <div class="stat-card">
                <h3>Active Courses</h3>
                <div class="stat-number">4</div>
                <div class="stat-description">This semester</div>
            </div>
            <div class="stat-card">
                <h3>Total Students</h3>
                <div class="stat-number">156</div>
                <div class="stat-description">Across all courses</div>
            </div>
            <div class="stat-card">
                <h3>Pending Grades</h3>
                <div class="stat-number">23</div>
                <div class="stat-description">Need to be graded</div>
            </div>
            <div class="stat-card">
                <h3>Research Projects</h3>
                <div class="stat-number">3</div>
                <div class="stat-description">Active projects</div>
            </div>
        </div>

        <div class="dosen-sections">
            <div class="dosen-section">
                <h3>📚 My Courses</h3>
                <div class="dosen-item">
                    <div class="dosen-icon">💻</div>
                    <div class="dosen-content">
                        <div class="dosen-title">Web Programming</div>
                        <div class="dosen-desc">CS301 - 45 students - Semester 5</div>
                    </div>
                    <div class="class-indicator class-active">Active</div>
                </div>
                <div class="dosen-item">
                    <div class="dosen-icon">🗄️</div>
                    <div class="dosen-content">
                        <div class="dosen-title">Database Systems</div>
                        <div class="dosen-desc">CS401 - 38 students - Semester 7</div>
                    </div>
                    <div class="class-indicator class-active">Active</div>
                </div>
                <div class="dosen-item">
                    <div class="dosen-icon">📊</div>
                    <div class="dosen-content">
                        <div class="dosen-title">Data Mining</div>
                        <div class="dosen-desc">CS501 - 28 students - Semester 9</div>
                    </div>
                    <div class="class-indicator class-scheduled">Scheduled</div>
                </div>
                <div class="dosen-item">
                    <div class="dosen-icon">🔬</div>
                    <div class="dosen-content">
                        <div class="dosen-title">Research Seminar</div>
                        <div class="dosen-desc">CS601 - 15 students - Semester 11</div>
                    </div>
                    <div class="class-indicator class-active">Active</div>
                </div>
            </div>

            <div class="dosen-section">
                <h3>📝 Grading & Assessment</h3>
                <div class="dosen-item">
                    <div class="dosen-icon">📋</div>
                    <div class="dosen-content">
                        <div class="dosen-title">Midterm Exams</div>
                        <div class="dosen-desc">Web Programming - 12 exams pending</div>
                    </div>
                    <div class="class-indicator class-grading">Grading</div>
                </div>
                <div class="dosen-item">
                    <div class="dosen-icon">📄</div>
                    <div class="dosen-content">
                        <div class="dosen-title">Project Submissions</div>
                        <div class="dosen-desc">Database Systems - 8 projects to review</div>
                    </div>
                    <div class="class-indicator class-pending">Review</div>
                </div>
                <div class="dosen-item">
                    <div class="dosen-icon">✅</div>
                    <div class="dosen-content">
                        <div class="dosen-title">Assignment Grading</div>
                        <div class="dosen-desc">Data Mining - 3 assignments pending</div>
                    </div>
                    <div class="class-indicator class-grading">Grading</div>
                </div>
            </div>

            <div class="dosen-section">
                <h3>📅 Schedule & Activities</h3>
                <div class="dosen-item">
                    <div class="dosen-icon">🕐</div>
                    <div class="dosen-content">
                        <div class="dosen-title">Today's Classes</div>
                        <div class="dosen-desc">2 lectures scheduled for today</div>
                    </div>
                    <div class="class-indicator class-active">Today</div>
                </div>
                <div class="dosen-item">
                    <div class="dosen-icon">👥</div>
                    <div class="dosen-content">
                        <div class="dosen-title">Office Hours</div>
                        <div class="dosen-desc">Student consultations - 2:00 PM</div>
                    </div>
                    <div class="class-indicator class-scheduled">Scheduled</div>
                </div>
                <div class="dosen-item">
                    <div class="dosen-icon">📊</div>
                    <div class="dosen-content">
                        <div class="dosen-title">Faculty Meeting</div>
                        <div class="dosen-desc">Department meeting - Friday 10 AM</div>
                    </div>
                    <div class="class-indicator class-pending">Upcoming</div>
                </div>
            </div>

            <div class="dosen-section">
                <h3>🔬 Research & Publications</h3>
                <div class="dosen-item">
                    <div class="dosen-icon">📚</div>
                    <div class="dosen-content">
                        <div class="dosen-title">Machine Learning in Healthcare</div>
                        <div class="dosen-desc">Research project - 2 PhD students</div>
                    </div>
                    <div class="class-indicator class-active">Active</div>
                </div>
                <div class="dosen-item">
                    <div class="dosen-icon">📖</div>
                    <div class="dosen-content">
                        <div class="dosen-title">Journal Publication</div>
                        <div class="dosen-desc">IEEE Paper - Under review</div>
                    </div>
                    <div class="class-indicator class-pending">Review</div>
                </div>
                <div class="dosen-item">
                    <div class="dosen-icon">🎓</div>
                    <div class="dosen-content">
                        <div class="dosen-title">Student Supervision</div>
                        <div class="dosen-desc">5 thesis students - Various stages</div>
                    </div>
                    <div class="class-indicator class-active">Ongoing</div>
                </div>
            </div>

            <div class="dosen-section">
                <h3>👥 Student Management</h3>
                <div class="dosen-item">
                    <div class="dosen-icon">📊</div>
                    <div class="dosen-content">
                        <div class="dosen-title">Class Performance</div>
                        <div class="dosen-desc">View student progress and analytics</div>
                    </div>
                    <div class="class-indicator class-active">Available</div>
                </div>
                <div class="dosen-item">
                    <div class="dosen-icon">📞</div>
                    <div class="dosen-content">
                        <div class="dosen-title">Student Consultations</div>
                        <div class="dosen-desc">Schedule and manage meetings</div>
                    </div>
                    <div class="class-indicator class-scheduled">Open</div>
                </div>
                <div class="dosen-item">
                    <div class="dosen-icon">📈</div>
                    <div class="dosen-content">
                        <div class="dosen-title">Attendance Tracking</div>
                        <div class="dosen-desc">Monitor student attendance</div>
                    </div>
                    <div class="class-indicator class-active">Updated</div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
