@extends('layout')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Dashboard</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Info boxes -->
            <div class="row">
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-info elevation-1"><i class="fas fa-users"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Total Personil</span>
                            <span class="info-box-number">{{ $totalUsers }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-success elevation-1"><i class="fas fa-user-check"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Personil Aktif</span>
                            <span class="info-box-number">{{ $activeUsers }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-file-alt"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Surat Perintah</span>
                            <span class="info-box-number">{{ $totalSprin ?? 0 }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-chart-bar"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Laporan Kegiatan</span>
                            <span class="info-box-number">{{ $totalLaporan ?? 0 }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main row -->
            <div class="row">
                <!-- Left col -->
                <div class="col-md-8">
                    <!-- TABLE: LATEST ORDERS -->
                    <div class="card">
                        <div class="card-header border-transparent">
                            <h3 class="card-title">Surat Perintah Terbaru</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table m-0">
                                    <thead>
                                        <tr>
                                            <th>No Sprin</th>
                                            <th>Tanggal</th>
                                            <th>Kegiatan</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($latestSprin->take(5) ?? [] as $sprin)
                                        <tr>
                                            <td>{{ $sprin->nomor_surat }}</td>
                                            <td>{{ \Carbon\Carbon::parse($sprin->tanggal_surat)->format('d/m/Y') }}</td>
                                            <td>{{ $sprin->perihal }}</td>
                                            <td>
                                                @if($sprin->status === 'selesai')
                                                <span class="badge badge-success">Selesai</span>
                                                @elseif($sprin->status === 'proses')
                                                <span class="badge badge-warning">Proses</span>
                                                @else
                                                <span class="badge badge-danger">Belum Mulai</span>
                                                @endif
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="4" class="text-center">Tidak ada data surat perintah</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer clearfix">
                            <a href="{{ route('sprin.create') }}" class="btn btn-sm btn-primary float-left">Buat Baru</a>
                            <a href="{{ route('sprin.index') }}" class="btn btn-sm btn-secondary float-right">Lihat Semua</a>
                        </div>
                    </div>
                </div>

                <!-- Right col -->
                <div class="col-md-4">
                    <!-- PERSONIL LIST -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Personil Terbaru</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <ul class="users-list clearfix">
                                @forelse($latestUsers->take(3) ?? [] as $user)
                                <li>
                                    <img src="{{ $user->foto_profile ? asset($user->foto_profile) : asset('assets/dist/img/user-default.jpg') }}"
                                        alt="User Image" style="width: 80px; height: 80px; object-fit: cover;">
                                    <a class="users-list-name" href="#">{{ $user->name }}</a>
                                    <span class="users-list-date">{{ $user->pangkat }}</span>
                                </li>
                                @empty
                                <li class="text-center p-3">Tidak ada data personil</li>
                                @endforelse
                            </ul>
                        </div>
                        <div class="card-footer text-center">
                            <a href="{{ route('users.index') }}">Lihat Semua Personil</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

<script>
    $(document).ready(function() {
        // Tambahkan script khusus untuk dashboard jika diperlukan
    });
</script>