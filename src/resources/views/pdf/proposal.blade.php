<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Pengantar Proposal Magang</title>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 12px;
            line-height: 1.5;
            margin: 0;
            padding: 20px;
            color: #333;
        }

        .document-title {
            text-align: center;
            font-size: 14px;
            font-weight: bold;
            margin: 10px 0 10px 0;
            text-decoration: underline;
        }

        .content-section {
            margin-bottom: 20px;
        }

        .section-title {
            font-weight: bold;
            margin-bottom: 10px;
            font-size: 13px;
        }

        .content-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .content-table td {
            padding: 8px 12px;
            border: 1px solid #ddd;
            vertical-align: top;
        }

        .content-table .label {
            font-weight: bold;
            width: 30%;
            background-color: #f9f9f9;
        }

        .members-section {
            margin-top: 20px;
        }

        .members-table {
            width: 100%;
            border-collapse: collapse;
        }

        .members-table th,
        .members-table td {
            border: 1px solid #333;
            padding: 8px;
            text-align: left;
        }

        .members-table th {
            background-color: #f0f0f0;
            font-weight: bold;
        }

        .footer {
            margin-top: 50px;
            text-align: right;
        }

        .signature-section {
            display: inline-block;
            text-align: right;
            margin-top: 20px;
        }

        .signature-image {
            max-width: 150px;
            max-height: 60px;
            margin-bottom: 10px;
        }

        .signature-line {
            border-bottom: 1px solid #333;
            width: 200px;
            margin: 0 auto 5px auto;
        }

        .signature-name {
            font-weight: bold;
            margin-top: 5px;
        }

        .separator {
            border-top: 2px solid #333;
            margin: 18px 0;
        }

        .date-info {
            text-align: right;
            margin-bottom: 20px;
        }

        .page-break {
            page-break-before: always;
        }

        @media print {
            body {
                margin: 0;
                padding: 15mm;
            }
        }
    </style>
</head>

<body>
    <div class="logo-section ">
        <p>DEPARTEMEN TEKNIK ELEKTRO<br>
            FTEIC - ITS</p>
    </div>

    <!-- New page: company recipient & notes (starts on a new page in the PDF) -->


    <!-- Document Title -->
    <div class="document-title">
        <h2>FORMULIR PENGAJUAN KERJA PRAKTEK</h2>
    </div>



    <!-- Members Section -->
    @if ($application->members->count() > 0)
        <div class="members-section">
            <div class="section-title">Bersama ini kami mengajukan Permohonan Kerja Praktek sebagai berikut:</div>
            <table class="members-table">
                <thead>
                    <tr>
                        <th style="text-align: center;">No</th>
                        <th style="text-align: center;">Nama</th>
                        <th style="text-align: center;">NRP</th>
                        <th style="text-align: center;">Jumlah SKS<br>Tempuh</th>
                        <th style="text-align: center;">Tanda Tangan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($application->members as $index => $member)
                        <tr>
                            <td style="text-align: center;">{{ $index + 1 }}</td>

                            <td>{{ $member->student->nama_resmi ?? 'Unknown' }}</td>
                            <td style="text-align: center;">{{ $member->student->nrp ?? 'N/A' }}</td>
                            <td style="text-align: center;">{{ $member->student->sks_total ?? 0 }}</td>
                            <td>
                                @php
                                    $memberSignature = null;
                                @endphp
                                @if (isset($member->student) && isset($member->student->user) && $member->student->user->activeSignature)
                                    @php $memberSignature = $member->student->user->activeSignature; @endphp
                                @endif

                                @if ($memberSignature && ($memberSignature->signature_path ?? false))
                                    <img src="{{ public_path('storage/' . $memberSignature->signature_path) }}"
                                        class="signature-image" alt="Tanda Tangan">
                                @else
                                    <div style="height: 40px;"></div>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    <!-- Separator -->
    <div class="separator"></div>

    <!-- Content -->
    <div class="content-section">
        <table class="content-table">
            <tr>
                <td class="label">Topik :</td>
                <td>{{ $application->notes }}</td>
            </tr>
            <tr>
                <td class="label">Tujuan Perusahaan / Instansi *):</td>
                <td>{{ $application->institution_name }}</td>
            </tr>
            <tr>
                <td class="label">Alamat:</td>
                <td>{{ $application->institution_address }}</td>
            </tr>
            <tr>
                <td class="label">Bidang Usaha:</td>
                <td>{{ ucwords($application->business_field) }}</td>
            </tr>
            <tr>
                <td class="label">Penempatan:</td>
                <td>{{ $application->placement_division }} ({{ $application->division ?: '-' }})</td>
            </tr>
            <tr>
                <td class="label">Tanggal KP:</td>
                <td>{{ $application->planned_start_date->format('d F Y') }} -
                    {{ $application->planned_end_date->format('d F Y') }}</td>
            </tr>

        </table>
    </div>

    <!-- Separator -->
    <div class="separator"></div>

    <div class="document-title">
        <h2>Mengetahui / Menyetujui;</h2>
    </div>



    <!-- Footer with Signature -->
    <div class="footer">
        <div class="date-info">
            Surabaya, {{ \Carbon\Carbon::now('Asia/Jakarta')->translatedFormat('d F Y') }}<br>
            Dosen Pembimbing,
        </div>
        <div class="signature-section">
            @if ($signature && ($signature->signature_path ?? false))
                <img src="{{ public_path('storage/' . $signature->signature_path) }}" alt="Signature"
                    class="signature-image">
            @else
                <div style="height: 40px;"></div>
            @endif
            <div class="signature-line"></div>
            <div class="signature-name">{{ $approverName ?? $application->submittedBy->name }}</div>
            <div>NRP:
                {{ $approverNip ?? ($application->members->where('role', 'leader')->first()->student->nrp ?? 'N/A') }}
            </div>
        </div>
    </div>

    <div class="page-break"></div>

    <div class="content-section">
        <table class="content-table">
            <tr>
                <td colspan="2" class="label">*) Pejabat dari perusahaan / instansi surat pengantar KP ditujukan
                </td>

            </tr>
            <tr>

                <td colspan="2">
                    CATATAN :
                    <div style="margin-bottom:8px;">
                        <strong>* Tuliskan peserta yang mudah dihubungi :</strong>
                    </div>

                    <table style="width:100%; border-collapse:collapse;">
                        <tr>
                            <td style="width:18%; vertical-align:top; font-weight:bold;">Nama :</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td style="vertical-align:top; font-weight:bold;">Alamat :</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td style="vertical-align:top; font-weight:bold;">Telp :</td>
                            <td></td>
                        </tr>
                    </table>

                    <p style="margin-top:10px; margin-bottom:6px;">* Sebelum mengisi formulir ini mahasiswa diwajibkan
                        membaca Peraturan KP.<br>
                        (Buku Pedoman / Petunjuk KP)
                    </p>
                    <p style="margin:0;">* Menghubungi perusahaan terlebih dahulu untuk mendapatkan informasi dan alamat
                        tujuan yang jelas</p>
                </td>
            </tr>
        </table>
    </div>
</body>

</html>
