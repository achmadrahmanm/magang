@extends('dosen.layout')


@section('title', 'Applications Review')
@section('page-title', 'Applications Review')

@section('content')
    <div class="approvals-container">
        <!-- Stats Cards -->
        <div class="row mb-4">
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="stats-card">
                    <div class="stats-icon bg-secondary text-white">
                        <i class="fas fa-list-check"></i>
                    </div>
                    <div class="stats-content">
                        <h3 class="stats-number">{{ $totalReviewed ?? 0 }}</h3>
                        <p class="stats-label">Total Reviewed</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="stats-card">
                    <div class="stats-icon status-approved">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="stats-content">
                        <h3 class="stats-number">{{ $totalApproved ?? 0 }}</h3>
                        <p class="stats-label">Approved</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="stats-card">
                    <div class="stats-icon status-rejected">
                        <i class="fas fa-times-circle"></i>
                    </div>
                    <div class="stats-content">
                        <h3 class="stats-number">{{ $totalRejected ?? 0 }}</h3>
                        <p class="stats-label">Rejected</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="stats-card">
                    <div class="stats-icon status-reviewing">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="stats-content">
                        <h3 class="stats-number">{{ $totalReviewing ?? 0 }}</h3>
                        <p class="stats-label">In Review</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Additional Stats -->
        <div class="row mb-4">
            <div class="col-lg-6 col-md-6 mb-4">
                <div class="stats-card">
                    <div class="stats-icon bg-primary  text-white">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                    <div class="stats-content">
                        <h3 class="stats-number">{{ $approvedThisMonth ?? 0 }}</h3>
                        <p class="stats-label">Approved This Month</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 mb-4">
                <div class="stats-card">
                    <div class="stats-icon bg-info  text-white">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <div class="stats-content">
                        <h3 class="stats-number">{{ $successRate ?? 0 }}%</h3>
                        <p class="stats-label">Success Rate</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Reviewed Applications List -->
        <div class="assignment-card">
            <div class="assignment-header">
                <div class="assignment-info">
                    <div class="assignment-title">
                        <i class="fas fa-list-check"></i> Reviewed Applications
                    </div>
                </div>
            </div>
            <div class="assignment-body">
                <div class="table-responsive">
                    <table class="table table-modern">
                        <thead>
                            <tr>
                                <th>Student</th>
                                <th>Title</th>
                                <th>Business Field</th>
                                <th>Status</th>
                                <th>Reviewed Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($reviewedApplications ?? [] as $application)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="user-avatar me-3">
                                                @if (
                                                    $application->student &&
                                                        $application->student->user &&
                                                        $application->student->user->identity &&
                                                        $application->student->user->identity->image)
                                                    <img src="{{ $application->student->user->identity->image_url }}"
                                                        alt="Profile">
                                                @else
                                                    {{ $application->student ? substr($application->student->nama_resmi, 0, 2) : 'N/A' }}
                                                @endif
                                            </div>
                                            <div>
                                                <div class="fw-bold text-dark">
                                                    {{ $application->student ? $application->student->nama_resmi : 'N/A' }}
                                                </div>
                                                <div class="text-muted small">
                                                    {{ $application->student ? $application->student->email_kampus : 'N/A' }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="fw-semibold">{{ $application->title }}</td>
                                    <td>{{ $application->businessField ? $application->businessField->name : $application->business_field ?? 'N/A' }}
                                    </td>
                                    <td>
                                        <span class="status-badge status-{{ $application->status }}">
                                            {{ ucfirst($application->status) }}
                                        </span>
                                    </td>
                                    <td>{{ $application->reviewed_at ? $application->reviewed_at->format('d M Y') : 'N/A' }}
                                    </td>
                                    <td>
                                        <div class="action-buttons">
                                            <a href="{{ route('dosen.applications.show', $application->id) }}"
                                                class="btn btn-outline">
                                                <i class="fas fa-eye"></i> View
                                            </a>
                                            <a href="{{ route('dosen.applications.download', $application->id) }}"
                                                class="btn btn-primary">
                                                <i class="fas fa-download"></i> Download
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6">
                                        <div class="empty-state">
                                            <i class="fas fa-list-check"></i>
                                            <p>No reviewed applications found</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Recent Review Activity -->
        <div class="assignment-card mt-4">
            <div class="assignment-header">
                <div class="assignment-info">
                    <div class="assignment-title">
                        <i class="fas fa-history"></i> Recent Review Activity
                    </div>
                </div>
            </div>
            <div class="assignment-body">
                <div class="activity-list">
                    @forelse($recentReviews ?? [] as $review)
                        <div class="activity-item">
                            <div class="activity-icon status-{{ $review->status }}">
                                @if ($review->status === 'approved')
                                    <i class="fas fa-check"></i>
                                @elseif($review->status === 'rejected')
                                    <i class="fas fa-times"></i>
                                @else
                                    <i class="fas fa-clock"></i>
                                @endif
                            </div>
                            <div class="activity-content">
                                <h5 class="activity-title">{{ $review->title }}</h5>
                                <p class="activity-meta">
                                    Student: {{ $review->student ? $review->student->nama_resmi : 'N/A' }} •
                                    Status:
                                    <span class="text-{{ $review->status }}">{{ ucfirst($review->status) }}</span>
                                    • {{ $review->reviewed_at ? $review->reviewed_at->diffForHumans() : 'N/A' }}
                                </p>
                            </div>
                        </div>
                    @empty
                        <div class="empty-state">
                            <i class="fas fa-history"></i>
                            <p>No recent reviews</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection
