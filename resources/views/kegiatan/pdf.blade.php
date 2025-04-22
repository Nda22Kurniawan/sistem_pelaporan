<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Laporan Kegiatan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.5;
            font-size: 12px;
            margin: 2cm;
        }

        .logo-container {
            text-align: center;
            margin-bottom: 15px;
        }

        .logo {
            width: 100px;
            height: auto;
        }

        .header-text {
            text-align: center;
            margin-bottom: 30px;
        }

        .header-text h1 {
            font-size: 14px;
            font-weight: bold;
            margin: 0;
            padding: 2px 0;
            text-transform: uppercase;
            line-height: 1.3;
        }

        .underline {
            text-decoration: underline;
        }

        .header-title {
            text-align: center;
            margin: 15px 0 20px 0;
        }

        .header-title h2 {
            font-size: 14px;
            font-weight: bold;
            margin: 5px 0;
            line-height: 1.3;
        }

        .section {
            margin-top: 15px;
            margin-bottom: 15px;
        }

        .numbered-section {
            margin-top: 20px;
        }

        .numbered-section .title {
            font-weight: bold;
            text-transform: uppercase;
        }

        .sub-section {
            margin-top: 10px;
            margin-left: 20px;
        }

        .sub-section-letter {
            margin-left: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        .image-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
            margin-top: 15px;
        }

        .image-container {
            text-align: center;
        }

        .image-container img {
            max-width: 100%;
            height: auto;
            border: 1px solid #ddd;
        }

        .footer {
            margin-top: 30px;
            text-align: right;
        }

        .signature-container {
            display: flex;
            justify-content: flex-end;
            margin-top: 40px;
            text-align: center;
        }

        .signature-box {
            width: 200px;
        }

        .signature-title {
            font-weight: bold;
            margin-bottom: 80px;
        }

        .signature-name {
            font-weight: bold;
            text-transform: uppercase;
        }

        .signature-nip {
            margin-top: 5px;
        }

        .page-number {
            text-align: center;
            margin-top: 20px;
            font-size: 11px;
        }

        .date-section {
            margin-bottom: 15px;
        }

        .date-section p strong {
            font-weight: bold;
            color: #333;
        }

        .date-content {
            margin-left: 20px;
            margin-top: 5px;
            margin-bottom: 5px;
        }
    </style>
</head>

<body>
    <div class="header-text">
        <h1>KEPOLISIAN NEGARA REPUBLIK INDONESIA</h1>
        <h1>DAERAH JAWA TENGAH</h1>
        <h1 class="underline">BIDANG TEKNOLOGI INFORMASI DAN KOMUNIKASI</h1>
    </div>

    <div class="logo-container">
        <img src="data:image/png;base64,{{ $logo_polri ?? '' }}" alt="Logo Polri" class="logo">
    </div>

    <div class="header-title">
        <h2>LAPORAN KEGIATAN</h2>
        <h2>{{ strtoupper($kegiatan->nama_kegiatan) }}</h2>
    </div>

    <div class="numbered-section">
        <div class="title">I. PENDAHULUAN</div>
        <div class="sub-section">
            <p>1. Dasar :</p>
            <div class="sub-section-letter">
                @if($kegiatan->suratPerintah && $kegiatan->suratPerintah->dasar_surat)
                @php
                $dasar_array = explode("\n", $kegiatan->suratPerintah->dasar_surat);
                $letter = 'a';
                @endphp

                @foreach($dasar_array as $dasar)
                @if(trim($dasar) != '')
                <p>{{ $letter }}. {{ $dasar }}</p>
                @php $letter = chr(ord($letter) + 1); @endphp
                @endif
                @endforeach
                @else
                <p>a. {{ $kegiatan->suratPerintah->nomor_surat ?? 'Tidak ada dasar surat' }}</p>
                <p>b. Surat Perintah Kabid TIK Polda Jateng Nomor: Sprin/{{ $kegiatan->nomor_sprin ?? '000' }}/{{ \Carbon\Carbon::parse($kegiatan->tanggal_mulai)->format('m') }}/REN.2.3./{{ \Carbon\Carbon::parse($kegiatan->tanggal_mulai)->format('Y') }}.</p>
                @endif
            </div>
        </div>
    </div>

    <div class="numbered-section">
        <div class="title">II. TUGAS YANG DILAKSANAKAN</div>
        <div class="sub-section">
            <p>1. {{ $kegiatan->deskripsi ?? 'Mengikuti Kegiatan' }} bertempat di {{ $kegiatan->lokasi ?? '-' }} dengan personil sebagai berikut :</p>

            <p style="margin-left: 20px;">
                <strong>Sumber Dana:</strong>
                @if($kegiatan->suratPerintah && $kegiatan->suratPerintah->sumber_dana === 'anggaran')
                Anggaran
                @elseif($kegiatan->suratPerintah && $kegiatan->suratPerintah->sumber_dana === 'non_anggaran')
                Non-Anggaran
                @else
                Tidak Ditentukan
                @endif
            </p>

            @forelse($kegiatan->users as $index => $user)
            <div class="sub-section-letter">
                <p>{{ chr(97 + $index) }}. {{ $user->name }} {{ $user->pangkat }}</p>
            </div>
            @empty
            <div class="sub-section-letter">
                <p>Tidak ada personil</p>
            </div>
            @endforelse
        </div>
    </div>

    <div class="numbered-section">
        <div class="title">III. HASIL YANG DICAPAI</div>
        <div class="sub-section">
            @if($kegiatan->hasil_kegiatan)
            @php
            $hasil_text = $kegiatan->hasil_kegiatan;
            $pattern = '/([A-Za-z]+, \d+ [A-Za-z]+ \d{4}):/';
            $parts = preg_split($pattern, $hasil_text, -1, PREG_SPLIT_DELIM_CAPTURE);

            $counter = 1;
            $current_date = null;
            @endphp

            @for($i = 1; $i < count($parts); $i +=2)
                @php
                $date=$parts[$i];
                $content=isset($parts[$i+1]) ? trim($parts[$i+1]) : '' ;
                @endphp

                <div class="date-section">
                <p><strong>{{ $date }}</strong></p>
                @if(!empty($content))
                @php
                $content_lines = explode("\n", $content);
                @endphp

                @foreach($content_lines as $line)
                @if(trim($line) != '')
                <p class="date-content">{{ $counter }}. {{ trim($line) }}</p>
                @php $counter++; @endphp
                @endif
                @endforeach
                @endif
        </div>
        @endfor

        @if(count($parts) <= 1)
            @php
            $hasil_array=explode("\n", $kegiatan->hasil_kegiatan);
            @endphp

            @foreach($hasil_array as $hasil)
            @if(trim($hasil) != '')
            <p>{{ $counter }}. {{ $hasil }}</p>
            @php $counter++; @endphp
            @endif
            @endforeach
            @endif
            @else
            <p>1. Tidak ada hasil kegiatan</p>
            @endif
    </div>
    </div>

    <div class="numbered-section">
        <div class="title">IV. KESIMPULAN</div>
        <div class="sub-section">
            <p>{{ $kegiatan->kesimpulan ?? 'Kegiatan dapat berjalan dengan lancar dan tertib tanpa ada hambatan suatu apapun.' }}</p>
        </div>
    </div>

    <div class="numbered-section">
        <div class="title">V. PENUTUP</div>
        <div class="sub-section">
            <p>Demikian laporan hasil pelaksanaan {{ $kegiatan->nama_kegiatan }} dibuat untuk menjadi periksa.</p>
        </div>
    </div>

    <div class="signature-container">
        <div class="signature-box">
            <p>{{ $kegiatan->lokasi ?? 'Semarang' }}, {{ \Carbon\Carbon::parse($kegiatan->tanggal_selesai)->format('F Y') }}</p>
            <div class="signature-title">PENANGGUNGJAWAB PELAKSANA<br>KASUBBAGRENMIN</div>
            <div class="signature-name">{{ $kegiatan->penanggung_jawab ?? 'DJOKO SUSANTO, S.Kom.' }}</div>
            <div class="signature-nip">{{ $kegiatan->nip_penanggung_jawab ?? 'PENATA I NIP 197205111998031004' }}</div>
        </div>
    </div>

    @if(count($kegiatan->image) > 0)
    <div class="page-number">{{ isset($page_number) ? $page_number : '1' }}</div>

    <div style="page-break-before: always;">
        <div class="header-text">
            <h1>KEPOLISIAN NEGARA REPUBLIK INDONESIA</h1>
            <h1>DAERAH JAWA TENGAH</h1>
            <h1 class="underline">BIDANG TEKNOLOGI INFORMASI DAN KOMUNIKASI</h1>
        </div>

        <div class="logo-container">
            <img src="data:image/jpeg;base64,{{ $logo_polri ?? '' }}" alt="Logo Polri" class="logo">
        </div>

        <div class="header-title">
            <h2>DOKUMENTASI PELAKSANAAN KEGIATAN</h2>
            <h2>{{ strtoupper($kegiatan->nama_kegiatan) }}</h2>
        </div>
    </div>

    <div class="image-grid">
        @foreach($kegiatan->image as $index => $image)
        <div class="image-container">
            <img src="data:image/jpeg;base64,{{ $image }}" alt="Dokumentasi {{ $index + 1 }}">
        </div>
        @endforeach
    </div>

    <div class="page-number">{{ isset($page_number) ? $page_number + 1 : '2' }}</div>
    @endif
</body>

</html>