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

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 20px;
        }

        .logo-section {
            border: 1px solid #000;
            padding: 5px 1rem;
            width: 200px;
            font-weight: bold;
        }

        .logo {
            width: 80px;
            height: 80px;
            background-color: #f0f0f0;
            border: 1px solid #ccc;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 10px;
            color: #666;
        }

        .institution-info {
            flex: 2;
            text-align: center;
        }

        .institution-name {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .institution-details {
            font-size: 11px;
            line-height: 1.4;
        }

        .contact-info {
            flex: 1;
            text-align: right;
        }

        .contact-info div {
            margin-bottom: 3px;
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
            text-align: center;
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
            margin: 30px 0;
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
    <!-- Header -->
    {{-- <div class="header">
        <div class="logo-section">
            <div class="logo">LOGO</div>
        </div>

        <div class="institution-info">
            <div class="institution-name">INSTITUT TEKNOLOGI SEPULUH NOPEMBER</div>
            <div class="institution-details">
                Fakultas Teknologi Elektro dan Informatika Cerdas<br>
                Departemen Teknik Informatika<br>
                Jl. Raya ITS, Keputih, Sukolilo, Surabaya 60111
            </div>
        </div>

        <div class="contact-info">
            <div><strong>Telp:</strong> (031) 5994251</div>
            <div><strong>Fax:</strong> (031) 5966205</div>
            <div><strong>Email:</strong> informatics@its.ac.id</div>
        </div>
    </div> --}}
    <div class="logo-section ">
        <p>DEPARTEMEN TEKNIK ELEKTRO<br>
            FTEIC - ITS</p>
    </div>

    <!-- Document Title -->
    <div class="document-title">
        <h1>FORMULIR PENGAJUAN KERJA PRAKTEK</h1>
    </div>



    <!-- Members Section -->
    @if ($application->members->count() > 0)
        <div class="members-section">
            <div class="section-title">Bersama ini kami mengajukan Permohonan Kerja Praktek sebagai berikut:</div>
            <table class="members-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>NRP</th>
                        <th>Jumlah SKS Tempuh</th>
                        <th>Tanda Tangan</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($application->members as $index => $member)
                        <tr>
                            <td>{{ $index + 1 }}</td>

                            <td>{{ $member->student->nama_resmi ?? 'Unknown' }}</td>
                            <td>{{ $member->student->nrp ?? 'N/A' }}</td>
                            <td>{{ $member->student->jumlah_sks ?? 0 }}</td>
                            <td></td>
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
            {{-- <tr>
                <td class="label">Nomor Proposal:</td>
                <td>APP-{{ $application->id }}</td>
            </tr> --}}
            {{-- <tr>
                <td class="label">Nama Mahasiswa:</td>
                <td>{{ $application->submittedBy->name }}</td>
            </tr>
            <tr>
                <td class="label">NRP:</td>
                <td>{{ $application->members->where('role', 'leader')->first()->student->nrp ?? 'N/A' }}</td>
            </tr> --}}
            {{-- <tr>
                <td class="label">Program Studi:</td>
                <td>Teknik Informatika</td>
            </tr> --}}
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
                <td>{{ $application->placement_division }}</td>
            </tr>
            <tr>
                <td class="label">Divisi:</td>
                <td>{{ $application->division ?: '-' }}</td>
            </tr>
            <tr>
                <td class="label">Tanggal KP:</td>
                <td>{{ $application->planned_start_date->format('d F Y') }} -
                    {{ $application->planned_end_date->format('d F Y') }}</td>
            </tr>
            <tr>
                <td class="label">Durasi KP:</td>
                <td>{{ $application->planned_start_date->diffInMonths($application->planned_end_date) }} bulan</td>
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
        <div class="signature-section">
            @if ($signature && $signature->signature_path)
                <img src="{{ public_path('storage/' . $signature->signature_path) }}" alt="Signature"
                    class="signature-image">
            @else
                <div style="height: 40px;"></div>
            @endif
            <div class="signature-line"></div>
            <div class="signature-name">{{ $application->submittedBy->name }}</div>
            <div>NRP: {{ $application->members->where('role', 'leader')->first()->student->nrp ?? 'N/A' }}</div>
        </div>
    </div>
</body>

</html>
