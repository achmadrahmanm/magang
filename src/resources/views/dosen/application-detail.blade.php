@extends('dosen.layout')

@section('page-title', 'Application Details')

@section('content')
<div class="application-detail-container">
    <!-- Application Header -->
    <div class="assignment-card">
        <div class="assignment-header">
            <div class="assignment-info">
                <div class="assignment-title">
                    <i class="fas fa-file-alt"></i> Application Details
                </div>
                <div class="assignment-meta">
                    <span class="badge
                        @if($application->status == 'approved') text-bg-success
                        @elseif($application->status == 'submitted') text-bg-warning
                        @elseif($application->status == 'reviewing') text-bg-primary
                        @elseif($application->status == 'rejected') text-bg-danger
                        @else text-bg-secondary @endif">
                        {{ ucfirst($application->status) }}
                    </span>
                </div>
            </div>
        </div>
        <div class="assignment-body">
            <div class="row">
                <div class="col-md-8">
                    <h4 class="mb-3">{{ $application->title }}</h4>
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Institution:</strong> {{ $application->institution_name }}</p>
                            <p><strong>Business Field:</strong> {{ $application->businessField ? $application->businessField->name : ($application->business_field ?? 'N/A') }}</p>
                            <p><strong>Submitted By:</strong> {{ $application->submittedBy->name }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Submitted Date:</strong> {{ $application->created_at->format('M d, Y H:i') }}</p>
                            <p><strong>Planned Dates:</strong> {{ $application->planned_start_date->format('M d, Y') }} - {{ $application->planned_end_date->format('M d, Y') }}</p>
                            @if($application->reviewed_by)
                            <p><strong>Reviewed By:</strong> {{ $application->reviewedBy->name }}</p>
                            @endif
                        </div>
                    </div>
                    @if($application->notes)
                    <div class="mt-3">
                        <strong>Notes:</strong>
                        <p>{{ $application->notes }}</p>
                    </div>
                    @endif
                </div>
                <div class="col-md-4">
                    <div class="text-center">
                        @if($application->student && $application->student->user && $application->student->user->identity && $application->student->user->identity->image)
                            <img src="{{ $application->student->user->identity->image_url }}" alt="Student" class="img-fluid rounded-circle mb-3" style="max-width: 120px;">
                        @else
                            <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 120px; height: 120px;">
                                <span class="text-muted fs-1">{{ $application->student ? substr($application->student->nama_resmi, 0, 2) : 'N/A' }}</span>
                            </div>
                        @endif
                        <h5>{{ $application->student ? $application->student->nama_resmi : 'N/A' }}</h5>
                        <p class="text-muted">{{ $application->student ? $application->student->email_kampus : 'N/A' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Team Members -->
    @if($application->members->count() > 0)
    <div class="assignment-card mt-4">
        <div class="assignment-header">
            <div class="assignment-info">
                <div class="assignment-title">
                    <i class="fas fa-users"></i> Team Members
                </div>
            </div>
        </div>
        <div class="assignment-body">
            <div class="row">
                @foreach($application->members as $member)
                <div class="col-md-6 mb-3">
                    <div class="d-flex align-items-center">
                        <div class="user-avatar me-3">
                            @if($member->student->user && $member->student->user->identity && $member->student->user->identity->image)
                                <img src="{{ $member->student->user->identity->image_url }}" alt="Profile">
                            @else
                                {{ substr($member->student->nama_resmi, 0, 2) }}
                            @endif
                        </div>
                        <div>
                            <h6 class="mb-1">{{ $member->student->nama_resmi }}</h6>
                            <p class="text-muted small mb-1">{{ $member->student->email_kampus }}</p>
                            <span class="badge bg-primary">{{ ucfirst($member->role) }}</span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    <!-- Documents -->
    @if($application->documents->count() > 0)
    <div class="assignment-card mt-4">
        <div class="assignment-header">
            <div class="assignment-info">
                <div class="assignment-title">
                    <i class="fas fa-file"></i> Documents
                </div>
            </div>
        </div>
        <div class="assignment-body">
            <div class="row">
                @foreach($application->documents as $document)
                <div class="col-md-6 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="card-title">{{ $document->original_filename }}</h6>
                            <p class="card-text small text-muted">
                                Type: {{ $document->document_type }} |
                                Size: {{ $document->formatted_file_size }} |
                                Uploaded: {{ $document->created_at->format('M d, Y') }}
                            </p>
                            @if($document->is_verified)
                            <span class="badge bg-success">Verified</span>
                            @else
                            <span class="badge bg-warning">Pending Verification</span>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    <!-- Actions -->
    <div class="assignment-card mt-4">
        <div class="assignment-header">
            <div class="assignment-info">
                <div class="assignment-title">
                    <i class="fas fa-cogs"></i> Actions
                </div>
            </div>
        </div>
        <div class="assignment-body">
            <div class="action-buttons">
                <a href="{{ route('dosen.applications') }}" class="btn btn-outline">
                    <i class="fas fa-arrow-left"></i> Back to Applications
                </a>
                @if($application->status == 'submitted')
                <button type="button" class="btn btn-primary choose-reviewer-btn" data-application-id="{{ $application->id }}">
                    <i class="fas fa-user-check"></i> Choose Reviewer
                </button>
                @endif
                @if($application->status == 'reviewing' && $application->reviewed_by == Auth::id())
                <form method="POST" action="{{ route('dosen.applications.approve', $application->id) }}" class="d-inline">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-check"></i> Approve
                    </button>
                </form>
                <form method="POST" action="{{ route('dosen.applications.reject', $application->id) }}" class="d-inline">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to reject this application?')">
                        <i class="fas fa-times"></i> Reject
                    </button>
                </form>
                @endif
                <a href="{{ route('dosen.applications.download', $application->id) }}" class="btn btn-primary">
                    <i class="fas fa-download"></i> Download
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Choose Reviewer Modal -->
@if($application->status == 'submitted')
<div class="modal fade" id="chooseReviewerModal" tabindex="-1" aria-labelledby="chooseReviewerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="chooseReviewerModalLabel">Choose Reviewer</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="reviewersList" class="row">
                    <!-- Reviewers will be loaded here -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="assignReviewerBtn" disabled>Assign Reviewer</button>
            </div>
        </div>
    </div>
</div>
@endif

<script>
@if($application->status == 'submitted')
document.addEventListener('DOMContentLoaded', function() {
    let selectedApplicationId = {{ $application->id }};
    let selectedReviewerId = null;

    // Handle choose reviewer button click
    document.querySelectorAll('.choose-reviewer-btn').forEach(button => {
        button.addEventListener('click', function() {
            selectedReviewerId = null;
            document.getElementById('assignReviewerBtn').disabled = true;

            // Fetch available reviewers
            fetch('{{ route("dosen.applications.available-reviewer") }}')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        displayReviewers(data.reviewers);
                        new bootstrap.Modal(document.getElementById('chooseReviewerModal')).show();
                    } else {
                        alert('Failed to load reviewers');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Failed to load reviewers');
                });
        });
    });

    // Display reviewers in the modal
    function displayReviewers(reviewers) {
        const reviewersList = document.getElementById('reviewersList');
        reviewersList.innerHTML = '';

        if (reviewers.length === 0) {
            reviewersList.innerHTML = '<div class="col-12"><p class="text-center text-muted">No reviewers available</p></div>';
            return;
        }

        reviewers.forEach(reviewer => {
            const reviewerCard = `
                <div class="col-md-6 mb-3">
                    <div class="card reviewer-card ${selectedReviewerId === reviewer.id ? 'selected' : ''}" 
                         data-reviewer-id="${reviewer.id}" 
                         style="cursor: pointer; border: 2px solid ${selectedReviewerId === reviewer.id ? '#007bff' : '#dee2e6'}">
                        <div class="card-body d-flex align-items-center">
                            <div class="user-avatar me-3">
                                ${reviewer.avatar ? 
                                    `<img src="${reviewer.avatar}" alt="Profile" style="width: 40px; height: 40px; border-radius: 50%;">` : 
                                    `<div style="width: 40px; height: 40px; border-radius: 50%; background: #007bff; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold;">${reviewer.name.charAt(0)}</div>`
                                }
                            </div>
                            <div>
                                <h6 class="card-title mb-1">${reviewer.name}</h6>
                                <p class="card-text text-muted small mb-0">${reviewer.email}</p>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            reviewersList.insertAdjacentHTML('beforeend', reviewerCard);
        });

        // Add click handlers to reviewer cards
        document.querySelectorAll('.reviewer-card').forEach(card => {
            card.addEventListener('click', function() {
                // Remove selected class from all cards
                document.querySelectorAll('.reviewer-card').forEach(c => {
                    c.classList.remove('selected');
                    c.style.borderColor = '#dee2e6';
                });

                // Add selected class to clicked card
                this.classList.add('selected');
                this.style.borderColor = '#007bff';

                selectedReviewerId = parseInt(this.getAttribute('data-reviewer-id'));
                document.getElementById('assignReviewerBtn').disabled = false;
            });
        });
    }

    // Handle assign reviewer button click
    document.getElementById('assignReviewerBtn').addEventListener('click', function() {
        if (!selectedApplicationId || !selectedReviewerId) {
            alert('Please select a reviewer');
            return;
        }

        // Submit the assignment
        fetch(`/dosen/applications/${selectedApplicationId}/choose-reviewer`, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                reviewer_id: selectedReviewerId
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Close modal
                bootstrap.Modal.getInstance(document.getElementById('chooseReviewerModal')).hide();

                // Show success message
                alert(data.message);

                // Reload the page to update the status
                location.reload();
            } else {
                alert(data.message || 'Failed to assign reviewer');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Failed to assign reviewer');
        });
    });
});
@endif
</script>
@endsection