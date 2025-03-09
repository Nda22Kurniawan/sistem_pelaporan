@extends('layout')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Detail User</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Users</a></li>
                        <li class="breadcrumb-item active">Detail User</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-4">
                    <!-- Profile Image -->
                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile">
                            <div class="text-center">
                                @if($user->foto_profile)
                                    <img class="profile-user-img img-fluid img-circle"
                                        src="{{ route('users.photo', $user->id) }}"
                                        alt="User profile picture">
                                @else
                                    <img class="profile-user-img img-fluid img-circle"
                                        src="/assets/dist/img/default-profile.png"
                                        alt="Default profile picture">
                                @endif
                            </div>

                            <h3 class="profile-username text-center">{{ $user->name }}</h3>

                            <p class="text-muted text-center">
                                {{ $user->role }} 
                                @if($user->pangkat)
                                <span class="badge badge-primary">{{ $user->pangkat }}</span>
                                @endif
                            </p>

                            <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item">
                                    <b>Email</b> <a class="float-right">{{ $user->email }}</a>
                                </li>
                                @if($user->nrp)
                                <li class="list-group-item">
                                    <b>NRP</b> <a class="float-right">{{ $user->nrp }}</a>
                                </li>
                                @endif
                                <li class="list-group-item">
                                    <b>Status</b> 
                                    <span class="float-right">
                                        @if($user->is_active)
                                            <span class="badge badge-success">Aktif</span>
                                        @else
                                            <span class="badge badge-danger">Tidak Aktif</span>
                                        @endif
                                    </span>
                                </li>
                            </ul>

                            <div class="d-flex justify-content-between">
                                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger delete-btn">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header p-2">
                            <h3 class="card-title">Informasi Detail</h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <tbody>
                                        <tr>
                                            <th style="width: 30%">Jabatan</th>
                                            <td>{{ $user->jabatan ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Sub Bidang</th>
                                            <td>{{ $user->sub_bidang ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Tanggal Registrasi</th>
                                            <td>{{ $user->created_at->format('d F Y, H:i') }}</td>
                                        </tr>
                                        <tr>
                                            <th>Terakhir Diperbarui</th>
                                            <td>{{ $user->updated_at->format('d F Y, H:i') }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    // Handle delete confirmation
    $('.delete-form').on('submit', function(e) {
        e.preventDefault();
        
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "User yang dihapus tidak dapat dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                this.submit();
            }
        });
    });
});
</script>
@endpush
@endsection