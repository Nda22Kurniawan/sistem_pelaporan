<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Laporan Kegiatan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.5;
            font-size: 12px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h1 {
            font-size: 16px;
            margin-bottom: 5px;
        }
        .info-item {
            margin-bottom: 10px;
        }
        .info-label {
            font-weight: bold;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        .section {
            margin-top: 20px;
            margin-bottom: 15px;
        }
        .section-title {
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .section-content {
            padding: 10px;
            border: 1px solid #ddd;
            background-color: #f9f9f9;
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
        @page {
            margin: 2cm;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>LAPORAN KEGIATAN</h1>
        <div>{{ $kegiatan->nama_kegiatan }}</div>
    </div>
    
    <div class="info-item">
        <span class="info-label">Nomor Surat Perintah:</span> 
        {{ $kegiatan->suratPerintah->nomor_surat }}
    </div>
    
    <div class="info-item">
        <span class="info-label">Tanggal Pelaksanaan:</span> 
        {{ \Carbon\Carbon::parse($kegiatan->tanggal_mulai)->format('d M Y') }} - 
        {{ \Carbon\Carbon::parse($kegiatan->tanggal_selesai)->format('d M Y') }}
    </div>
    
    <div class="info-item">
        <span class="info-label">Lokasi:</span> 
        {{ $kegiatan->lokasi }}
    </div>
    
    <div class="section">
        <div class="section-title">Deskripsi</div>
        <div class="section-content">
            {{ $kegiatan->deskripsi ?? 'Tidak ada deskripsi' }}
        </div>
    </div>
    
    <div class="section">
        <div class="section-title">Personil</div>
        <table>
            <thead>
                <tr>
                    <th style="width: 10%">No</th>
                    <th style="width: 40%">Nama</th>
                    <th style="width: 25%">NRP</th>
                    <th style="width: 25%">Pangkat</th>
                </tr>
            </thead>
            <tbody>
                @forelse($kegiatan->users as $index => $user)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->nrp }}</td>
                    <td>{{ $user->pangkat }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" style="text-align: center">Tidak ada personil</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="section">
        <div class="section-title">Hasil Kegiatan</div>
        <div class="section-content">
            {{ $kegiatan->hasil_kegiatan ?? 'Tidak ada hasil kegiatan' }}
        </div>
    </div>
    
    <div class="section">
        <div class="section-title">Kesimpulan</div>
        <div class="section-content">
            {{ $kegiatan->kesimpulan ?? 'Tidak ada kesimpulan' }}
        </div>
    </div>
    
    @if(count($kegiatan->image) > 0)
    <div class="section">
        <div class="section-title">Dokumentasi Kegiatan</div>
        <div class="image-grid">
            @foreach($kegiatan->image as $index => $image)
            <div class="image-container">
                <img src="data:image/jpeg;base64,{{ $image }}" alt="Dokumentasi {{ $index + 1 }}">
                <div>{{ \Carbon\Carbon::parse($kegiatan->created_at)->format('d M Y') }}</div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
    
    <div class="footer">
        <p>Dibuat pada: {{ \Carbon\Carbon::parse($kegiatan->created_at)->format('d M Y H:i') }}</p>
        @if($kegiatan->updated_at != $kegiatan->created_at)
        <p>Diperbarui pada: {{ \Carbon\Carbon::parse($kegiatan->updated_at)->format('d M Y H:i') }}</p>
        @endif
    </div>
</body>
</html>