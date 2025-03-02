@extends('layout')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Daftar Surat Perintah</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Surat Perintah</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Data Surat Perintah</h3>
                    @if(in_array(auth()->user()->role, ['KEPALA BIDANG', 'KEPALA SUB BIDANG']))
                    <div class="card-tools">
                        <a href="{{ route('sprin.create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Buat Baru
                        </a>
                    </div>
                    @endif
                </div>
                <div class="card-body">
                    <table id="sprinTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nomor Sprin</th>
                                <th>Tanggal</th>
                                <th>Perihal</th>
                                <th>Personil</th>
                                <th>Status</th>
                                <th>File</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($sprins as $sprin)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $sprin->nomor_surat }}</td>
                                <td>{{ \Carbon\Carbon::parse($sprin->tanggal_surat)->format('d/m/Y') }}</td>
                                <td>{{ $sprin->perihal }}</td>
                                <td>
                                    @if($sprin->penerima->count() > 0)
                                    @foreach($sprin->penerima as $penerima)
                                    <span class="badge badge-info">
                                        {{ $penerima->pangkat }} - {{ $penerima->name }}
                                        @if($penerima->nrp)
                                        ({{ $penerima->nrp }})
                                        @endif
                                    </span><br>
                                    @endforeach
                                    @else
                                    <span class="badge badge-secondary">Tidak ada personil</span>
                                    @endif
                                </td>
                                <td>
                                    @if($sprin->status === 'selesai')
                                    <span class="badge badge-success">Selesai</span>
                                    @elseif($sprin->status === 'proses')
                                    <span class="badge badge-warning">Proses</span>
                                    @else
                                    <span class="badge badge-danger">Belum Mulai</span>
                                    @if(!$sprin->isFullyApproved())
                                    <br>
                                    <small class="text-danger">Menunggu persetujuan dari anggota terkait.</small>
                                    @endif
                                    @endif
                                </td>
                                <td>
                                    @if($sprin->file)
                                    <a href="{{ Storage::url($sprin->file) }}" target="_blank" class="btn btn-sm btn-info">
                                        <i class="fas fa-file-download"></i> Unduh
                                    </a>
                                    @else
                                    <span class="badge badge-secondary">Tidak ada file</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('sprin.show', $sprin->id) }}" class="btn btn-info btn-sm" title="Lihat Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @if(in_array(auth()->user()->role, ['KEPALA BIDANG', 'KEPALA SUB BIDANG']))
                                        <a href="{{ route('sprin.edit', $sprin->id) }}" class="btn btn-warning btn-sm" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('sprin.destroy', $sprin->id) }}" method="POST"
                                            class="d-inline" onsubmit="return confirm('Yakin ingin menghapus surat perintah ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                        @endif
                                        @if(auth()->user()->role === 'ANGGOTA')
                                        @php
                                        $userApproval = $sprin->penerima->where('id', auth()->id())->first()->pivot->is_approved ?? false;
                                        @endphp

                                        @if(!$userApproval)
                                        <form action="{{ route('sprin.approve', $sprin->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-success btn-sm ml-1" title="Setujui Surat">
                                                <i class="fas fa-check"></i> Setujui
                                            </button>
                                        </form>
                                        @else
                                        <span class="badge badge-success">Sudah Disetujui</span>
                                        @endif
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
    $(document).ready(function() {
        $('#sprinTable').DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        }).buttons().container().appendTo('#sprinTable_wrapper .col-md-6:eq(0)');
    });
</script>
@endsection