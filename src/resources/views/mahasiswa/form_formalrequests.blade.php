@extends('mahasiswa.layout')

@section('title', 'Form Permohonan Magang')
@section('page-title', 'Form Permohonan Magang')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <!-- Header Card -->
                <div class="card-modern mb-4">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h3 class="text-primary mb-2">
                                <i class="fas fa-file-alt"></i>
                                Form Pengajuan Proposal Magang
                            </h3>
                            <p class="text-muted mb-0">
                                Lengkapi formulir di bawah ini untuk mengajukan proposal magang. Pastikan semua informasi
                                yang diisi akurat dan lengkap.
                            </p>
                        </div>
                        <div class="col-md-4 text-end">
                            <div class="assignment-status">
                                <div class="status-badge status-draft" id="draftStatusBadge">
                                    @if ($draft)
                                        <i class="fas fa-save"></i> Draft Tersimpan
                                    @else
                                        Draft
                                    @endif
                                </div>
                                @if ($draft)
                                    <div class="draft-info mt-2">
                                        <small class="text-muted">
                                            <i class="fas fa-clock"></i>
                                            Terakhir disimpan: {{ $draft['saved_at'] }}
                                        </small>
                                        <br>
                                        <button type="button" class="btn btn-sm btn-outline-primary mt-1"
                                            id="loadDraftBtn">
                                            <i class="fas fa-download"></i> Muat Draft
                                        </button>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Success/Error Messages -->
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle"></i>
                        <strong>Berhasil!</strong> {{ session('success') }}
                        @if (session('proposal_id'))
                            <br><small>ID Proposal: <strong>{{ session('proposal_id') }}</strong></small>
                        @endif
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle"></i>
                        <strong>Error!</strong> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-triangle"></i>
                        <strong>Perhatian:</strong> Terdapat kesalahan dalam pengisian form:
                        <ul class="mb-0 mt-2">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <!-- Main Form -->
                <form id="internshipForm" action="{{ route('mahasiswa.store-proposal') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf

                    <!-- Company Information Section -->
                    <div class="card-modern mb-4">
                        <div class="card-header-gradient mb-4 rounded">
                            <h5 class="mb-0">
                                <i class="fas fa-building"></i>
                                Informasi Perusahaan
                            </h5>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3 ">
                                <label class="form-label-modern" for="topic">
                                    <i class="fas fa-lightbulb text-primary"></i>
                                    Topik Magang <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control form-control-modern" id="topic" name="topic"
                                    placeholder="Masukkan topik atau judul magang..." required>
                                <div class="form-text">Contoh: Pengembangan Sistem Informasi, Data Analysis, UI/UX Design
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label-modern" for="company">
                                    <i class="fas fa-building text-primary"></i>
                                    Nama Perusahaan <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control form-control-modern" id="company" name="company"
                                    placeholder="Masukkan nama perusahaan..." required>
                            </div>

                            <div class="col-12 mb-3">
                                <label class="form-label-modern" for="company_address">
                                    <i class="fas fa-map-marker-alt text-primary"></i>
                                    Alamat Perusahaan <span class="text-danger">*</span>
                                </label>
                                <textarea class="form-control form-control-modern" id="company_address" name="company_address" rows="3"
                                    placeholder="Masukkan alamat lengkap perusahaan..." required></textarea>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label-modern" for="business_field">
                                    <i class="fas fa-industry text-primary"></i>
                                    Bidang Usaha <span class="text-danger">*</span>
                                </label>
                                <select class="form-control form-control-modern" id="business_field" name="business_field"
                                    required>
                                    <option value="">Pilih Bidang Usaha</option>
                                    @if (isset($businessFields) && $businessFields->count() > 0)
                                        @foreach ($businessFields as $field)
                                            <option value="{{ $field['code'] }}">{{ $field['name'] }}</option>
                                        @endforeach
                                    @else
                                        <option value="technology">Teknologi Informasi</option>
                                        <option value="finance">Keuangan & Perbankan</option>
                                        <option value="manufacturing">Manufaktur</option>
                                        <option value="healthcare">Kesehatan</option>
                                        <option value="education">Pendidikan</option>
                                        <option value="retail">Retail & E-commerce</option>
                                        <option value="energy">Energi & Pertambangan</option>
                                        <option value="transportation">Transportasi & Logistik</option>
                                        <option value="construction">Konstruksi & Properti</option>
                                        <option value="media">Media & Komunikasi</option>
                                        <option value="government">Pemerintahan</option>
                                        <option value="other">Lainnya</option>
                                    @endif
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label-modern" for="department">
                                    <i class="fas fa-sitemap text-primary"></i>
                                    Department <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control form-control-modern" id="department"
                                    name="department" placeholder="Contoh: IT Department, Human Resources, Marketing..."
                                    required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label-modern" for="division">
                                    <i class="fas fa-users-cog text-primary"></i>
                                    Divisi
                                </label>
                                <input type="text" class="form-control form-control-modern" id="division"
                                    name="division"
                                    placeholder="Contoh: Software Development, Digital Marketing, Data Science...">
                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="form-label-modern" for="start_date">
                                    <i class="fas fa-calendar-plus text-primary"></i>
                                    Tanggal Mulai <span class="text-danger">*</span>
                                </label>
                                <input type="date" class="form-control form-control-modern" id="start_date"
                                    name="start_date" required>
                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="form-label-modern" for="duration">
                                    <i class="fas fa-hourglass-half text-primary"></i>
                                    Durasi (bulan) <span class="text-danger">*</span>
                                </label>
                                <select class="form-control form-control-modern" id="duration" name="duration" required>
                                    <option value="">Pilih Durasi</option>
                                    <option value="1">1 Bulan</option>
                                    <option value="2">2 Bulan</option>
                                    <option value="3">3 Bulan</option>
                                    <option value="4">4 Bulan</option>
                                    <option value="5">5 Bulan</option>
                                    <option value="6">6 Bulan</option>
                                    <option value="12">12 Bulan</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Proposal Document Section -->
                    <div class="card-modern mb-4">
                        <div class="card-header-gradient mb-4 rounded">
                            <h5 class="mb-0">
                                <i class="fas fa-file-pdf"></i>
                                Dokumen Proposal
                            </h5>
                        </div>

                        <div class="row">
                            <div class="col-12 mb-3">
                                <label class="form-label-modern" for="proposal_file">
                                    <i class="fas fa-upload text-primary"></i>
                                    Upload File Proposal (PDF) <span class="text-danger">*</span>
                                </label>
                                <div class="file-upload-container">
                                    <input type="file" class="form-control form-control-modern" id="proposal_file"
                                        name="proposal_file" accept=".pdf" required>
                                    <div class="form-text">
                                        <i class="fas fa-info-circle"></i>
                                        Format: PDF | Maksimal: 10MB | Proposal harus memuat latar belakang, tujuan, dan
                                        rencana kegiatan magang
                                    </div>
                                </div>

                                <!-- File Preview Area -->
                                <div id="filePreview" class="file-preview-container mt-3" style="display: none;">
                                    <div class="preview-header">
                                        <h6><i class="fas fa-eye"></i> Preview Dokumen</h6>
                                        <button type="button" class="btn btn-sm btn-outline-primary-custom"
                                            id="previewBtn">
                                            <i class="fas fa-external-link-alt"></i> Lihat Full Screen
                                        </button>
                                    </div>
                                    <div class="pdf-preview">
                                        <embed id="pdfEmbed" src="" type="application/pdf" width="100%"
                                            height="400px">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Team Members Section -->
                    <div class="card-modern mb-4">
                        <div class="card-header-gradient mb-4 rounded">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">
                                    <i class="fas fa-users"></i>
                                    Anggota Tim Magang
                                </h5>
                                <button type="button" class="btn btn-outline bg-light btn-sm" id="addMemberBtn">
                                    <i class="fas fa-plus"></i> Tambah Anggota
                                </button>
                            </div>
                        </div>

                        <div id="membersContainer">
                            <!-- Current User as Leader -->
                            <div class="member-item member-leader" data-member-index="0">
                                <div class="member-header">
                                    <div class="member-title">
                                        <i class="fas fa-crown text-warning"></i>
                                        <strong>Ketua Tim (Anda)</strong>
                                    </div>
                                    <div class="member-actions">
                                        <span class="badge badge-primary-custom">Leader</span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <label class="form-label-modern">NRP/Student ID</label>
                                        <input type="text" class="form-control form-control-modern"
                                            name="members[0][student_id]"
                                            value="{{ Auth::user()->identity->user_id ?? '' }}" readonly>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label-modern">Nama Lengkap</label>
                                        <input type="text" class="form-control form-control-modern"
                                            name="members[0][name]" value="{{ Auth::user()->name }}" readonly>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label-modern">Email</label>
                                        <input type="email" class="form-control form-control-modern"
                                            name="members[0][email]" value="{{ Auth::user()->email }}" readonly>
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label-modern">Angkatan</label>
                                        <input type="number" class="form-control form-control-modern"
                                            name="members[0][year]" placeholder="2023" min="2015" max="2030"
                                            required>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-3">
                            <div class="alert alert-primary-custom">
                                <i class="fas fa-info-circle"></i>
                                <strong>Catatan:</strong> Anda dapat menambahkan anggota tim hingga maksimal 4 orang.
                                Pastikan semua data anggota tim telah diisi dengan benar.
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="card-modern">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="agreement" name="agreement"
                                        required>
                                    <label class="form-check-label" for="agreement">
                                        Saya menyatakan bahwa semua informasi yang diisi dalam formulir ini adalah benar dan
                                        akurat.
                                        Saya memahami bahwa data yang salah dapat mengakibatkan penolakan proposal.
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6 text-end">
                                <button type="button" class="btn btn-outline-primary-custom me-2" id="saveDraftBtn">
                                    <i class="fas fa-save"></i> Simpan Draft
                                </button>
                                <button type="submit" class="btn btn-primary-custom">
                                    <i class="fas fa-paper-plane"></i> Submit Proposal
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Member Template (Hidden) -->
    <template id="memberTemplate">
        <div class="member-item" data-member-index="">
            <div class="member-header">
                <div class="member-title">
                    <i class="fas fa-user"></i>
                    <strong>Anggota Tim #<span class="member-number"></span></strong>
                </div>
                <div class="member-actions">
                    <button type="button" class="btn btn-sm btn-outline-danger remove-member">
                        <i class="fas fa-trash"></i> Hapus
                    </button>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <label class="form-label-modern">NRP/Student ID <span class="text-danger">*</span></label>
                    <input type="text" class="form-control form-control-modern" name="members[][student_id]"
                        placeholder="Contoh: 5025211001" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label-modern">Nama Lengkap <span class="text-danger">*</span></label>
                    <input type="text" class="form-control form-control-modern" name="members[][name]"
                        placeholder="Masukkan nama lengkap..." required>
                </div>
                <div class="col-md-3">
                    <label class="form-label-modern">Email <span class="text-danger">*</span></label>
                    <input type="email" class="form-control form-control-modern" name="members[][email]"
                        placeholder="email@example.com" required>
                </div>
                <div class="col-md-2">
                    <label class="form-label-modern">Angkatan <span class="text-danger">*</span></label>
                    <input type="number" class="form-control form-control-modern" name="members[][year]"
                        placeholder="2023" min="2015" max="2030" required>
                </div>
            </div>
        </div>
    </template>

    <!-- PDF Preview Modal -->
    <div class="modal fade" id="pdfModal" tabindex="-1" aria-labelledby="pdfModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content modal-modern">
                <div class="modal-header">
                    <h5 class="modal-title" id="pdfModalLabel">
                        <i class="fas fa-file-pdf"></i> Preview Proposal
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-0">
                    <embed id="modalPdfEmbed" src="" type="application/pdf" width="100%" height="600px">
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Additional Styles for Form */
        .file-upload-container {
            position: relative;
        }

        .file-preview-container {
            border: 2px dashed var(--border-color);
            border-radius: var(--border-radius);
            padding: 1rem;
            background: #fafafa;
        }

        .preview-header {
            display: flex;
            justify-content: between;
            align-items: center;
            padding-bottom: 1rem;
            border-bottom: 1px solid var(--border-color);
            margin-bottom: 1rem;
        }

        .member-item {
            background: #f8f9fa;
            border: 2px solid var(--border-color);
            border-radius: var(--border-radius-lg);
            padding: 1.5rem;
            margin-bottom: 1rem;
            transition: var(--transition);
        }

        .member-item:hover {
            border-color: var(--primary-color);
            box-shadow: 0 4px 15px rgba(var(--primary-rgb), 0.1);
        }

        .member-leader {
            background: linear-gradient(135deg, rgba(var(--primary-rgb), 0.05), rgba(var(--primary-rgb), 0.1));
            border-color: var(--primary-color);
        }

        .member-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 1px solid var(--border-color);
        }

        .member-title {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: var(--primary-color);
        }

        .member-actions {
            display: flex;
            gap: 0.5rem;
        }

        .remove-member:hover {
            background-color: #dc3545;
            border-color: #dc3545;
            color: white;
        }

        .status-loaded {
            background: linear-gradient(135deg, #28a745, #20c997);
            animation: pulse 2s infinite;
        }

        .draft-info {
            font-size: 0.875rem;
        }

        @keyframes pulse {
            0% {
                opacity: 1;
            }

            50% {
                opacity: 0.8;
            }

            100% {
                opacity: 1;
            }
        }

        @media (max-width: 768px) {
            .member-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.5rem;
            }

            .preview-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.5rem;
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let memberCount = 1; // Start from 1 since leader is 0
            const maxMembers = 4;

            // Load draft data if exists
            @if ($draft)
                loadDraftData(@json($draft), false);
            @endif

            // Load Draft Button functionality
            document.getElementById('loadDraftBtn')?.addEventListener('click', function() {
                loadDraftFromServer();
            });

            // Function to load draft data from server
            function loadDraftFromServer() {
                const btn = document.getElementById('loadDraftBtn');
                const originalText = btn.innerHTML;
                btn.disabled = true;
                btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memuat...';

                fetch('{{ route('mahasiswa.load-draft') }}')
                    .then(response => response.json())
                    .then(data => {
                        if (data.success && data.has_draft) {
                            loadDraftData(data.draft);
                            showNotification('success', 'Draft berhasil dimuat!',
                                'Data draft telah diisi ke formulir');
                        } else {
                            showNotification('info', 'Tidak ada draft', 'Belum ada draft yang tersimpan');
                        }
                    })
                    .catch(error => {
                        console.error('Error loading draft:', error);
                        showNotification('error', 'Gagal memuat draft', 'Terjadi kesalahan saat memuat draft');
                    })
                    .finally(() => {
                        btn.disabled = false;
                        btn.innerHTML = originalText;
                    });
            }

            // Function to populate form with draft data
            function loadDraftData(draft, shouldShowNotification = true) {
                if (!draft) return;

                // Fill basic form fields
                document.getElementById('topic').value = draft.topic || '';
                document.getElementById('company').value = draft.company || '';
                document.getElementById('company_address').value = draft.company_address || '';
                document.getElementById('business_field').value = draft.business_field || '';
                document.getElementById('department').value = draft.department || '';
                document.getElementById('division').value = draft.division || '';
                document.getElementById('start_date').value = draft.start_date || '';
                document.getElementById('duration').value = draft.duration || '';

                // Clear existing additional members (keep leader)
                const membersContainer = document.getElementById('membersContainer');
                const additionalMembers = membersContainer.querySelectorAll('.member-item:not(.member-leader)');
                additionalMembers.forEach(member => member.remove());
                memberCount = 1;

                // Load members data
                if (draft.members && draft.members.length > 0) {
                    const currentUser = '{{ Auth::user()->identity->user_id ?? Auth::user()->name }}';

                    draft.members.forEach((member, index) => {
                        if (member.role === 'leader') {
                            // Update leader year field
                            const leaderYearField = document.querySelector(
                            'input[name="members[0][year]"]');
                            if (leaderYearField) {
                                leaderYearField.value = member.year || '';
                            }
                        } else {
                            // Add additional member
                            addMemberWithData(member);
                        }
                    });
                }

                // Show file info if exists
                if (draft.has_proposal_file) {
                    showDraftFileInfo(draft.proposal_file_name);
                }

                // Update status badge
                const statusBadge = document.getElementById('draftStatusBadge');
                if (statusBadge) {
                    statusBadge.innerHTML = '<i class="fas fa-save"></i> Draft Dimuat';
                    statusBadge.className = 'status-badge status-loaded';
                }

                if (shouldShowNotification) {
                    showNotification('success', 'Draft dimuat!', `Data dari ${draft.saved_at} berhasil dimuat`);
                }
            }

            // Function to add member with data
            function addMemberWithData(memberData) {
                if (memberCount >= maxMembers) return;

                const template = document.getElementById('memberTemplate');
                const memberHtml = template.innerHTML
                    .replace(/data-member-index=""/g, `data-member-index="${memberCount}"`)
                    .replace(/members\[\]\[/g, `members[${memberCount}][`)
                    .replace(/<span class="member-number"><\/span>/g, memberCount);

                const memberDiv = document.createElement('div');
                memberDiv.innerHTML = memberHtml;
                const memberElement = memberDiv.firstElementChild;

                // Fill the member data
                memberElement.querySelector('input[name$="[student_id]"]').value = memberData.student_id || '';
                memberElement.querySelector('input[name$="[name]"]').value = memberData.name || '';
                memberElement.querySelector('input[name$="[email]"]').value = memberData.email || '';
                memberElement.querySelector('input[name$="[year]"]').value = memberData.year || '';

                document.getElementById('membersContainer').appendChild(memberElement);
                memberCount++;

                // Update button state
                const addBtn = document.getElementById('addMemberBtn');
                if (memberCount >= maxMembers) {
                    addBtn.disabled = true;
                    addBtn.innerHTML = '<i class="fas fa-users"></i> Maksimal 4 Anggota';
                }
            }

            // Function to show draft file info
            function showDraftFileInfo(fileName) {
                const fileInput = document.getElementById('proposal_file');
                const previewContainer = document.getElementById('filePreview');

                // Create info message
                const infoDiv = document.createElement('div');
                infoDiv.className = 'alert alert-info mt-2';
                infoDiv.innerHTML = `
                    <i class="fas fa-info-circle"></i>
                    <strong>File draft tersimpan:</strong> ${fileName}
                    <br><small>Upload file baru untuk mengganti file draft yang tersimpan</small>
                `;

                fileInput.parentNode.appendChild(infoDiv);
            }

            // Add Member functionality
            document.getElementById('addMemberBtn').addEventListener('click', function() {
                if (memberCount >= maxMembers) {
                    alert('Maksimal 4 anggota tim (termasuk ketua)');
                    return;
                }

                const template = document.getElementById('memberTemplate');
                const memberHtml = template.innerHTML
                    .replace(/data-member-index=""/g, `data-member-index="${memberCount}"`)
                    .replace(/members\[\]\[/g, `members[${memberCount}][`)
                    .replace(/<span class="member-number"><\/span>/g, memberCount);

                const memberDiv = document.createElement('div');
                memberDiv.innerHTML = memberHtml;

                document.getElementById('membersContainer').appendChild(memberDiv.firstElementChild);
                memberCount++;

                // Update button state
                if (memberCount >= maxMembers) {
                    this.disabled = true;
                    this.innerHTML = '<i class="fas fa-users"></i> Maksimal 4 Anggota';
                }
            });

            // Remove Member functionality
            document.addEventListener('click', function(e) {
                if (e.target.classList.contains('remove-member') || e.target.parentElement.classList
                    .contains('remove-member')) {
                    const memberItem = e.target.closest('.member-item');
                    memberItem.remove();
                    memberCount--;

                    // Re-enable add button
                    const addBtn = document.getElementById('addMemberBtn');
                    addBtn.disabled = false;
                    addBtn.innerHTML = '<i class="fas fa-plus"></i> Tambah Anggota';

                    // Renumber remaining members
                    const members = document.querySelectorAll('.member-item:not(.member-leader)');
                    members.forEach((member, index) => {
                        const newIndex = index + 1;
                        member.dataset.memberIndex = newIndex;
                        member.querySelector('.member-number').textContent = newIndex;

                        // Update input names
                        const inputs = member.querySelectorAll('input');
                        inputs.forEach(input => {
                            const name = input.name.replace(/members\[\d+\]/,
                                `members[${newIndex}]`);
                            input.name = name;
                        });
                    });
                }
            });

            // File Upload and Preview functionality
            document.getElementById('proposal_file').addEventListener('change', function(e) {
                const file = e.target.files[0];
                const previewContainer = document.getElementById('filePreview');
                const pdfEmbed = document.getElementById('pdfEmbed');

                if (file && file.type === 'application/pdf') {
                    const fileURL = URL.createObjectURL(file);
                    pdfEmbed.src = fileURL;
                    previewContainer.style.display = 'block';

                    // Preview button functionality
                    document.getElementById('previewBtn').addEventListener('click', function() {
                        document.getElementById('modalPdfEmbed').src = fileURL;
                        new bootstrap.Modal(document.getElementById('pdfModal')).show();
                    });
                } else {
                    previewContainer.style.display = 'none';
                    if (file) {
                        alert('Silakan pilih file PDF');
                        e.target.value = '';
                    }
                }
            });

            // Save Draft functionality
            document.getElementById('saveDraftBtn').addEventListener('click', function() {
                const form = document.getElementById('internshipForm');
                const formData = new FormData(form);

                // Add CSRF token
                formData.append('_token', '{{ csrf_token() }}');

                // Show loading state
                const originalText = this.innerHTML;
                this.disabled = true;
                this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menyimpan...';

                fetch('{{ route('mahasiswa.save-draft') }}', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Show success message
                            showNotification('success', 'Draft berhasil disimpan!',
                                `Terakhir disimpan: ${data.saved_at}`);

                            // Update badge to show draft saved
                            const badge = document.getElementById('draftStatusBadge');
                            if (badge) {
                                badge.innerHTML = '<i class="fas fa-save"></i> Draft Tersimpan';
                                badge.className = 'status-badge status-loaded';
                            }
                        } else {
                            showNotification('error', 'Gagal menyimpan draft', data.message ||
                                'Terjadi kesalahan');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showNotification('error', 'Terjadi kesalahan',
                            'Gagal menyimpan draft. Silakan coba lagi. (from catch error)');
                    })
                    .finally(() => {
                        // Restore button state
                        this.disabled = false;
                        this.innerHTML = originalText;
                    });
            });

            // Notification function
            function showNotification(type, title, message) {
                const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
                const icon = type === 'success' ? 'fas fa-check-circle' : 'fas fa-exclamation-circle';

                const notification = document.createElement('div');
                notification.className = `alert ${alertClass} alert-dismissible fade show position-fixed`;
                notification.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
                notification.innerHTML = `
                    <i class="${icon}"></i>
                    <strong>${title}</strong> ${message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                `;

                document.body.appendChild(notification);

                // Auto remove after 5 seconds
                setTimeout(() => {
                    if (notification.parentNode) {
                        notification.remove();
                    }
                }, 5000);
            }

            // Form validation
            document.getElementById('internshipForm').addEventListener('submit', function(e) {
                const agreement = document.getElementById('agreement');
                const proposalFile = document.getElementById('proposal_file');

                if (!agreement.checked) {
                    e.preventDefault();
                    alert('Harap centang persetujuan sebelum submit');
                    return;
                }

                if (!proposalFile.files[0]) {
                    e.preventDefault();
                    alert('Harap upload file proposal');
                    return;
                }

                // Show loading state
                const submitBtn = this.querySelector('button[type="submit"]');
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Submitting...';
            });
        });
    </script>
@endsection
