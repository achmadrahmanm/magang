@extends('mahasiswa.layout')

@section('title', 'Digital Signature')
@section('page-title', 'Digital Signature')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <!-- Header Card -->
                <div class="card-modern mb-4">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h3 class="text-primary mb-2">
                                <i class="fas fa-signature"></i>
                                Digital Signature
                            </h3>
                            <p class="text-muted mb-0">
                                Buat dan kelola tanda tangan digital Anda untuk keperluan dokumen akademik dan administrasi.
                            </p>
                        </div>
                        <div class="col-md-4 text-end">
                            @if ($activeSignature)
                                <div class="badge bg-success text-light">
                                    <i class="fas fa-check-circle"></i> Signature Aktif
                                </div>
                            @else
                                <div class="badge bg-warning text-dark">
                                    <i class="fas fa-exclamation-triangle"></i> Belum Ada Signature
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Success/Error Messages -->
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle"></i>
                        <strong>Berhasil!</strong> {{ session('success') }}
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

                <div class="row">
                    <!-- Signature Creator -->
                    <div class="col-lg-8 mb-4">
                        <div class="card-modern">
                            <div class="card-header-gradient mb-4 rounded">
                                <h5 class="mb-0">
                                    <i class="fas fa-edit"></i>
                                    Buat Signature Baru
                                </h5>
                            </div>

                            <!-- Signature Canvas -->
                            <div class="signature-container mb-4">
                                <div class="signature-canvas-wrapper">
                                    <canvas id="signatureCanvas" class="signature-canvas"></canvas>
                                    <div class="signature-placeholder" id="signaturePlaceholder">
                                        <i class="fas fa-pen-nib"></i>
                                        <p>Tanda tangan Anda di sini</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Canvas Controls -->
                            <div class="signature-controls mb-4">
                                <div class="row align-items-center">
                                    <div class="col-md-6">
                                        <div class="d-flex gap-2">
                                            <button type="button" class="btn btn-outline-secondary" id="undoBtn">
                                                <i class="fas fa-undo"></i> Undo
                                            </button>
                                            <button type="button" class="btn btn-outline-danger" id="clearBtn">
                                                <i class="fas fa-trash"></i> Clear
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-md-6 text-end">
                                        <button type="button" class="btn btn-primary-custom" id="saveBtn" disabled>
                                            <i class="fas fa-save"></i> Save Signature
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Additional Options -->
                            <div class="signature-options">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label-modern" for="signaturePurpose">
                                            <i class="fas fa-tag text-primary"></i>
                                            Tujuan Penggunaan
                                        </label>
                                        <select class="form-control form-control-modern" id="signaturePurpose">
                                            <option value="general">Umum</option>
                                            <option value="proposal">Proposal Magang</option>
                                            <option value="document">Dokumen Resmi</option>
                                            <option value="assignment">Tugas Kuliah</option>
                                            <option value="thesis">Skripsi/Tesis</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label-modern" for="signatureNotes">
                                            <i class="fas fa-sticky-note text-primary"></i>
                                            Catatan (Opsional)
                                        </label>
                                        <input type="text" class="form-control form-control-modern" id="signatureNotes"
                                            placeholder="Catatan tambahan...">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Current Active Signature -->
                    <div class="col-lg-4 mb-4">
                        <div class="card-modern">
                            <div class="card-header-gradient mb-4 rounded">
                                <h5 class="mb-0">
                                    <i class="fas fa-star"></i>
                                    Signature Aktif
                                </h5>
                            </div>

                            @if ($activeSignature)
                                <div class="current-signature">
                                    <div class="signature-preview mb-3">
                                        <img src="{{ $activeSignature->signature_url }}" alt="Active Signature"
                                            class="img-fluid signature-image">
                                    </div>
                                    <div class="signature-info">
                                        <div class="info-row">
                                            <span class="info-label">Tujuan:</span>
                                            <span class="info-value">{{ ucfirst($activeSignature->purpose) }}</span>
                                        </div>
                                        <div class="info-row">
                                            <span class="info-label">Dibuat:</span>
                                            <span
                                                class="info-value">{{ $activeSignature->created_at->format('d M Y H:i') }}</span>
                                        </div>
                                        <div class="info-row">
                                            <span class="info-label">Ukuran:</span>
                                            <span class="info-value">{{ $activeSignature->formatted_file_size }}</span>
                                        </div>
                                        @if ($activeSignature->notes)
                                            <div class="info-row">
                                                <span class="info-label">Catatan:</span>
                                                <span class="info-value">{{ $activeSignature->notes }}</span>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="signature-actions mt-3">
                                        <button type="button" class="btn btn-outline-primary-custom btn-sm"
                                            onclick="downloadSignature('{{ $activeSignature->id }}')">
                                            <i class="fas fa-download"></i> Download
                                        </button>
                                    </div>
                                </div>
                            @else
                                <div class="text-center py-4">
                                    <i class="fas fa-signature fa-3x text-muted mb-3"></i>
                                    <p class="text-muted">Belum ada signature aktif</p>
                                    <small class="text-muted">Buat signature baru untuk memulai</small>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Signature History -->
                <div class="row">
                    <div class="col-12">
                        <div class="card-modern">
                            <div class="card-header-gradient mb-4 rounded">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0">
                                        <i class="fas fa-history"></i>
                                        Riwayat Signature
                                    </h5>
                                    <button type="button" class="btn btn-outline bg-light btn-sm"
                                        id="refreshHistoryBtn">
                                        <i class="fas fa-sync-alt"></i> Refresh
                                    </button>
                                </div>
                            </div>

                            <div id="signatureHistory">
                                <div class="text-center py-4">
                                    <i class="fas fa-spinner fa-spin fa-2x text-primary"></i>
                                    <p class="mt-2">Loading signatures...</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Preview Modal -->
    <div class="modal fade" id="signaturePreviewModal" tabindex="-1" aria-labelledby="signaturePreviewLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content modal-modern">
                <div class="modal-header">
                    <h5 class="modal-title" id="signaturePreviewLabel">
                        <i class="fas fa-eye"></i> Preview Signature
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <img id="previewImage" src="" alt="Signature Preview" class="img-fluid">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary-custom" id="setActiveFromPreview">
                        <i class="fas fa-star"></i> Set as Active
                    </button>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Signature Canvas Styles */
        .signature-container {
            position: relative;
            background: #fafafa;
            border: 2px dashed var(--border-color);
            border-radius: var(--border-radius-lg);
            padding: 1rem;
        }

        .signature-canvas-wrapper {
            position: relative;
            width: 100%;
            height: 300px;
            background: white;
            border-radius: var(--border-radius);
            overflow: hidden;
            box-shadow: var(--shadow-sm);
        }

        .signature-canvas {
            display: block;
            cursor: crosshair;
            width: 100%;
            height: 100%;
            touch-action: none;
        }

        .signature-placeholder {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
            color: #aaa;
            pointer-events: none;
            transition: opacity 0.3s ease;
        }

        .signature-placeholder i {
            font-size: 2rem;
            margin-bottom: 0.5rem;
        }

        .signature-placeholder.hidden {
            opacity: 0;
        }

        /* Current Signature */
        .current-signature {
            text-align: center;
        }

        .signature-preview {
            background: #f8f9fa;
            border: 1px solid var(--border-color);
            border-radius: var(--border-radius);
            padding: 1rem;
            min-height: 120px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .signature-image {
            max-height: 100px;
            max-width: 100%;
            border-radius: var(--border-radius);
        }

        .signature-info {
            text-align: left;
            font-size: 0.9rem;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.5rem;
        }

        .info-label {
            font-weight: 600;
            color: #666;
        }

        .info-value {
            color: #333;
        }

        /* History Cards */
        .signature-history-item {
            background: #f8f9fa;
            border: 1px solid var(--border-color);
            border-radius: var(--border-radius);
            padding: 1rem;
            margin-bottom: 1rem;
            transition: var(--transition);
        }

        .signature-history-item:hover {
            background: white;
            box-shadow: var(--shadow-sm);
            transform: translateY(-2px);
        }

        .signature-history-item.active {
            border-color: var(--primary-color);
            background: rgba(var(--primary-rgb), 0.05);
        }

        .signature-thumbnail {
            width: 80px;
            height: 50px;
            object-fit: contain;
            border: 1px solid var(--border-color);
            border-radius: 4px;
            background: white;
        }

        .signature-controls .btn {
            min-width: 100px;
        }

        @media (max-width: 768px) {
            .signature-canvas-wrapper {
                height: 200px;
            }

            .signature-controls {
                text-align: center;
            }

            .signature-controls .col-md-6 {
                margin-bottom: 1rem;
            }

            .signature-controls .text-end {
                text-align: center !important;
            }
        }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize Signature Pad
            const canvas = document.getElementById('signatureCanvas');
            const placeholder = document.getElementById('signaturePlaceholder');
            const undoBtn = document.getElementById('undoBtn');
            const clearBtn = document.getElementById('clearBtn');
            const saveBtn = document.getElementById('saveBtn');

            let signaturePad;
            let signatureHistory = [];

            function resizeCanvas() {
                const ratio = Math.max(window.devicePixelRatio || 1, 1);
                const wrapper = canvas.parentElement;
                canvas.width = wrapper.offsetWidth * ratio;
                canvas.height = wrapper.offsetHeight * ratio;
                canvas.style.width = wrapper.offsetWidth + 'px';
                canvas.style.height = wrapper.offsetHeight + 'px';
                canvas.getContext('2d').scale(ratio, ratio);
            }

            function initializeSignaturePad() {
                resizeCanvas();

                signaturePad = new SignaturePad(canvas, {
                    backgroundColor: 'rgb(255, 255, 255)',
                    penColor: 'rgb(0, 0, 0)',
                    minWidth: 1,
                    maxWidth: 3,
                    throttle: 16,
                    minPointDistance: 3,
                });

                signaturePad.addEventListener('beginStroke', function() {
                    placeholder.classList.add('hidden');
                    saveBtn.disabled = false;
                });

                signaturePad.addEventListener('endStroke', function() {
                    signatureHistory.push(signaturePad.toData());
                    undoBtn.disabled = signatureHistory.length === 0;
                });

                // Clear signature history when pad is cleared
                signaturePad.addEventListener('afterUpdateStroke', function() {
                    if (signaturePad.isEmpty()) {
                        placeholder.classList.remove('hidden');
                        saveBtn.disabled = true;
                        undoBtn.disabled = true;
                        signatureHistory = [];
                    }
                });
            }

            // Window resize handler
            window.addEventListener('resize', function() {
                resizeCanvas();
                signaturePad.clear();
                signatureHistory = [];
            });

            // Undo functionality
            undoBtn.addEventListener('click', function() {
                if (signatureHistory.length > 0) {
                    signatureHistory.pop();
                    signaturePad.clear();

                    if (signatureHistory.length > 0) {
                        signaturePad.fromData(signatureHistory[signatureHistory.length - 1]);
                    } else {
                        placeholder.classList.remove('hidden');
                        saveBtn.disabled = true;
                        undoBtn.disabled = true;
                    }
                }
            });

            // Clear functionality
            clearBtn.addEventListener('click', function() {
                signaturePad.clear();
                signatureHistory = [];
                placeholder.classList.remove('hidden');
                saveBtn.disabled = true;
                undoBtn.disabled = true;
            });

            // Save functionality
            saveBtn.addEventListener('click', function() {
                if (signaturePad.isEmpty()) {
                    showNotification('warning', 'Perhatian', 'Silakan buat signature terlebih dahulu');
                    return;
                }

                const purpose = document.getElementById('signaturePurpose').value;
                const notes = document.getElementById('signatureNotes').value;
                const signatureData = signaturePad.toDataURL('image/png');

                // Show loading state
                const originalText = saveBtn.innerHTML;
                saveBtn.disabled = true;
                saveBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menyimpan...';

                fetch('{{ route('mahasiswa.save-signature') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            signature_data: signatureData,
                            purpose: purpose,
                            notes: notes
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            showNotification('success', 'Berhasil!', data.message);

                            // Clear canvas
                            signaturePad.clear();
                            signatureHistory = [];
                            placeholder.classList.remove('hidden');

                            // Reset form
                            document.getElementById('signaturePurpose').value = 'general';
                            document.getElementById('signatureNotes').value = '';

                            // Reload page to show new active signature
                            setTimeout(() => {
                                window.location.reload();
                            }, 2000);
                        } else {
                            showNotification('error', 'Error!', data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showNotification('error', 'Error!',
                            'Terjadi kesalahan saat menyimpan signature');
                    })
                    .finally(() => {
                        saveBtn.disabled = false;
                        saveBtn.innerHTML = originalText;
                    });
            });

            // Load signature history
            function loadSignatureHistory() {
                fetch('{{ route('mahasiswa.get-signatures') }}', {
                        method: 'GET',
                        headers: {
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            displaySignatureHistory(data.signatures);
                        } else {
                            document.getElementById('signatureHistory').innerHTML = `
                    <div class="text-center py-4">
                        <i class="fas fa-exclamation-circle fa-2x text-danger"></i>
                        <p class="mt-2">Gagal memuat data signature</p>
                    </div>
                `;
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        document.getElementById('signatureHistory').innerHTML = `
                <div class="text-center py-4">
                    <i class="fas fa-exclamation-circle fa-2x text-danger"></i>
                    <p class="mt-2">Terjadi kesalahan saat memuat data</p>
                </div>
            `;
                    });
            }

            // Display signature history
            function displaySignatureHistory(signatures) {
                const historyContainer = document.getElementById('signatureHistory');

                if (signatures.length === 0) {
                    historyContainer.innerHTML = `
                <div class="text-center py-4">
                    <i class="fas fa-signature fa-2x text-muted"></i>
                    <p class="mt-2 text-muted">Belum ada signature yang tersimpan</p>
                </div>
            `;
                    return;
                }

                const historyHtml = signatures.map(signature => `
            <div class="signature-history-item ${signature.is_active ? 'active' : ''}" data-signature-id="${signature.id}">
                <div class="row align-items-center">
                    <div class="col-md-2">
                        <img src="${signature.url}" alt="Signature" class="signature-thumbnail" 
                             onclick="previewSignature('${signature.url}', ${signature.id})">
                    </div>
                    <div class="col-md-6">
                        <div class="signature-details">
                            <h6 class="mb-1">
                                ${signature.purpose.charAt(0).toUpperCase() + signature.purpose.slice(1)}
                                ${signature.is_active ? '<span class="badge badge-primary-custom ms-2">Aktif</span>' : ''}
                            </h6>
                            <small class="text-muted">
                                Dibuat: ${signature.created_at} | ${signature.file_size}
                            </small>
                            ${signature.notes ? `<br><small class="text-muted">Catatan: ${signature.notes}</small>` : ''}
                        </div>
                    </div>
                    <div class="col-md-4 text-end">
                        <div class="btn-group btn-group-sm">
                            <button type="button" class="btn btn-outline-primary-custom" 
                                    onclick="previewSignature('${signature.url}', ${signature.id})">
                                <i class="fas fa-eye"></i> Preview
                            </button>
                            ${!signature.is_active ? 
                                `<button type="button" class="btn btn-outline-success" 
                                                                    onclick="setActiveSignature(${signature.id})">
                                                                <i class="fas fa-star"></i> Set Active
                                                            </button>` : ''
                            }
                            <button type="button" class="btn btn-outline-danger" 
                                    onclick="deleteSignature(${signature.id})">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        `).join('');

                historyContainer.innerHTML = historyHtml;
            }

            // Preview signature
            window.previewSignature = function(url, id) {
                document.getElementById('previewImage').src = url;
                document.getElementById('setActiveFromPreview').dataset.signatureId = id;
                new bootstrap.Modal(document.getElementById('signaturePreviewModal')).show();
            };

            // Set active signature
            window.setActiveSignature = function(signatureId) {
                fetch(`/mahasiswa/signature/${signatureId}/set-active`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            showNotification('success', 'Berhasil!', data.message);
                            loadSignatureHistory();
                            setTimeout(() => window.location.reload(), 1500);
                        } else {
                            showNotification('error', 'Error!', data.message);
                        }
                    })
                    .catch(error => {
                        showNotification('error', 'Error!', 'Terjadi kesalahan');
                    });
            };

            // Delete signature
            window.deleteSignature = function(signatureId) {
                if (!confirm('Apakah Anda yakin ingin menghapus signature ini?')) {
                    return;
                }

                fetch(`/mahasiswa/signature/${signatureId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            showNotification('success', 'Berhasil!', data.message);
                            loadSignatureHistory();
                        } else {
                            showNotification('error', 'Error!', data.message);
                        }
                    })
                    .catch(error => {
                        showNotification('error', 'Error!', 'Terjadi kesalahan');
                    });
            };

            // Download signature
            window.downloadSignature = function(signatureId) {
                window.open(`/mahasiswa/signature/${signatureId}/download`, '_blank');
            };

            // Refresh history
            document.getElementById('refreshHistoryBtn').addEventListener('click', loadSignatureHistory);

            // Set active from preview modal
            document.getElementById('setActiveFromPreview').addEventListener('click', function() {
                const signatureId = this.dataset.signatureId;
                setActiveSignature(signatureId);
                bootstrap.Modal.getInstance(document.getElementById('signaturePreviewModal')).hide();
            });

            // Notification function
            function showNotification(type, title, message) {
                const alertClass = type === 'success' ? 'alert-success' :
                    type === 'warning' ? 'alert-warning' : 'alert-danger';
                const icon = type === 'success' ? 'fas fa-check-circle' :
                    type === 'warning' ? 'fas fa-exclamation-triangle' : 'fas fa-exclamation-circle';

                const notification = document.createElement('div');
                notification.className = `alert ${alertClass} alert-dismissible fade show position-fixed`;
                notification.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
                notification.innerHTML = `
            <i class="${icon}"></i>
            <strong>${title}</strong> ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        `;

                document.body.appendChild(notification);

                setTimeout(() => {
                    if (notification.parentNode) {
                        notification.remove();
                    }
                }, 5000);
            }

            // Initialize
            initializeSignaturePad();
            loadSignatureHistory();
        });
    </script>
@endsection
