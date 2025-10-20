@extends('mahasiswa.layout')

@section('title', 'My Assignments')
@section('page-title', 'Assignments & Tasks')

@section('content')


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
                    Create a full-stack e-commerce web application using Laravel framework. Include user authentication,
                    product catalog, shopping cart, and payment integration.
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
                    Design a comprehensive database schema for a library management system. Include ER diagrams,
                    normalization analysis, and SQL implementation.
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
                    Write a research proposal on a topic related to computer science. Include literature review,
                    methodology, and expected outcomes.
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
                    Analyze the time and space complexity of various sorting algorithms. Implement and compare their
                    performance.
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
