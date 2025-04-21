@extends('layout')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Detail Surat Perintah</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('sprin.index') }}">Surat Perintah</a></li>
                        <li class="breadcrumb-item active">Detail</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Informasi Surat Perintah</h3>
                            <div class="card-tools">
                                @if(in_array(auth()->user()->role, ['KEPALA BIDANG', 'KEPALA SUB BIDANG']))
                                <a href="{{ route('sprin.edit', $sprin->id) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                @endif
                                <a href="{{ route('sprin.index') }}" class="btn btn-sm btn-secondary">
                                    <i class="fas fa-arrow-left"></i> Kembali
                                </a>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <table class="table table-bordered">
                                        <tr>
                                            <th style="width: 30%">Nomor Surat</th>
                                            <td>{{ $sprin->nomor_surat }}</td>
                                        </tr>
                                        <tr>
                                            <th>Tanggal Surat</th>
                                            <td>{{ \Carbon\Carbon::parse($sprin->tanggal_surat)->format('d F Y') }}</td>
                                        </tr>
                                        <tr>
                                            <th>Perihal</th>
                                            <td>{{ $sprin->perihal }}</td>
                                        </tr>
                                        <tr>
                                            <th>Sumber Dana</th>
                                            <td>
                                                @if($sprin->sumber_dana === 'anggaran')
                                                <span class="badge badge-success">Anggaran</span>
                                                @else
                                                <span class="badge badge-secondary">Non-Anggaran</span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Dasar Surat</th>
                                            <td>{!! nl2br(e($sprin->dasar_surat)) !!}</td>
                                        </tr>
                                        <tr>
                                            <th>Status</th>
                                            <td>
                                                @if($sprin->status == 'belum_mulai')
                                                <span class="badge badge-secondary">Belum Mulai</span>
                                                @elseif($sprin->status == 'proses')
                                                <span class="badge badge-primary">Dalam Proses</span>
                                                @elseif($sprin->status == 'selesai')
                                                <span class="badge badge-success">Selesai</span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>File Surat</th>
                                            <td>
                                                @if($sprin->file_name)
                                                <div class="d-flex">
                                                    <a href="{{ route('sprin.download', $sprin) }}" class="btn btn-sm btn-info mr-2">
                                                        <i class="fas fa-file-download"></i> Download
                                                    </a>
                                                    <span class="align-self-center text-muted">
                                                        {{ $sprin->file_name }}
                                                    </span>
                                                </div>
                                                @elseif($sprin->file)
                                                <div class="d-flex">
                                                    <a href="{{ Storage::url($sprin->file) }}" target="_blank" class="btn btn-sm btn-info mr-2">
                                                        <i class="fas fa-file-download"></i> Lihat File
                                                    </a>
                                                    <span class="align-self-center text-muted">
                                                        {{ basename($sprin->file) }}
                                                    </span>
                                                </div>
                                                @else
                                                <span class="text-muted">Tidak ada file terlampir</span>
                                                @endif
                                            </td>
                                        </tr>
                                    </table>
                                </div>

                                <div class="col-md-6">
                                    <div class="card h-100">
                                        <div class="card-header bg-light">
                                            <h3 class="card-title">Personil Yang Ditugaskan</h3>
                                        </div>
                                        <div class="card-body p-0">
                                            <div class="table-responsive">
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th>Nama</th>
                                                            <th>Pangkat</th>
                                                            <th>NRP</th>
                                                            <th>Status</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @forelse($sprin->users as $user)
                                                        <tr>
                                                            <td>{{ $user->name }}</td>
                                                            <td>{{ $user->pangkat }}</td>
                                                            <td>{{ $user->nrp }}</td>
                                                            <td>
                                                                @php
                                                                $approved = $user->pivot->is_approved ?? false;
                                                                @endphp

                                                                @if($approved)
                                                                @if($sprin->status == 'selesai')
                                                                <span class="badge badge-success">Dilaksanakan</span>
                                                                @else
                                                                <span class="badge badge-primary">Siap Dilaksanakan</span>
                                                                @endif
                                                                @else
                                                                <span class="badge badge-warning">Menunggu Kesiapan</span>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                        @empty
                                                        <tr>
                                                            <td colspan="4" class="text-center">Tidak ada personil yang ditugaskan</td>
                                                        </tr>
                                                        @endforelse
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- File Preview Section -->
            @if($sprin->file_content || $sprin->file)
            <div class="row mt-3">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Preview File</h3>
                        </div>
                        <div class="card-body">
                            @if($sprin->file_content && (strpos($sprin->file_mime, 'pdf') !== false || strpos($sprin->file_name, '.pdf') !== false))
                            <div class="embed-responsive embed-responsive-16by9">
                                <iframe class="embed-responsive-item" src="data:application/pdf;base64,{{ $sprin->file_content }}" allowfullscreen></iframe>
                            </div>
                            @elseif($sprin->file && (str_ends_with(strtolower($sprin->file), '.pdf')))
                            <div class="embed-responsive embed-responsive-16by9">
                                <iframe class="embed-responsive-item" src="{{ Storage::url($sprin->file) }}" allowfullscreen></iframe>
                            </div>
                            @else
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle mr-2"></i>
                                Preview tidak tersedia untuk tipe file ini. Silakan download file untuk melihat isinya.
                                <div class="mt-3">
                                    @if($sprin->file_content)
                                    <a href="{{ route('sprin.download', $sprin) }}" class="btn btn-primary">
                                        <i class="fas fa-download"></i> Download {{ $sprin->file_name }}
                                    </a>
                                    @elseif($sprin->file)
                                    <a href="{{ Storage::url($sprin->file) }}" class="btn btn-primary" target="_blank">
                                        <i class="fas fa-download"></i> Download {{ basename($sprin->file) }}
                                    </a>
                                    @endif
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Action Buttons Section -->
            <div class="row mt-3">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    @if(in_array(auth()->user()->role, ['KEPALA SUB BIDANG', 'ANGGOTA']) && $sprin->status == 'belum_mulai' && $sprin->isFullyApproved())
                                    <form action="{{ route('sprin.updateStatus', $sprin->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-play"></i> Mulai Tugas
                                        </button>
                                    </form>
                                    @endif
                                </div>

                                @if(in_array(auth()->user()->role, ['KEPALA BIDANG', 'KEPALA SUB BIDANG']))
                                <form action="{{ route('sprin.destroy', $sprin->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus surat perintah ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">
                                        <i class="fas fa-trash"></i> Hapus Surat Perintah
                                    </button>
                                </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection