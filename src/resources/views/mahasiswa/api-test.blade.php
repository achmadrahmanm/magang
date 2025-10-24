@extends('mahasiswa.layout')

@section('title', 'API Test - Proposal System')
@section('page-title', 'API Test - Proposal System')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card-modern">
                    <h3 class="text-primary mb-4">
                        <i class="fas fa-code"></i>
                        API Endpoints Test
                    </h3>

                    <div class="row">
                        <!-- API Endpoints List -->
                        <div class="col-md-6">
                            <h5>Available API Endpoints:</h5>
                            <div class="list-group">
                                <div class="list-group-item">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-1">Store Proposal</h6>
                                        <small class="text-primary">POST</small>
                                    </div>
                                    <p class="mb-1"><code>/mahasiswa/store-proposal</code></p>
                                    <small>Submit internship proposal with file upload</small>
                                </div>

                                <div class="list-group-item">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-1">Save Draft</h6>
                                        <small class="text-success">POST</small>
                                    </div>
                                    <p class="mb-1"><code>/mahasiswa/save-draft</code></p>
                                    <small>Save proposal as draft (AJAX)</small>
                                </div>

                                <div class="list-group-item">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-1">Get Proposals</h6>
                                        <small class="text-info">GET</small>
                                    </div>
                                    <p class="mb-1"><code>/mahasiswa/proposals</code></p>
                                    <small class="text-muted">Retrieve user's proposals list</small>
                                </div>

                                <div class="list-group-item">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-1">Download Proposal</h6>
                                        <small class="text-warning">GET</small>
                                    </div>
                                    <p class="mb-1"><code>/mahasiswa/proposal/{id}/download</code></p>
                                    <small class="text-muted">Download proposal PDF file</small>
                                </div>

                                <div class="list-group-item">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-1">Preview Proposal</h6>
                                        <small class="text-warning">GET</small>
                                    </div>
                                    <p class="mb-1"><code>/mahasiswa/proposal/{id}/preview</code></p>
                                    <small class="text-muted">Preview proposal PDF in browser</small>
                                </div>

                                <div class="list-group-item">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-1">Delete Proposal</h6>
                                        <small class="text-danger">DELETE</small>
                                    </div>
                                    <p class="mb-1"><code>/mahasiswa/proposal/{id}</code></p>
                                    <small class="text-muted">Delete proposal (testing only)</small>
                                </div>

                                <div class="list-group-item">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-1">Business Fields</h6>
                                        <small class="text-info">GET</small>
                                    </div>
                                    <p class="mb-1"><code>/mahasiswa/business-fields</code></p>
                                    <small class="text-muted">Get business field options</small>
                                </div>
                            </div>
                        </div>

                        <!-- Test Actions -->
                        <div class="col-md-6">
                            <h5>Test Actions:</h5>

                            <div class="card mb-3">
                                <div class="card-body">
                                    <h6 class="card-title">Get My Proposals</h6>
                                    <p class="card-text">Retrieve current user's proposals from session storage</p>
                                    <button class="btn btn-primary-custom" onclick="testGetProposals()">
                                        <i class="fas fa-list"></i> Test Get Proposals
                                    </button>
                                </div>
                            </div>

                            <div class="card mb-3">
                                <div class="card-body">
                                    <h6 class="card-title">Get Business Fields</h6>
                                    <p class="card-text">Retrieve available business field options</p>
                                    <button class="btn btn-outline-primary-custom" onclick="testGetBusinessFields()">
                                        <i class="fas fa-industry"></i> Test Business Fields
                                    </button>
                                </div>
                            </div>

                            <div class="card mb-3">
                                <div class="card-body">
                                    <h6 class="card-title">Form Links</h6>
                                    <p class="card-text">Navigate to proposal form</p>
                                    <a href="{{ route('mahasiswa.form-formal-requests') }}" class="btn btn-gradient">
                                        <i class="fas fa-edit"></i> Go to Proposal Form
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Results Display -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <h5>Test Results:</h5>
                            <div id="testResults" class="border rounded p-3"
                                style="background: #f8f9fa; min-height: 200px;">
                                <em class="text-muted">Click test buttons above to see API responses...</em>
                            </div>
                        </div>
                    </div>

                    <!-- Current Session Data -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <h5>Current Session Data:</h5>
                            <div class="accordion" id="sessionAccordion">
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#proposalsData">
                                            <i class="fas fa-database me-2"></i>
                                            Stored Proposals
                                            ({{ session('user_proposals') ? count(session('user_proposals')) : 0 }})
                                        </button>
                                    </h2>
                                    <div id="proposalsData" class="accordion-collapse collapse"
                                        data-bs-parent="#sessionAccordion">
                                        <div class="accordion-body">
                                            <pre><code>{{ json_encode(session('user_proposals', []), JSON_PRETTY_PRINT) }}</code></pre>
                                        </div>
                                    </div>
                                </div>

                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#draftData">
                                            <i class="fas fa-save me-2"></i>
                                            Draft Data
                                        </button>
                                    </h2>
                                    <div id="draftData" class="accordion-collapse collapse"
                                        data-bs-parent="#sessionAccordion">
                                        <div class="accordion-body">
                                            <pre><code>{{ json_encode(session('proposal_draft'), JSON_PRETTY_PRINT) ?: 'No draft saved' }}</code></pre>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function testGetProposals() {
            showLoading();

            fetch('{{ route('mahasiswa.getProposals') }}', {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    displayResult('Get Proposals API', data);
                })
                .catch(error => {
                    displayError('Get Proposals API', error);
                });
        }

        function testGetBusinessFields() {
            showLoading();

            fetch('{{ route('mahasiswa.business-fields') }}', {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    displayResult('Business Fields API', data);
                })
                .catch(error => {
                    displayError('Business Fields API', error);
                });
        }

        function showLoading() {
            document.getElementById('testResults').innerHTML = `
        <div class="text-center">
            <i class="fas fa-spinner fa-spin fa-2x text-primary"></i>
            <p class="mt-2">Loading...</p>
        </div>
    `;
        }

        function displayResult(title, data) {
            const timestamp = new Date().toLocaleString();
            document.getElementById('testResults').innerHTML = `
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i>
            <strong>${title} - Success</strong>
            <small class="text-muted float-end">${timestamp}</small>
        </div>
        <pre><code>${JSON.stringify(data, null, 2)}</code></pre>
    `;
        }

        function displayError(title, error) {
            const timestamp = new Date().toLocaleString();
            document.getElementById('testResults').innerHTML = `
        <div class="alert alert-danger">
            <i class="fas fa-exclamation-circle"></i>
            <strong>${title} - Error</strong>
            <small class="text-muted float-end">${timestamp}</small>
        </div>
        <pre><code>${error.message || error}</code></pre>
    `;
        }
    </script>

    <style>
        pre {
            background: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 4px;
            padding: 1rem;
            font-size: 0.85rem;
            max-height: 300px;
            overflow-y: auto;
        }

        .list-group-item {
            border-left: 4px solid var(--primary-color);
        }

        .accordion-button:not(.collapsed) {
            background-color: rgba(var(--primary-rgb), 0.1);
            color: var(--primary-color);
        }
    </style>
@endsection
