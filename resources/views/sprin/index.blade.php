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
                    <div class="card-tools">
                        <a href="{{ route('sprin.create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Buat Baru
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <table id="sprinTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nomor Sprin</th>
                                <th>Tanggal</th>
                                <th>Kegiatan</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($sprins as $sprin)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $sprin->nomor }}</td>
                                <td>{{ \Carbon\Carbon::parse($sprin->tanggal)->format('d/m/Y') }}</td>
                                <td>{{ $sprin->kegiatan }}</td>
                                <td>
                                    @if($sprin->status === 'selesai')
                                        <span class="badge badge-success">Selesai</span>
                                    @elseif($sprin->status === 'proses')
                                        <span class="badge badge-warning">Proses</span>
                                    @else
                                        <span class="badge badge-danger">Belum Mulai</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('sprin.show', $sprin->id) }}" class="btn btn-info btn-sm">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('sprin.edit', $sprin->id) }}" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('sprin.destroy', $sprin->id) }}" method="POST" 
                                          class="d-inline" onsubmit="return confirm('Yakin ingin menghapus?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
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
@endsection

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
