@extends('layout')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Buat Surat Perintah Baru</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('sprin.index') }}">Surat Perintah</a></li>
                        <li class="breadcrumb-item active">Buat Baru</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <form action="{{ route('sprin.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="nomor">Nomor Surat Perintah</label>
                            <input type="text" class="form-control @error('nomor') is-invalid @enderror" 
                                   id="nomor" name="nomor" value="{{ old('nomor') }}" required>
                            @error('nomor')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="tanggal">Tanggal</label>
                            <input type="date" class="form-control @error('tanggal') is-invalid @enderror" 
                                   id="tanggal" name="tanggal" value="{{ old('tanggal') }}" required>
                            @error('tanggal')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="kegiatan">Kegiatan</label>
                            <textarea class="form-control @error('kegiatan') is-invalid @enderror" 
                                      id="kegiatan" name="kegiatan" rows="3" required>{{ old('kegiatan') }}</textarea>
                            @error('kegiatan')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="personil">Personil yang Ditugaskan</label>
                            <select class="form-control select2 @error('personil') is-invalid @enderror" 
                                    id="personil" name="personil[]" multiple required>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }} - {{ $user->nrp }}</option>
                                @endforeach
                            </select>
                            @error('personil')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="file_sprin">File Surat Perintah</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input @error('file_sprin') is-invalid @enderror" 
                                           id="file_sprin" name="file_sprin">
                                    <label class="custom-file-label" for="file_sprin">Pilih file</label>
                                </div>
                            </div>
                            @error('file_sprin')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="{{ route('sprin.index') }}" class="btn btn-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>
@endsection

<script>
$(document).ready(function() {
    $('.select2').select2({
        theme: 'bootstrap4'
    });

    bsCustomFileInput.init();
});
</script>