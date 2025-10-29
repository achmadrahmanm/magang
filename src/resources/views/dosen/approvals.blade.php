@extends('dosen.layout')

@section('page-title', 'My Approvals')

@section('content')
<div class="approvals-container">
    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="stats-card">
                <div class="stats-icon bg-success">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stats-content">
                    <h3 class="stats-number">{{ $totalApproved ?? 0 }}</h3>
                    <p class="stats-label">Total Approved</p>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="stats-card">
                <div class="stats-icon bg-primary">
                    <i class="fas fa-calendar-alt"></i>
                </div>
                <div class="stats-content">
                    <h3 class="stats-number">{{ $approvedThisMonth ?? 0 }}</h3>
                    <p class="stats-label">This Month</p>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="stats-card">
                <div class="stats-icon bg-info">
                    <i class="fas fa-chart-line"></i>
                </div>
                <div class="stats-content">
                    <h3 class="stats-number">{{ $successRate ?? 0 }}%</h3>
                    <p class="stats-label">Success Rate</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Approved Applications List -->
    <div class="assignment-card">
        <div class="assignment-header">
            <div class="assignment-info">
                <div class="assignment-title">
                    <i class="fas fa-check-circle"></i> Approved Applications
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
                            <th>Approved Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($approvedApplications ?? [] as $application)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="user-avatar me-3">
                                        @if($application->student && $application->student->user && $application->student->user->identity && $application->student->user->identity->image)
                                            <img src="{{ $application->student->user->identity->image_url }}" alt="Profile">
                                        @else
                                            {{ $application->student ? substr($application->student->nama_resmi, 0, 2) : 'N/A' }}
                                        @endif
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark">{{ $application->student ? $application->student->nama_resmi : 'N/A' }}</div>
                                        <div class="text-muted small">{{ $application->student ? $application->student->email_kampus : 'N/A' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="fw-semibold">{{ $application->title }}</td>
                            <td>{{ $application->businessField ? $application->businessField->name : ($application->business_field ?? 'N/A') }}</td>
                            <td>{{ $application->updated_at->format('d M Y') }}</td>
                            <td>
                                <div class="action-buttons">
                                    <a href="{{ route('dosen.applications.show', $application->id) }}" class="btn btn-outline">
                                        <i class="fas fa-eye"></i> View
                                    </a>
                                    <a href="{{ route('dosen.applications.download', $application->id) }}" class="btn btn-primary">
                                        <i class="fas fa-download"></i> Download
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5">
                                <div class="empty-state">
                                    <i class="fas fa-check-circle"></i>
                                    <p>No approved applications found</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Recent Approval Activity -->
    <div class="assignment-card mt-4">
        <div class="assignment-header">
            <div class="assignment-info">
                <div class="assignment-title">
                    <i class="fas fa-history"></i> Recent Approval Activity
                </div>
            </div>
        </div>
        <div class="assignment-body">
            <div class="activity-list">
                @forelse($recentApprovals ?? [] as $approval)
                <div class="activity-item">
                    <div class="activity-icon bg-success">
                        <i class="fas fa-check"></i>
                    </div>
                    <div class="activity-content">
                        <h5 class="activity-title">{{ $approval->title }}</h5>
                        <p class="activity-meta">
                            Student: {{ $approval->student ? $approval->student->nama_resmi : 'N/A' }} • 
                            {{ $approval->updated_at->diffForHumans() }}
                        </p>
                    </div>
                </div>
                @empty
                <div class="empty-state">
                    <i class="fas fa-history"></i>
                    <p>No recent approvals</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection