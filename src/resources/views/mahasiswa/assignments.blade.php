@extends('mahasiswa.layout')

@section('title', 'My Assignments')
@section('page-title', 'Assignments & Tasks')

@section('content')
<style>
    .assignments-header {
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        padding: 2rem;
        margin-bottom: 2rem;
        border: 1px solid #f0f0f0;
    }

    .filter-tabs {
        display: flex;
        gap: 0.5rem;
        margin-bottom: 1.5rem;
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
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .filter-tab.active,
    .filter-tab:hover {
        border-color: #28a745;
        background: #28a745;
        color: white;
    }

    .assignments-stats {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 1rem;
    }

    .stat-item {
        text-align: center;
        padding: 1rem;
        border: 2px solid #f0f0f0;
        border-radius: 8px;
        transition: all 0.3s ease;
    }

    .stat-item:hover {
        border-color: #28a745;
    }

    .stat-number {
        font-size: 1.5rem;
        font-weight: bold;
        color: #333;
        margin-bottom: 0.25rem;
    }

    .stat-label {
        color: #666;
        font-size: 0.85rem;
    }

    .assignments-list {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }

    .assignment-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        overflow: hidden;
        border: 1px solid #f0f0f0;
        transition: all 0.3s ease;
    }

    .assignment-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.15);
    }

    .assignment-header {
        padding: 1.5rem;
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        border-bottom: 1px solid #f0f0f0;
    }

    .assignment-info {
        flex: 1;
    }

    .assignment-title {
        font-size: 1.2rem;
        font-weight: 700;
        color: #333;
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .assignment-course {
        color: #666;
        font-size: 0.9rem;
        margin-bottom: 0.5rem;
    }

    .assignment-meta {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .meta-item {
        display: flex;
        align-items: center;
        gap: 0.25rem;
        font-size: 0.85rem;
        color: #666;
    }

    .meta-icon {
        color: #28a745;
    }

    .assignment-status {
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        gap: 0.5rem;
    }

    .status-badge {
        padding: 0.4rem 1rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .status-pending {
        background: #fff3cd;
        color: #856404;
    }

    .status-submitted {
        background: #d4edda;
        color: #155724;
    }

    .status-overdue {
        background: #f8d7da;
        color: #721c24;
    }

    .status-graded {
        background: #d1ecf1;
        color: #0c5460;
    }

    .due-date {
        font-size: 0.9rem;
        font-weight: 600;
        color: #333;
    }

    .assignment-body {
        padding: 1.5rem;
    }

    .assignment-description {
        color: #666;
        line-height: 1.6;
        margin-bottom: 1.5rem;
    }

    .assignment-attachments {
        margin-bottom: 1.5rem;
    }

    .attachment-title {
        font-size: 0.9rem;
        font-weight: 600;
        color: #333;
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .attachment-list {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
    }

    .attachment-item {
        padding: 0.5rem 0.75rem;
        background: #f8f9fa;
        border: 1px solid #e9ecef;
        border-radius: 6px;
        font-size: 0.8rem;
        color: #666;
        text-decoration: none;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }

    .attachment-item:hover {
        background: #e9ecef;
        color: #333;
    }

    .assignment-actions {
        display: flex;
        gap: 1rem;
        justify-content: space-between;
        align-items: center;
    }

    .action-buttons {
        display: flex;
        gap: 0.5rem;
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
        background: #28a745;
        color: white;
    }

    .btn-primary:hover {
        background: #218838;
        transform: translateY(-2px);
    }

    .btn-outline {
        background: transparent;
        color: #28a745;
        border: 2px solid #28a745;
    }

    .btn-outline:hover {
        background: #28a745;
        color: white;
    }

    .progress-indicator {
        flex: 1;
        text-align: right;
        font-size: 0.85rem;
        color: #666;
    }

    @media (max-width: 768px) {
        .assignments-header {
            padding: 1.5rem 1rem;
        }

        .assignment-header {
            flex-direction: column;
            gap: 1rem;
        }

        .assignment-status {
            align-items: flex-start;
            flex-direction: row;
            justify-content: space-between;
            width: 100%;
        }

        .assignment-actions {
            flex-direction: column;
            gap: 1rem;
        }

        .action-buttons {
            width: 100%;
            justify-content: space-between;
        }
    }
</style>

<div class="assignments-header">
    <div class="filter-tabs">
        <div class="filter-tab active">
            <i class="fas fa-list"></i> All Assignments
        </div>
        <div class="filter-tab">
            <i class="fas fa-clock"></i> Pending
        </div>
        <div class="filter-tab">
            <i class="fas fa-check"></i> Submitted
        </div>
        <div class="filter-tab">
            <i class="fas fa-exclamation-triangle"></i> Overdue
        </div>
        <div class="filter-tab">
            <i class="fas fa-star"></i> Graded
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
</div>

<div class="assignments-list">
    <div class="assignment-card">
        <div class="assignment-header">
            <div class="assignment-info">
                <div class="assignment-title">
                    <i class="fas fa-code"></i>
                    Laravel E-commerce Project
                </div>
                <div class="assignment-course">Web Programming - CS301</div>
                <div class="assignment-meta">
                    <div class="meta-item">
                        <i class="fas fa-calendar meta-icon"></i>
                        <span>Assigned: Oct 1, 2025</span>
                    </div>
                    <div class="meta-item">
                        <i class="fas fa-user meta-icon"></i>
                        <span>Prof. Dr. John Doe</span>
                    </div>
                    <div class="meta-item">
                        <i class="fas fa-users meta-icon"></i>
                        <span>Individual</span>
                    </div>
                </div>
            </div>
            <div class="assignment-status">
                <div class="status-badge status-pending">Due Tomorrow</div>
                <div class="due-date">Oct 10, 2025</div>
            </div>
        </div>
        <div class="assignment-body">
            <div class="assignment-description">
                Create a full-stack e-commerce web application using Laravel framework. Include user authentication, product catalog, shopping cart, and payment integration.
            </div>
            <div class="assignment-attachments">
                <div class="attachment-title">
                    <i class="fas fa-paperclip"></i>
                    Resources
                </div>
                <div class="attachment-list">
                    <a href="#" class="attachment-item">
                        <i class="fas fa-file-pdf"></i>
                        Project Requirements.pdf
                    </a>
                    <a href="#" class="attachment-item">
                        <i class="fas fa-file-code"></i>
                        Starter Template.zip
                    </a>
                </div>
            </div>
            <div class="assignment-actions">
                <div class="action-buttons">
                    <a href="#" class="btn btn-primary">
                        <i class="fas fa-upload"></i> Submit Work
                    </a>
                    <a href="#" class="btn btn-outline">
                        <i class="fas fa-eye"></i> View Details
                    </a>
                </div>
                <div class="progress-indicator">
                    <i class="fas fa-clock"></i> 18 hours remaining
                </div>
            </div>
        </div>
    </div>

    <div class="assignment-card">
        <div class="assignment-header">
            <div class="assignment-info">
                <div class="assignment-title">
                    <i class="fas fa-database"></i>
                    Database Design Report
                </div>
                <div class="assignment-course">Database Systems - CS401</div>
                <div class="assignment-meta">
                    <div class="meta-item">
                        <i class="fas fa-calendar meta-icon"></i>
                        <span>Assigned: Sep 25, 2025</span>
                    </div>
                    <div class="meta-item">
                        <i class="fas fa-user meta-icon"></i>
                        <span>Dr. Jane Smith</span>
                    </div>
                    <div class="meta-item">
                        <i class="fas fa-users meta-icon"></i>
                        <span>Group (3 members)</span>
                    </div>
                </div>
            </div>
            <div class="assignment-status">
                <div class="status-badge status-pending">In Progress</div>
                <div class="due-date">Oct 15, 2025</div>
            </div>
        </div>
        <div class="assignment-body">
            <div class="assignment-description">
                Design a comprehensive database schema for a library management system. Include ER diagrams, normalization analysis, and SQL implementation.
            </div>
            <div class="assignment-actions">
                <div class="action-buttons">
                    <a href="#" class="btn btn-primary">
                        <i class="fas fa-edit"></i> Continue Work
                    </a>
                    <a href="#" class="btn btn-outline">
                        <i class="fas fa-users"></i> Group Chat
                    </a>
                </div>
                <div class="progress-indicator">
                    <i class="fas fa-chart-pie"></i> 60% complete
                </div>
            </div>
        </div>
    </div>

    <div class="assignment-card">
        <div class="assignment-header">
            <div class="assignment-info">
                <div class="assignment-title">
                    <i class="fas fa-search"></i>
                    Research Proposal
                </div>
                <div class="assignment-course">Research Methodology - CS501</div>
                <div class="assignment-meta">
                    <div class="meta-item">
                        <i class="fas fa-calendar meta-icon"></i>
                        <span>Assigned: Sep 20, 2025</span>
                    </div>
                    <div class="meta-item">
                        <i class="fas fa-user meta-icon"></i>
                        <span>Dr. Sarah Wilson</span>
                    </div>
                    <div class="meta-item">
                        <i class="fas fa-users meta-icon"></i>
                        <span>Individual</span>
                    </div>
                </div>
            </div>
            <div class="assignment-status">
                <div class="status-badge status-submitted">Submitted</div>
                <div class="due-date">Oct 5, 2025</div>
            </div>
        </div>
        <div class="assignment-body">
            <div class="assignment-description">
                Write a research proposal on a topic related to computer science. Include literature review, methodology, and expected outcomes.
            </div>
            <div class="assignment-actions">
                <div class="action-buttons">
                    <a href="#" class="btn btn-outline">
                        <i class="fas fa-download"></i> View Submission
                    </a>
                    <a href="#" class="btn btn-outline">
                        <i class="fas fa-comments"></i> Feedback
                    </a>
                </div>
                <div class="progress-indicator">
                    <i class="fas fa-check"></i> Submitted on time
                </div>
            </div>
        </div>
    </div>

    <div class="assignment-card">
        <div class="assignment-header">
            <div class="assignment-info">
                <div class="assignment-title">
                    <i class="fas fa-algorithm"></i>
                    Algorithm Analysis
                </div>
                <div class="assignment-course">Data Structures - CS201</div>
                <div class="assignment-meta">
                    <div class="meta-item">
                        <i class="fas fa-calendar meta-icon"></i>
                        <span>Assigned: Sep 15, 2025</span>
                    </div>
                    <div class="meta-item">
                        <i class="fas fa-user meta-icon"></i>
                        <span>Prof. Mike Johnson</span>
                    </div>
                    <div class="meta-item">
                        <i class="fas fa-users meta-icon"></i>
                        <span>Individual</span>
                    </div>
                </div>
            </div>
            <div class="assignment-status">
                <div class="status-badge status-graded">Graded: A-</div>
                <div class="due-date">Sep 30, 2025</div>
            </div>
        </div>
        <div class="assignment-body">
            <div class="assignment-description">
                Analyze the time and space complexity of various sorting algorithms. Implement and compare their performance.
            </div>
            <div class="assignment-actions">
                <div class="action-buttons">
                    <a href="#" class="btn btn-outline">
                        <i class="fas fa-eye"></i> View Grade
                    </a>
                    <a href="#" class="btn btn-outline">
                        <i class="fas fa-comment-alt"></i> Instructor Feedback
                    </a>
                </div>
                <div class="progress-indicator">
                    <i class="fas fa-trophy"></i> Grade: A- (87%)
                </div>
            </div>
        </div>
    </div>
</div>
@endsection