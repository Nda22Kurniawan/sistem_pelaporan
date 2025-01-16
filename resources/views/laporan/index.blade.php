@extends('layout')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
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

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Daftar Laporan Kegiatan</h3>
                            <div class="card-tools">
                                <a href="{{ route('laporan.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus"></i> Tambah Laporan
                                </a>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Nama Kegiatan</th>
                                        <th>Lokasi</th>
                                        <th>Tanggal</th>
                                        <th>Penanggung Jawab</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($kegiatans as $kegiatan)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $kegiatan->nama_kegiatan }}</td>
                                        <td>{{ $kegiatan->lokasi }}</td>
                                        <td>
                                            {{ \Carbon\Carbon::parse($kegiatan->tanggal_mulai)->format('d/m/Y') }} - 
                                            {{ \Carbon\Carbon::parse($kegiatan->tanggal_selesai)->format('d/m/Y') }}
                                        </td>
                                        <td>{{ $kegiatan->penanggung_jawab }}</td>
                                        <td>
                                            @php
                                                $today = \Carbon\Carbon::now();
                                                $start = \Carbon\Carbon::parse($kegiatan->tanggal_mulai);
                                                $end = \Carbon\Carbon::parse($kegiatan->tanggal_selesai);
                                            @endphp
                                            
                                            @if($today->lt($start))
                                                <span class="badge badge-info">Akan Datang</span>
                                            @elseif($today->gt($end))
                                                <span class="badge badge-success">Selesai</span>
                                            @else
                                                <span class="badge badge-warning">Berlangsung</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('laporan.show', $kegiatan->id) }}" class="btn btn-sm btn-info">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('laporan.edit', $kegiatan->id) }}" class="btn btn-sm btn-warning">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('laporan.destroy', $kegiatan->id) }}" method="POST" 
                                                  class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus laporan ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
@endsection