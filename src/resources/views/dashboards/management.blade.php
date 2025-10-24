<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Management Dashboard - Laravel App</title>
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
            background: linear-gradient(135deg, #fd7e14 0%, #e63946 100%);
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
            border-left: 5px solid #fd7e14;
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
            background: linear-gradient(135deg, #fd7e14, #e63946);
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
            color: #fd7e14;
            margin-bottom: 0.5rem;
        }

        .stat-description {
            color: #666;
            font-size: 0.9rem;
        }

        .management-sections {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 2rem;
        }

        .management-section {
            background: white;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .management-section h3 {
            color: #333;
            margin-bottom: 1.5rem;
            font-size: 1.3rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .management-item {
            display: flex;
            align-items: center;
            padding: 1rem;
            border: 1px solid #e1e5e9;
            border-radius: 8px;
            margin-bottom: 1rem;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .management-item:hover {
            background: #f8f9fa;
            border-color: #fd7e14;
        }

        .management-item:last-child {
            margin-bottom: 0;
        }

        .management-icon {
            width: 45px;
            height: 45px;
            background: linear-gradient(135deg, #fd7e14, #e63946);
            color: white;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1rem;
            font-size: 1.2rem;
        }

        .management-content {
            flex: 1;
        }

        .management-title {
            color: #333;
            font-weight: 600;
            margin-bottom: 0.25rem;
        }

        .management-desc {
            color: #666;
            font-size: 0.85rem;
        }

        .status-indicator {
            padding: 0.25rem 0.75rem;
            border-radius: 15px;
            font-size: 0.8rem;
            font-weight: 600;
            margin-left: auto;
        }

        .status-excellent {
            background: #d4edda;
            color: #155724;
        }

        .status-good {
            background: #d1ecf1;
            color: #0c5460;
        }

        .status-warning {
            background: #fff3cd;
            color: #856404;
        }

        .status-critical {
            background: #f8d7da;
            color: #721c24;
        }

        .chart-placeholder {
            background: #f8f9fa;
            border: 2px dashed #dee2e6;
            border-radius: 8px;
            padding: 2rem;
            text-align: center;
            color: #6c757d;
            margin-top: 1rem;
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

            .management-sections {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>
    <div class="header">
        <div>
            <h1>
                📊 Management Dashboard
                <span class="role-badge">MANAGEMENT</span>
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
            <h2>Executive Management Dashboard</h2>
            <p>Strategic overview and institutional performance metrics</p>
        </div>

        <div class="stats-grid">
            <div class="stat-card">
                <h3>Total Students</h3>
                <div class="stat-number">2,847</div>
                <div class="stat-description">Active enrollment</div>
            </div>
            <div class="stat-card">
                <h3>Faculty Members</h3>
                <div class="stat-number">156</div>
                <div class="stat-description">Teaching staff</div>
            </div>
            <div class="stat-card">
                <h3>Departments</h3>
                <div class="stat-number">8</div>
                <div class="stat-description">Academic departments</div>
            </div>
            <div class="stat-card">
                <h3>Revenue (YTD)</h3>
                <div class="stat-number">$2.4M</div>
                <div class="stat-description">Year to date</div>
            </div>
        </div>

        <div class="management-sections">
            <div class="management-section">
                <h3>🎓 Academic Performance</h3>
                <div class="management-item">
                    <div class="management-icon">📈</div>
                    <div class="management-content">
                        <div class="management-title">Overall GPA</div>
                        <div class="management-desc">Institution-wide academic performance</div>
                    </div>
                    <div class="status-indicator status-excellent">3.42</div>
                </div>
                <div class="management-item">
                    <div class="management-icon">🎯</div>
                    <div class="management-content">
                        <div class="management-title">Graduation Rate</div>
                        <div class="management-desc">4-year program completion rate</div>
                    </div>
                    <div class="status-indicator status-good">78%</div>
                </div>
                <div class="management-item">
                    <div class="management-icon">📊</div>
                    <div class="management-content">
                        <div class="management-title">Student Retention</div>
                        <div class="management-desc">First to second year retention</div>
                    </div>
                    <div class="status-indicator status-excellent">89%</div>
                </div>
                <div class="management-item">
                    <div class="management-icon">🏆</div>
                    <div class="management-content">
                        <div class="management-title">Accreditation Status</div>
                        <div class="management-desc">All programs fully accredited</div>
                    </div>
                    <div class="status-indicator status-excellent">A+</div>
                </div>
            </div>

            <div class="management-section">
                <h3>💰 Financial Overview</h3>
                <div class="management-item">
                    <div class="management-icon">💵</div>
                    <div class="management-content">
                        <div class="management-title">Tuition Revenue</div>
                        <div class="management-desc">Current semester collection</div>
                    </div>
                    <div class="status-indicator status-excellent">$1.8M</div>
                </div>
                <div class="management-item">
                    <div class="management-icon">📋</div>
                    <div class="management-content">
                        <div class="management-title">Operating Budget</div>
                        <div class="management-desc">Annual budget utilization</div>
                    </div>
                    <div class="status-indicator status-good">72%</div>
                </div>
                <div class="management-item">
                    <div class="management-icon">🎁</div>
                    <div class="management-content">
                        <div class="management-title">Scholarship Fund</div>
                        <div class="management-desc">Available student aid</div>
                    </div>
                    <div class="status-indicator status-warning">$450K</div>
                </div>
                <div class="management-item">
                    <div class="management-icon">🏗️</div>
                    <div class="management-content">
                        <div class="management-title">Infrastructure</div>
                        <div class="management-desc">Facilities maintenance budget</div>
                    </div>
                    <div class="status-indicator status-good">$320K</div>
                </div>
            </div>

            <div class="management-section">
                <h3>👥 Human Resources</h3>
                <div class="management-item">
                    <div class="management-icon">👨‍🏫</div>
                    <div class="management-content">
                        <div class="management-title">Faculty Satisfaction</div>
                        <div class="management-desc">Annual faculty survey results</div>
                    </div>
                    <div class="status-indicator status-good">4.2/5</div>
                </div>
                <div class="management-item">
                    <div class="management-icon">📚</div>
                    <div class="management-content">
                        <div class="management-title">Research Output</div>
                        <div class="management-desc">Publications this year</div>
                    </div>
                    <div class="status-indicator status-excellent">127</div>
                </div>
                <div class="management-item">
                    <div class="management-icon">🎓</div>
                    <div class="management-content">
                        <div class="management-title">Faculty Development</div>
                        <div class="management-desc">Training programs completed</div>
                    </div>
                    <div class="status-indicator status-good">45</div>
                </div>
                <div class="management-item">
                    <div class="management-icon">💼</div>
                    <div class="management-content">
                        <div class="management-title">Staff Turnover</div>
                        <div class="management-desc">Annual staff retention rate</div>
                    </div>
                    <div class="status-indicator status-warning">12%</div>
                </div>
            </div>

            <div class="management-section">
                <h3>🏢 Operations & Infrastructure</h3>
                <div class="management-item">
                    <div class="management-icon">🖥️</div>
                    <div class="management-content">
                        <div class="management-title">IT Systems</div>
                        <div class="management-desc">System uptime and performance</div>
                    </div>
                    <div class="status-indicator status-excellent">99.8%</div>
                </div>
                <div class="management-item">
                    <div class="management-icon">📚</div>
                    <div class="management-content">
                        <div class="management-title">Library Resources</div>
                        <div class="management-desc">Digital and physical collections</div>
                    </div>
                    <div class="status-indicator status-good">85K</div>
                </div>
                <div class="management-item">
                    <div class="management-icon">🏫</div>
                    <div class="management-content">
                        <div class="management-title">Facility Utilization</div>
                        <div class="management-desc">Classroom and lab usage</div>
                    </div>
                    <div class="status-indicator status-good">82%</div>
                </div>
                <div class="management-item">
                    <div class="management-icon">🌱</div>
                    <div class="management-content">
                        <div class="management-title">Sustainability</div>
                        <div class="management-desc">Green initiatives progress</div>
                    </div>
                    <div class="status-indicator status-excellent">A-</div>
                </div>
            </div>

            <div class="management-section">
                <h3>📈 Strategic Initiatives</h3>
                <div class="management-item">
                    <div class="management-icon">🌐</div>
                    <div class="management-content">
                        <div class="management-title">Digital Transformation</div>
                        <div class="management-desc">Modernization project status</div>
                    </div>
                    <div class="status-indicator status-good">68%</div>
                </div>
                <div class="management-item">
                    <div class="management-icon">🤝</div>
                    <div class="management-content">
                        <div class="management-title">Industry Partnerships</div>
                        <div class="management-desc">Active corporate collaborations</div>
                    </div>
                    <div class="status-indicator status-excellent">24</div>
                </div>
                <div class="management-item">
                    <div class="management-icon">🎯</div>
                    <div class="management-content">
                        <div class="management-title">Strategic Goals</div>
                        <div class="management-desc">5-year plan progress</div>
                    </div>
                    <div class="status-indicator status-good">73%</div>
                </div>
            </div>

            <div class="management-section">
                <h3>📊 Analytics & Reporting</h3>
                <div class="chart-placeholder">
                    <p>📊 Interactive Charts & Reports</p>
                    <p style="font-size: 0.9rem; margin-top: 0.5rem;">Detailed analytics dashboard would be integrated
                        here</p>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
