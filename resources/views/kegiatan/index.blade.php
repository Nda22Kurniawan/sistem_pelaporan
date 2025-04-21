@extends('layout')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Laporan Kegiatan</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Laporan Kegiatan</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                    @endif

                    @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                    @endif

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Daftar Laporan Kegiatan</h3>
                            <div class="card-tools">
                                <a href="{{ route('kegiatan.create') }}" class="btn btn-primary btn-sm">
                                    <i class="fas fa-plus"></i> Tambah Laporan
                                </a>
                            </div>
                        </div>
                        <div class="card-body table-responsive">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nomor Surat</th>
                                        <th>Nama Kegiatan</th>
                                        <th>Tanggal</th>
                                        <th>Lokasi</th>
                                        <th>Sumber Dana</th>
                                        <th>Penanggung Jawab</th>
                                        <th>Status</th>
                                        @if(auth()->user()->role !== 'KEPALA BIDANG')
                                        <th>Aksi</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($kegiatans as $index => $kegiatan)
                                    <tr>
                                        <td>{{ $kegiatans->firstItem() + $index }}</td>
                                        <td>{{ $kegiatan->suratPerintah->nomor_surat }}</td>
                                        <td>{{ $kegiatan->nama_kegiatan }}</td>
                                        <td>
                                            {{ \Carbon\Carbon::parse($kegiatan->tanggal_mulai)->format('d M Y') }}
                                            -
                                            {{ \Carbon\Carbon::parse($kegiatan->tanggal_selesai)->format('d M Y') }}
                                        </td>
                                        <td>{{ $kegiatan->lokasi }}</td>
                                        <td>
                                            @if($kegiatan->suratPerintah && $kegiatan->suratPerintah->sumber_dana === 'anggaran')
                                            <span class="badge badge-success">Anggaran</span>
                                            @else
                                            <span class="badge badge-secondary">Non-Anggaran</span>
                                            @endif
                                        </td>
                                        <td>
                                            @php
                                            $responsiblePersons = explode(', ', $kegiatan->penanggung_jawab);
                                            $users = \App\Models\User::whereIn('name', $responsiblePersons)->get();
                                            @endphp
                                            @if($users->count() > 0)
                                            @foreach($users as $user)
                                            <span class="badge badge-info">
                                                {{ $user->pangkat }} - {{ $user->name }} ({{ $user->nrp }})
                                            </span><br>
                                            @endforeach
                                            @else
                                            <span class="badge badge-secondary">Tidak ada personil</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if(auth()->user()->role === 'KEPALA BIDANG' && $kegiatan->status === 'Review')
                                            <div class="btn-group">
                                                <form action="{{ route('kegiatan.update-status', $kegiatan->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="status" value="Diterima">
                                                    <button type="submit" class="btn btn-sm status-btn">
                                                        <i class="fas fa-check text-success"></i>
                                                    </button>
                                                </form>
                                                <form action="{{ route('kegiatan.update-status', $kegiatan->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="status" value="Ditolak">
                                                    <button type="submit" class="btn btn-sm status-btn">
                                                        <i class="fas fa-times text-danger"></i>
                                                    </button>
                                                </form>
                                            </div>
                                            @elseif($kegiatan->status === 'Diterima')
                                            <span class="badge badge-success">Diterima</span>
                                            @elseif($kegiatan->status === 'Ditolak')
                                            <span class="badge badge-danger">Ditolak</span>
                                            @elseif($kegiatan->status === 'Review' && auth()->user()->role !== 'KEPALA BIDANG')
                                            <span class="badge badge-warning">Review</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="{{ route('kegiatan.show', $kegiatan->id) }}" class="btn btn-info btn-sm">
                                                    <i class="fas fa-eye"></i>
                                                </a>

                                                @php
                                                $isAnggota = auth()->user()->role === 'ANGGOTA';
                                                $status = $kegiatan->status;
                                                @endphp

                                                @if(($isAnggota && in_array($status, ['Review', 'Ditolak'])) || !$isAnggota)
                                                <a href="{{ route('kegiatan.edit', $kegiatan->id) }}" class="btn btn-warning btn-sm">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('kegiatan.destroy', $kegiatan->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus laporan ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm delete-btn">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="7" class="text-center">Tidak ada laporan kegiatan</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer">
                            {{ $kegiatans->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // Konfirmasi hapus
        $('.delete-btn').on('click', function(e) {
            e.preventDefault();
            var form = $(this).closest('form');

            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Anda tidak dapat mengembalikan data yang dihapus!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });

        // Konfirmasi update status (Diterima/Ditolak)
        $('.status-btn').on('click', function(e) { // Ganti selektor dengan .status-btn saja
            e.preventDefault();
            var form = $(this).closest('form');
            var status = form.find('input[name="status"]').val();
            var actionText = status === 'Diterima' ? 'menyetujui' : 'menolak';

            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: `Anda akan ${actionText} laporan kegiatan ini!`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, lanjutkan!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>
@endpush