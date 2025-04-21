@extends('layout')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Detail Laporan Kegiatan</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('kegiatan.index') }}">Laporan Kegiatan</a></li>
                        <li class="breadcrumb-item active">Detail Laporan</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-tools d-flex justify-content-end align-items-center gap-2 flex-wrap pe-3 pt-2">
                            @php
                            $isAnggota = auth()->user()->role === 'ANGGOTA';
                            $status = $kegiatan->status;
                            @endphp

                            @if(($isAnggota && in_array($status, ['Review', 'Ditolak'])) || !$isAnggota)
                            <a href="{{ route('kegiatan.edit', $kegiatan->id) }}" class="btn btn-sm btn-primary">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            @elseif($isAnggota && $status === 'Diterima')
                            <span class="text-muted small d-inline-flex align-items-center pr-2">
                                <i class="fas fa-lock mr-1 text-warning"></i> Laporan sudah diterima. Tidak dapat diedit.
                            </span>
                            @endif

                            <a href="{{ route('kegiatan.preview-pdf', $kegiatan->id) }}" class="btn btn-sm btn-danger">
                                <i class="fas fa-file-pdf"></i> Preview PDF
                            </a>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="info-box bg-light">
                                        <div class="info-box-content">
                                            <span class="info-box-text text-muted">Nomor Surat Perintah</span>
                                            <span class="info-box-number">{{ $kegiatan->suratPerintah->nomor_surat }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info-box bg-light">
                                        <div class="info-box-content">
                                            <span class="info-box-text text-muted">Nama Kegiatan</span>
                                            <span class="info-box-number">{{ $kegiatan->nama_kegiatan }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <div class="info-box bg-light">
                                        <div class="info-box-content">
                                            <span class="info-box-text text-muted">Tanggal Pelaksanaan</span>
                                            <span class="info-box-number">
                                                {{ \Carbon\Carbon::parse($kegiatan->tanggal_mulai)->format('d M Y') }} -
                                                {{ \Carbon\Carbon::parse($kegiatan->tanggal_selesai)->format('d M Y') }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info-box bg-light">
                                        <div class="info-box-content">
                                            <span class="info-box-text text-muted">Lokasi</span>
                                            <span class="info-box-number">{{ $kegiatan->lokasi }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <h5 class="mt-4 mb-3">Deskripsi</h5>
                            <div class="callout callout-info">
                                <p>{{ $kegiatan->deskripsi ?? 'Tidak ada deskripsi' }}</p>
                            </div>

                            <h5 class="mt-4 mb-3">Sumber Dana</h5>
                            <div class="callout callout-secondary">
                                <p>
                                    {{ $kegiatan->suratPerintah->sumber_dana === 'anggaran' ? 'Anggaran' : 'Non-Anggaran' }}
                                </p>
                            </div>

                            <h5 class="mt-4 mb-3">Personil</h5>
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>NRP</th>
                                            <th>Pangkat</th>
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
                                            <td colspan="4" class="text-center">Tidak ada personil</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <h5 class="mt-4 mb-3">Hasil Kegiatan</h5>
                            <div class="callout callout-success">
                                @if($kegiatan->hasil_kegiatan)
                                {!! nl2br(e($kegiatan->hasil_kegiatan)) !!}
                                @else
                                <p>Tidak ada hasil kegiatan</p>
                                @endif
                            </div>

                            <h5 class="mt-4 mb-3">Kesimpulan</h5>
                            <div class="callout callout-warning">
                                <p>{{ $kegiatan->kesimpulan ?? 'Tidak ada kesimpulan' }}</p>
                            </div>

                            @php
                            $imagesList = is_array($kegiatan->image) ? $kegiatan->image : json_decode($kegiatan->image ?? '[]');
                            @endphp

                            @if(count($imagesList) > 0)
                            <h5 class="mt-4 mb-3">Dokumentasi Kegiatan</h5>
                            <div class="row">
                                @foreach($imagesList as $image)
                                <div class="col-md-3 col-sm-4 col-6 mb-3">
                                    <div class="card h-100 shadow-sm">
                                        <a href="data:image/jpeg;base64,{{ $image }}" data-toggle="lightbox" data-title="Dokumentasi Kegiatan" data-gallery="gallery">
                                            <img src="data:image/jpeg;base64,{{ $image }}" class="card-img-top" style="height: 150px; object-fit: cover;">
                                        </a>
                                        <div class="card-body p-2 text-center">
                                            <small class="text-muted">{{ \Carbon\Carbon::parse($kegiatan->created_at)->format('d M Y') }}</small>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            @endif
                        </div>
                        <div class="card-footer">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <small class="text-muted">Dibuat: {{ \Carbon\Carbon::parse($kegiatan->created_at)->format('d M Y H:i') }}</small>
                                    @if($kegiatan->updated_at != $kegiatan->created_at)
                                    <br>
                                    <small class="text-muted">Diperbarui: {{ \Carbon\Carbon::parse($kegiatan->updated_at)->format('d M Y H:i') }}</small>
                                    @endif
                                </div>
                                <a href="{{ route('kegiatan.index') }}" class="btn btn-default">Kembali</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@push('styles')
<link rel="stylesheet" href="/assets/plugins/ekko-lightbox/ekko-lightbox.css">
@endpush

@push('scripts')
<script src="/assets/plugins/ekko-lightbox/ekko-lightbox.min.js"></script>
<script>
    $(document).ready(function() {
        $(document).on('click', '[data-toggle="lightbox"]', function(event) {
            event.preventDefault();
            $(this).ekkoLightbox({
                alwaysShowClose: true
            });
        });
    });
</script>
@endpush

@endsection