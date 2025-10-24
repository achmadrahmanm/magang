<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>System Admin Dashboard - Laravel App</title>
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
            background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
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
            border-left: 5px solid #dc3545;
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
            background: linear-gradient(135deg, #dc3545, #c82333);
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
            color: #dc3545;
            margin-bottom: 0.5rem;
        }

        .stat-description {
            color: #666;
            font-size: 0.9rem;
        }

        .admin-sections {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 2rem;
        }

        .admin-section {
            background: white;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .admin-section h3 {
            color: #333;
            margin-bottom: 1.5rem;
            font-size: 1.3rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .admin-item {
            display: flex;
            align-items: center;
            padding: 1rem;
            border: 1px solid #e1e5e9;
            border-radius: 8px;
            margin-bottom: 1rem;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .admin-item:hover {
            background: #f8f9fa;
            border-color: #dc3545;
        }

        .admin-item:last-child {
            margin-bottom: 0;
        }

        .admin-icon {
            width: 45px;
            height: 45px;
            background: linear-gradient(135deg, #dc3545, #c82333);
            color: white;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1rem;
            font-size: 1.2rem;
        }

        .admin-content {
            flex: 1;
        }

        .admin-title {
            color: #333;
            font-weight: 600;
            margin-bottom: 0.25rem;
        }

        .admin-desc {
            color: #666;
            font-size: 0.85rem;
        }

        .status-indicator {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            margin-left: auto;
        }

        .status-active {
            background: #28a745;
        }

        .status-warning {
            background: #ffc107;
        }

        .status-danger {
            background: #dc3545;
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

            .admin-sections {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>
    <div class="header">
        <div>
            <h1>
                🛡️ System Admin Dashboard
                <span class="role-badge">SYSADMIN</span>
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
            <h2>System Administration Panel</h2>
            <p>Complete system control and monitoring dashboard</p>
        </div>

        <div class="stats-grid">
            <div class="stat-card">
                <h3>Total Users</h3>
                <div class="stat-number">247</div>
                <div class="stat-description">Registered users</div>
            </div>
            <div class="stat-card">
                <h3>System Uptime</h3>
                <div class="stat-number">99.9%</div>
                <div class="stat-description">Last 30 days</div>
            </div>
            <div class="stat-card">
                <h3>Database Size</h3>
                <div class="stat-number">2.4GB</div>
                <div class="stat-description">Total storage used</div>
            </div>
            <div class="stat-card">
                <h3>Active Sessions</h3>
                <div class="stat-number">56</div>
                <div class="stat-description">Current active users</div>
            </div>
        </div>

        <div class="admin-sections">
            <div class="admin-section">
                <h3>🏫 User Management</h3>
                <div class="admin-item">
                    <div class="admin-icon">👥</div>
                    <div class="admin-content">
                        <div class="admin-title">Manage Users</div>
                        <div class="admin-desc">Add, edit, or remove system users</div>
                    </div>
                    <div class="status-indicator status-active"></div>
                </div>
                <div class="admin-item">
                    <div class="admin-icon">🎓</div>
                    <div class="admin-content">
                        <div class="admin-title">Student Management</div>
                        <div class="admin-desc">Manage student accounts and data</div>
                    </div>
                    <div class="status-indicator status-active"></div>
                </div>
                <div class="admin-item">
                    <div class="admin-icon">👨‍🏫</div>
                    <div class="admin-content">
                        <div class="admin-title">Faculty Management</div>
                        <div class="admin-desc">Manage lecturer accounts</div>
                    </div>
                    <div class="status-indicator status-active"></div>
                </div>
            </div>

            <div class="admin-section">
                <h3>⚙️ System Settings</h3>
                <div class="admin-item">
                    <div class="admin-icon">🔧</div>
                    <div class="admin-content">
                        <div class="admin-title">System Configuration</div>
                        <div class="admin-desc">Configure system settings</div>
                    </div>
                    <div class="status-indicator status-active"></div>
                </div>
                <div class="admin-item">
                    <div class="admin-icon">🔐</div>
                    <div class="admin-content">
                        <div class="admin-title">Security Settings</div>
                        <div class="admin-desc">Manage security policies</div>
                    </div>
                    <div class="status-indicator status-warning"></div>
                </div>
                <div class="admin-item">
                    <div class="admin-icon">💾</div>
                    <div class="admin-content">
                        <div class="admin-title">Database Backup</div>
                        <div class="admin-desc">System backup management</div>
                    </div>
                    <div class="status-indicator status-active"></div>
                </div>
            </div>

            <div class="admin-section">
                <h3>📊 Monitoring</h3>
                <div class="admin-item">
                    <div class="admin-icon">📈</div>
                    <div class="admin-content">
                        <div class="admin-title">System Performance</div>
                        <div class="admin-desc">Monitor system resources</div>
                    </div>
                    <div class="status-indicator status-active"></div>
                </div>
                <div class="admin-item">
                    <div class="admin-icon">📋</div>
                    <div class="admin-content">
                        <div class="admin-title">Audit Logs</div>
                        <div class="admin-desc">View system activity logs</div>
                    </div>
                    <div class="status-indicator status-active"></div>
                </div>
                <div class="admin-item">
                    <div class="admin-icon">⚠️</div>
                    <div class="admin-content">
                        <div class="admin-title">Error Reports</div>
                        <div class="admin-desc">System error monitoring</div>
                    </div>
                    <div class="status-indicator status-danger"></div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
