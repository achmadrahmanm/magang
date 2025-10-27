@extends('mahasiswa.layout')

@section('title', 'Permohonan Mangang')
@section('page-title', 'Permohonan Mangang')

@section('content')


    <div class="assignments-header">
        <div class="filter-tabs">
            <div class="filter-tab active">
                <i class="fas fa-list"></i> Semua Permohonan
            </div>
            <div class="filter-tab">
                <i class="fas fa-clock"></i> Draft
            </div>
            <div class="filter-tab">
                <i class="fas fa-check"></i> Submitted
            </div>
            <div class="filter-tab">
                <i class="fas fa-exclamation-triangle"></i> Rejected
            </div>
            <div class="filter-tab">
                <i class="fas fa-star"></i> Approved
            </div>
        </div>

        <div class="assignments-stats">
            <div class="stat-item">
                <div class="stat-number" id="total-count">0</div>
                <div class="stat-label">Total</div>
            </div>
            <div class="stat-item">
                <div class="stat-number" id="draft-count">0</div>
                <div class="stat-label">Draft</div>
            </div>
            <div class="stat-item">
                <div class="stat-number" id="submitted-count">0</div>
                <div class="stat-label">Submitted</div>
            </div>
            <div class="stat-item">
                <div class="stat-number" id="approved-count">0</div>
                <div class="stat-label">Approved</div>
            </div>
        </div>

        <div class="add-assignment">
            <a href="{{ route('mahasiswa.form-formal-requests') }}" class="btn btn-primary  w-100 my-3">
                <i class="fas fa-plus"></i> Tambah Permohonan Mangang
            </a>
        </div>
    </div>
    <div class="assignments-list" id="assignments-list" aria-live="polite">
        <!-- Cards will be injected here -->
    </div>

    <!-- Template for an assignment card (cloned by JS) -->
    <template id="assignment-card-template">
        <div class="assignment-card">
            <div class="assignment-header">
                <div class="assignment-info">
                    <div class="assignment-title">
                        <i class="fas fa-file"></i>
                        <span class="title-text"></span>
                    </div>
                    <div class="assignment-course"> <span class="course-text"></span> </div>
                    <div class="assignment-meta">
                        <div class="meta-item">
                            <i class="fas fa-calendar meta-icon"></i>
                            <span class="created-text"></span>
                        </div>
                        <div class="meta-item">
                            <i class="fas fa-user meta-icon"></i>
                            <span class="user-text"></span>
                        </div>
                        <div class="meta-item members-item" style="display:none;">
                            <i class="fas fa-users meta-icon"></i>
                            <span class="members-text"></span>
                        </div>
                    </div>
                </div>
                <div class="assignment-status">
                    <div class="status-badge status-text"></div>
                    <div class="due-date due-date-text"></div>
                </div>
            </div>
            <div class="assignment-body">
                <div class="assignment-description description-text"></div>
                <div class="assignment-actions">
                    <div class="action-buttons buttons-container"></div>
                    <div class="progress-indicator progress-text"></div>
                </div>
            </div>
        </div>
    </template>

    <script>
        (function() {
            // Helper: get token from localStorage or cookie
            function getToken() {
                try {
                    var t = localStorage.getItem('token');
                    if (t) return t;
                } catch (e) {}
                // cookie fallback
                var match = document.cookie.match(/(^|;)\s*token\s*=\s*([^;]+)/);
                return match ? decodeURIComponent(match[2]) : null;
            }

            // Helper: show error via SweetAlert if available, otherwise alert
            function showError(title, text) {
                if (typeof Swal !== 'undefined' && Swal.fire) {
                    Swal.fire({
                        icon: 'error',
                        title: title || 'Error',
                        text: text || ''
                    });
                } else if (typeof swal !== 'undefined') {
                    swal(title || 'Error', text || '', 'error');
                } else {
                    alert((title ? title + '\n' : '') + (text || ''));
                }
            }

            // Build endpoint safely. If a global base exists, use it; otherwise fallback to relative path.
            function buildEndpoint() {
                var base = '';
                if (window.LOCAL_API) base = window.LOCAL_API;
                else if (window.localApi) base = window.localApi;
                else {
                    var meta = document.querySelector('meta[name="local-api"]');
                    if (meta) base = meta.getAttribute('content') || '';
                }
                base = (base || '').toString();
                base = base.replace(/\/$/, '');
                if (base) return base + '/mahasiswa/proposals';
                // fallback
                return '/mahasiswa/proposals';
            }

            function renderCard(proposal) {
                var tpl = document.getElementById('assignment-card-template');
                if (!tpl) return null;
                var node = tpl.content.firstElementChild.cloneNode(true);

                node.querySelector('.title-text').textContent = proposal.topic || 'No title';
                node.querySelector('.course-text').textContent = proposal.topic || '';
                node.querySelector('.created-text').textContent = (proposal.submitted_at ? 'Dibuat pada : ' + proposal
                    .submitted_at : 'Dibuat pada : -');
                node.querySelector('.user-text').textContent = proposal.user_name || '';

                // members
                var members = proposal.members || [];
                if (members.length) {
                    var membersText = members.map(function(m) {
                        return m.name;
                    }).join(', ');
                    var membersItem = node.querySelector('.members-item');
                    membersItem.style.display = '';
                    node.querySelector('.members-text').textContent = 'Group (' + members.length + ' members)';
                }

                // status badge
                var statusEl = node.querySelector('.status-text');
                statusEl.textContent = proposal.status_display || (proposal.status || '').toString();
                // apply provided badge class if present
                if (proposal.status_badge_class && false) {
                    // remove any previous badge-* classes
                    statusEl.className = 'status-badge ' + proposal.status_badge_class;
                } else {
                    // fallback class mapping
                    var cls = 'status-badge';
                    if (proposal.status === 'draft') cls += ' status-draft';
                    else if (proposal.status === 'submitted') cls += ' status-submitted';
                    else if (proposal.status === 'approved') cls += ' status-approved';
                    else if (proposal.status === 'rejected') cls += ' status-rejected';
                    statusEl.className = cls;
                }

                node.querySelector('.due-date-text').textContent = proposal.start_date || '';

                // description
                var descParts = [];
                if (proposal.topic) descParts.push('Topic : ' + proposal.topic);
                if (proposal.company) descParts.push('Instansi : ' + proposal.company);
                if (proposal.company_address) descParts.push('Alamat Instansi : ' + proposal.company_address);
                if (proposal.supervisor) descParts.push('Pembimbing Lapangan : ' + proposal.supervisor);
                node.querySelector('.description-text').innerHTML = descParts.join('<br>');

                // action buttons - simple set based on status
                var buttonsContainer = node.querySelector('.buttons-container');
                buttonsContainer.innerHTML = '';
                var a1 = document.createElement('a');
                a1.className = 'btn btn-outline';
                a1.href = '/mahasiswa/proposal/' + proposal.id + '/view-pdf';
                a1.target = '_blank';
                a1.innerHTML = '<i class="fas fa-eye"></i> Lihat Surat Pengantar Proposal';
                buttonsContainer.appendChild(a1);

                if (proposal.status === 'draft') {
                    var aEdit = document.createElement('a');
                    aEdit.className = 'btn btn-primary';
                    aEdit.href = '/mahasiswa/form-formal-requests';
                    aEdit.innerHTML = '<i class="fas fa-edit"></i> Edit Pengajuan Proposal';
                    buttonsContainer.insertBefore(aEdit, buttonsContainer.firstChild);
                }

                // progress text (if you have progress info, otherwise basic)
                var progress = proposal.progress || 0;
                node.querySelector('.progress-text').innerHTML = '<i class="fas fa-chart-pie"></i> ' + progress +
                    '% complete';

                return node;
            }

            // Update header stats based on proposals array
            function updateStats(proposals) {
                try {
                    proposals = proposals || [];
                    var total = proposals.length;
                    var draft = proposals.filter(function(p) {
                        return (p.status || '').toString().toLowerCase() === 'draft';
                    }).length;
                    var submitted = proposals.filter(function(p) {
                        return (p.status || '').toString().toLowerCase() === 'submitted';
                    }).length;
                    var approved = proposals.filter(function(p) {
                        return (p.status || '').toString().toLowerCase() === 'approved';
                    }).length;

                    var elTotal = document.getElementById('total-count');
                    if (elTotal) elTotal.textContent = total;
                    var elDraft = document.getElementById('draft-count');
                    if (elDraft) elDraft.textContent = draft;
                    var elSubmitted = document.getElementById('submitted-count');
                    if (elSubmitted) elSubmitted.textContent = submitted;
                    var elApproved = document.getElementById('approved-count');
                    if (elApproved) elApproved.textContent = approved;
                } catch (e) {
                    console.warn('Failed to update stats', e);
                }
            }

            // Main: fetch proposals and render
            function loadProposals() {
                var endpoint = buildEndpoint();
                var token = getToken();
                var headers = {
                    'Accept': 'application/json'
                };
                if (token) headers['Authorization'] = 'Bearer ' + token;

                fetch(endpoint, {
                        method: 'GET',
                        headers: headers
                    })
                    .then(function(res) {
                        if (!res.ok) throw new Error('HTTP ' + res.status);
                        return res.json();
                    })
                    .then(function(json) {
                        if (!json || !json.proposals) {
                            showError('Data Error', 'Response missing proposals.');
                            return;
                        }
                        var list = document.getElementById('assignments-list');
                        list.innerHTML = '';

                        // update header stats
                        try {
                            updateStats(json.proposals);
                        } catch (e) {
                            console.warn(e);
                        }

                        json.proposals.forEach(function(p) {
                            var card = renderCard(p);
                            if (card) list.appendChild(card);
                        });
                    })
                    .catch(function(err) {
                        console.error('Failed to load proposals', err);
                        showError('Gagal memuat permohonan', err.message || String(err));
                    });
            }

            // Run on DOM ready
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', loadProposals);
            } else {
                loadProposals();
            }
        })();
    </script>
@endsection
