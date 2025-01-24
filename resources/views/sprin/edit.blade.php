@extends('layout')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit Surat Perintah</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('sprin.index') }}">Surat Perintah</a></li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <form action="{{ route('sprin.update', $sprin->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nomor_surat" class="required">Nomor Surat</label>
                                    <input type="text" class="form-control @error('nomor_surat') is-invalid @enderror"
                                        id="nomor_surat" name="nomor_surat" value="{{ old('nomor_surat', $sprin->nomor_surat) }}" required>
                                    @error('nomor_surat')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="tanggal_surat" class="required">Tanggal Surat</label>
                                    <input type="date" class="form-control @error('tanggal_surat') is-invalid @enderror"
                                        id="tanggal_surat" name="tanggal_surat" value="{{ old('tanggal_surat', $sprin->tanggal_surat ? \Carbon\Carbon::parse($sprin->tanggal_surat)->format('Y-m-d') : '') }}" required>
                                    @error('tanggal_surat')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="perihal" class="required">Perihal</label>
                                    <input type="text" class="form-control @error('perihal') is-invalid @enderror"
                                        id="perihal" name="perihal" value="{{ old('perihal', $sprin->perihal) }}" required>
                                    @error('perihal')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="dasar_surat">Dasar Surat</label>
                                    <textarea class="form-control @error('dasar_surat') is-invalid @enderror"
                                        id="dasar_surat" name="dasar_surat" rows="3">{{ old('dasar_surat', $sprin->dasar_surat) }}</textarea>
                                    @error('dasar_surat')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="file">File Surat</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input @error('file') is-invalid @enderror"
                                                id="file" name="file" accept=".pdf,.doc,.docx">
                                            <label class="custom-file-label" for="file">
                                                {{ $sprin->file ? basename($sprin->file) : 'Pilih file' }}
                                            </label>
                                        </div>
                                    </div>
                                    <small class="text-muted">Format: PDF, DOC, DOCX. Maksimal ukuran: 2MB</small>
                                    @if($sprin->file)
                                    <div class="mt-2">
                                        <a href="{{ Storage::url($sprin->file) }}" target="_blank" class="btn btn-sm btn-info">
                                            <i class="fas fa-file"></i> Lihat File Saat Ini
                                        </a>
                                    </div>
                                    @endif
                                    @error('file')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="required">Personil</label>
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" id="searchPersonil" 
                                            placeholder="Cari berdasarkan nama atau NRP...">
                                        <div class="input-group-append">
                                            <span class="input-group-text">
                                                <i class="fas fa-search"></i>
                                            </span>
                                        </div>
                                    </div>
                                    @error('personil')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                    
                                    <div class="card card-body p-0" style="max-height: 300px; overflow-y: auto;">
                                        <div class="list-group list-group-flush" id="personilList">
                                            @foreach($users as $user)
                                            <div class="list-group-item user-item">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" 
                                                        id="user{{ $user->id }}" 
                                                        name="personil[]" 
                                                        value="{{ $user->id }}"
                                                        data-name="{{ strtolower($user->name) }}"
                                                        data-nrp="{{ strtolower($user->nrp) }}"
                                                        {{ in_array($user->id, old('personil', $sprin->users->pluck('id')->toArray())) ? 'checked' : '' }}>
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
                            </div>
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

<style>
.required:after {
    content: " *";
    color: red;
}
.user-item:hover {
    background-color: #f8f9fa;
}
</style>

@push('scripts')
<script>
$(document).ready(function() {
    // Initialize custom file input
    bsCustomFileInput.init();

    // Search functionality
    $('#searchPersonil').on('keyup', function() {
        const searchText = $(this).val().toLowerCase();
        
        $('.user-item').each(function() {
            const $checkbox = $(this).find('input[type="checkbox"]');
            const userName = $checkbox.data('name');
            const userNrp = $checkbox.data('nrp');
            
            if (userName.includes(searchText) || userNrp.includes(searchText)) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    });
});
</script>
@endpush
@endsection