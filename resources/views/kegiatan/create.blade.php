@extends('layout')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Tambah Laporan Kegiatan</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('kegiatan.index') }}">Laporan Kegiatan</a></li>
                        <li class="breadcrumb-item active">Tambah Laporan</li>
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
                        <div class="card-header">
                            <h3 class="card-title">Form Tambah Laporan Kegiatan</h3>
                        </div>
                        <form action="{{ route('kegiatan.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="surat_perintah_id">Nomor Surat Perintah</label>
                                    <select name="surat_perintah_id" id="surat_perintah_id" class="form-control @error('surat_perintah_id') is-invalid @enderror" required>
                                        <option value="">Pilih Surat Perintah</option>
                                        @foreach($suratPerintahs as $surat)
                                        @if(!$surat->laporan_kegiatan)
                                        <option value="{{ $surat->id }}" data-perihal="{{ $surat->perihal }}"
                                            {{ old('surat_perintah_id') == $surat->id ? 'selected' : '' }}>
                                            {{ $surat->nomor_surat }}
                                        </option>
                                        @endif
                                        @endforeach
                                    </select>
                                    @error('surat_perintah_id')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="nama_kegiatan">Nama Kegiatan</label>
                                    <input type="text" class="form-control @error('nama_kegiatan') is-invalid @enderror"
                                        id="nama_kegiatan" name="nama_kegiatan" value="{{ old('nama_kegiatan') }}" required>
                                    @error('nama_kegiatan')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="deskripsi">Deskripsi</label>
                                    <textarea class="form-control @error('deskripsi') is-invalid @enderror"
                                        id="deskripsi" name="deskripsi" rows="3">{{ old('deskripsi') }}</textarea>
                                    @error('deskripsi')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="tanggal_mulai">Tanggal Mulai</label>
                                            <input type="date" class="form-control @error('tanggal_mulai') is-invalid @enderror"
                                                id="tanggal_mulai" name="tanggal_mulai" value="{{ old('tanggal_mulai') }}" required>
                                            @error('tanggal_mulai')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="tanggal_selesai">Tanggal Selesai</label>
                                            <input type="date" class="form-control @error('tanggal_selesai') is-invalid @enderror"
                                                id="tanggal_selesai" name="tanggal_selesai" value="{{ old('tanggal_selesai') }}" required>
                                            @error('tanggal_selesai')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="lokasi">Lokasi</label>
                                    <input type="text" class="form-control @error('lokasi') is-invalid @enderror"
                                        id="lokasi" name="lokasi" value="{{ old('lokasi') }}" required>
                                    @error('lokasi')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label class="required">Personil</label>
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" id="searchPenanggungJawab"
                                            placeholder="Cari berdasarkan nama atau NRP...">
                                        <div class="input-group-append">
                                            <span class="input-group-text">
                                                <i class="fas fa-search"></i>
                                            </span>
                                        </div>
                                    </div>
                                    @error('penanggung_jawab')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror

                                    <div class="card card-body p-0" style="max-height: 300px; overflow-y: auto;">
                                        <div class="list-group list-group-flush" id="personilList">
                                            @foreach($users as $user)
                                            <div class="list-group-item user-item">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input"
                                                        id="user{{ $user->id }}"
                                                        name="penanggung_jawab[]"
                                                        value="{{ $user->id }}"
                                                        data-name="{{ strtolower($user->name) }}"
                                                        data-nrp="{{ strtolower($user->nrp) }}"
                                                        {{ in_array($user->id, old('penanggung_jawab', [])) ? 'checked' : '' }}>
                                                    <label class="custom-control-label" for="user{{ $user->id }}">
                                                        <span class="d-block">{{ $user->name }}</span>
                                                        <small class="text-muted">
                                                            {{ $user->pangkat }} - {{ $user->nrp }}
                                                        </small>
                                                    </label>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                                <!-- <div class="form-group">
                                    <label for="jumlah_peserta">Jumlah Peserta</label>
                                    <input type="number" class="form-control @error('jumlah_peserta') is-invalid @enderror"
                                        id="jumlah_peserta" name="jumlah_peserta" value="{{ old('jumlah_peserta') }}">
                                    @error('jumlah_peserta')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div> -->

                                <div class="form-group">
                                    <label for="hasil_kegiatan">Hasil Kegiatan</label>
                                    <textarea class="form-control @error('hasil_kegiatan') is-invalid @enderror"
                                        id="hasil_kegiatan" name="hasil_kegiatan" rows="3">{{ old('hasil_kegiatan') }}</textarea>
                                    @error('hasil_kegiatan')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="kesimpulan">Kesimpulan</label>
                                    <textarea class="form-control @error('kesimpulan') is-invalid @enderror"
                                        id="kesimpulan" name="kesimpulan" rows="3">{{ old('kesimpulan') }}</textarea>
                                    @error('kesimpulan')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="image">Dokumentasi Kegiatan</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input @error('image.*') is-invalid @enderror"
                                                id="image" name="image[]" multiple accept="image/jpeg,image/png,image/jpg">
                                            <label class="custom-file-label" for="image">Pilih file</label>
                                        </div>
                                    </div>
                                    <small class="text-muted">Dapat memilih lebih dari satu file. Maksimal 2MB per file (format: jpg, jpeg, png)</small>
                                    @error('image.*')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                                <a href="{{ route('kegiatan.index') }}" class="btn btn-default">Batal</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@push('scripts')
<script>
    $(function() {
        // Initialize custom file input
        bsCustomFileInput.init();

        $(".custom-file-input").on("change", function() {
            var fileName = $(this).val().split("\\").pop();
            $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
        });

    });
</script>
@endpush