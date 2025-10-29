@extends('dosen.layout')

@section('page-title', 'Applications')

@section('content')
<div class="applications-container">
    <!-- Filters -->
    <div class="filter-form">
        <form method="GET" action="{{ route('dosen.applications') }}">
            <div class="row">
                <div class="col-12 col-md-2 mb-3 mb-md-0">
                    <label class="form-label-modern">Status</label>
                    <select name="status" class="form-control-modern w-100" style="height: 52px;">
                        <option value="">All Status</option>
                        <option value="submitted" {{ request('status') == 'submitted' ? 'selected' : '' }}>Submitted</option>
                        <option value="reviewing" {{ request('status') == 'reviewing' ? 'selected' : '' }}>Reviewing</option>
                        <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                        <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>
                </div>
                <div class="col-12 col-md-8 mb-3 mb-md-0">
                    <label class="form-label-modern">Search</label>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search applications..." class="form-control-modern w-100">
                </div>
                <div class="col-12 col-md-2 d-flex align-items-end ">
                    <button type="submit" class="btn btn-primary  w-100" style="height: 52px">
                        <i class="fas fa-search"></i> Filter
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Applications List -->
    <div class="assignment-card">
        <div class="assignment-header">
            <div class="assignment-info">
                <div class="assignment-title">
                    <i class="fas fa-book"></i> All Applications
                </div>
            </div>
        </div>
        <div class="assignment-body">
            <div class="table-responsive">
                <table class="table table-modern">
                    <thead>
                        <tr>
                            <th>Student</th>
                            <th>Institution</th>
                            <th>Business Field</th>
                            <th>Status</th>
                            <th>Submitted</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($applications ?? [] as $application)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="user-avatar me-3">
                                        @if($application->submittedBy->identity && $application->submittedBy->identity->image)
                                            <img src="{{ $application->submittedBy->identity->image_url }}" alt="Profile">
                                        @else
                                            {{ substr($application->submittedBy->name, 0, 2) }}
                                        @endif
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark">{{ $application->submittedBy->name }}</div>
                                        <div class="text-muted small">{{ $application->submittedBy->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="fw-semibold">{{ $application->institution_name }}</td>
                            <td>{{ $application->business_field }}</td>
                            <td>
                                <span class="badge
                                    @if($application->status == 'approved') text-bg-success
                                    @elseif($application->status == 'submitted') text-bg-warning
                                    @elseif($application->status == 'reviewing') text-bg-primary
                                    @elseif($application->status == 'rejected') text-bg-danger
                                    @else text-bg-secondary @endif">
                                    {{ ucfirst($application->status) }}
                                </span>
                            </td>
                            <td>{{ $application->created_at->format('d M Y') }}</td>
                            <td>
                                <div class="action-buttons">
                                    <a href="{{ route('dosen.applications.show', $application->id) }}" class="btn btn-outline">
                                        <i class="fas fa-eye"></i> View
                                    </a>
                                    @if($application->status == 'submitted')
                                    <button type="button" class="btn btn-primary choose-reviewer-btn" data-application-id="{{ $application->id }}">
                                        <i class="fas fa-user-check"></i> Choose Reviewer
                                    </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6">
                                <div class="empty-state">
                                    <i class="fas fa-inbox"></i>
                                    <p>No applications found</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Choose Reviewer Modal -->
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    let selectedApplicationId = null;
    let selectedReviewerId = null;

    // Handle choose reviewer button click
    document.querySelectorAll('.choose-reviewer-btn').forEach(button => {
        button.addEventListener('click', function() {
            selectedApplicationId = this.getAttribute('data-application-id');
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
</script>
@endsection