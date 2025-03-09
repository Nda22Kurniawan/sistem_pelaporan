@extends('layout')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Tambah User Baru</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Users</a></li>
                        <li class="breadcrumb-item active">Tambah Baru</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name" class="required">Nama Lengkap</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        id="name" name="name" value="{{ old('name') }}" required>
                                    @error('name')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="email" class="required">Email</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        id="email" name="email" value="{{ old('email') }}" required>
                                    @error('email')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="password" class="required">Password</label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                                        id="password" name="password" required>
                                    <small class="text-muted">Minimal 8 karakter</small>
                                    @error('password')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="nrp">NRP</label>
                                    <input type="text" class="form-control @error('nrp') is-invalid @enderror"
                                        id="nrp" name="nrp" value="{{ old('nrp') }}">
                                    @error('nrp')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="pangkat">Pangkat</label>
                                    <select class="form-control @error('pangkat') is-invalid @enderror" id="pangkat" name="pangkat">
                                        <option value="">Pilih Pangkat</option>
                                        <option value="IPTU" {{ old('pangkat') == 'IPTU' ? 'selected' : '' }}>IPTU</option>
                                        <option value="AKP" {{ old('pangkat') == 'AKP' ? 'selected' : '' }}>AKP</option>
                                        <option value="KOMPOL" {{ old('pangkat') == 'KOMPOL' ? 'selected' : '' }}>KOMPOL</option>
                                        <option value="AKBP" {{ old('pangkat') == 'AKBP' ? 'selected' : '' }}>AKBP</option>
                                        <option value="BRIPDA" {{ old('pangkat') == 'BRIPDA' ? 'selected' : '' }}>BRIPDA</option>
                                        <option value="BRIPTU" {{ old('pangkat') == 'BRIPTU' ? 'selected' : '' }}>BRIPTU</option>
                                        <option value="BRIGADIR" {{ old('pangkat') == 'BRIGADIR' ? 'selected' : '' }}>BRIGADIR</option>
                                        <option value="BRIPKA" {{ old('pangkat') == 'BRIPKA' ? 'selected' : '' }}>BRIPKA</option>
                                        <option value="AIPDA" {{ old('pangkat') == 'AIPDA' ? 'selected' : '' }}>AIPDA</option>
                                        <option value="AIPTU" {{ old('pangkat') == 'AIPTU' ? 'selected' : '' }}>AIPTU</option>
                                    </select>
                                    @error('pangkat')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="jabatan">Jabatan</label>
                                    <input type="text" class="form-control @error('jabatan') is-invalid @enderror"
                                        id="jabatan" name="jabatan" value="{{ old('jabatan') }}">
                                    @error('jabatan')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group" id="sub_bidang_group">
                                    <label for="sub_bidang">Sub Bidang</label>
                                    <select class="form-control @error('sub_bidang') is-invalid @enderror" id="sub_bidang" name="sub_bidang">
                                        <option value="">Pilih Sub Bidang</option>
                                        <option value="SUBBAG RENMIN" {{ old('sub_bidang') == 'SUBBAG RENMIN' ? 'selected' : '' }}>SUBBAG RENMIN</option>
                                        <option value="SUBBID TEKKOM" {{ old('sub_bidang') == 'SUBBID TEKKOM' ? 'selected' : '' }}>SUBBID TEKKOM</option>
                                        <option value="SUBBID TEKINFO" {{ old('sub_bidang') == 'SUBBID TEKINFO' ? 'selected' : '' }}>SUBBID TEKINFO</option>
                                    </select>
                                    @error('sub_bidang')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="role">Role</label>
                                    <select class="form-control @error('role') is-invalid @enderror" id="role" name="role" required>
                                        <option value="">Pilih Role</option>
                                        <option value="KEPALA BIDANG" {{ old('role') == 'KEPALA BIDANG' ? 'selected' : '' }}>
                                            Kepala Bidang
                                        </option>
                                        <option value="KEPALA SUB BIDANG" {{ old('role') == 'KEPALA SUB BIDANG' ? 'selected' : '' }}>
                                            Kepala Sub Bidang
                                        </option>
                                        <option value="ANGGOTA" {{ old('role') == 'ANGGOTA' ? 'selected' : '' }}>
                                            Anggota
                                        </option>
                                    </select>
                                    @error('role')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="foto_profile">Foto Profile</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input @error('foto_profile') is-invalid @enderror"
                                                id="foto_profile" name="foto_profile" accept=".jpeg,.jpg,.png">
                                            <label class="custom-file-label" for="foto_profile">Pilih foto</label>
                                        </div>
                                    </div>
                                    <small class="text-muted">Format: JPEG, JPG, PNG. Maksimal ukuran: 2MB</small>
                                    <!-- Preview container -->
                                    <div id="photo-preview-container" class="mt-2"></div>
                                    @error('foto_profile')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input"
                                            id="is_active" name="is_active" value="1"
                                            {{ old('is_active', 1) ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="is_active">User Aktif</label>
                                    </div>
                                    @error('is_active')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="{{ route('users.index') }}" class="btn btn-secondary">Batal</a>
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
</style>

@push('scripts')
<script src="/assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<script>
$(document).ready(function() {
    // Initialize custom file input
    bsCustomFileInput.init();
    
    // Create a container for preview if it doesn't exist
    if (!$('#preview-container').length) {
        $('.form-group:has(#foto_profile)').append('<div id="preview-container" class="row mt-3"></div>');
    }
    
    // Handle file selection for photo
    $("#foto_profile").on("change", function(e) {
        const file = this.files[0];
        
        // Clear previous preview
        $("#preview-container").empty();
        
        if (file) {
            // Create preview for the selected image
            const reader = new FileReader();
            
            reader.onload = function(event) {
                // Create preview card
                const col = $('<div class="col-md-4 col-sm-6 mb-3"></div>');
                const card = $('<div class="card h-100 shadow-sm"></div>');
                const cardBody = $('<div class="card-body p-2 text-center"></div>');
                const imgContainer = $('<div style="height: 180px; overflow: hidden;"></div>');
                const img = $(`<img src="${event.target.result}" class="img-fluid" style="object-fit: cover; height: 100%; width: 100%;">`);
                const fileName = $(`<p class="card-text small text-muted mt-2 mb-0">${file.name.length > 20 ? file.name.substring(0, 20) + '...' : file.name}</p>`);
                const fileSize = $(`<p class="card-text small text-muted">${formatFileSize(file.size)}</p>`);
                
                // Add remove button
                const removeBtn = $(`<button type="button" class="btn btn-sm btn-danger mt-1">Hapus</button>`);
                removeBtn.on('click', function() {
                    // Clear the file input
                    $("#foto_profile").val('');
                    // Update the file label
                    $("#foto_profile").siblings(".custom-file-label").removeClass("selected").html("Pilih foto");
                    // Remove the preview
                    $("#preview-container").empty();
                });
                
                // Assemble preview
                imgContainer.append(img);
                cardBody.append(fileName, fileSize, removeBtn);
                card.append(imgContainer, cardBody);
                col.append(card);
                $("#preview-container").append(col);
            };
            
            // Read file
            reader.readAsDataURL(file);
        }
    });
    
    // Helper function to format file size
    function formatFileSize(bytes) {
        if (bytes < 1024) return bytes + ' B';
        else if (bytes < 1048576) return (bytes / 1024).toFixed(1) + ' KB';
        else return (bytes / 1048576).toFixed(1) + ' MB';
    }

    // Handle role change to show/hide and disable/enable sub_bidang
    function handleRoleChange() {
        const selectedRole = $('#role').val();
        const subBidangField = $('#sub_bidang');
        const subBidangGroup = $('#sub_bidang_group');
        const jabatanField = $('#jabatan');
        
        if (selectedRole === 'KEPALA BIDANG') {
            // Hide and disable sub_bidang
            subBidangGroup.hide();
            subBidangField.val('').prop('disabled', true);
            
            // Set jabatan value
            jabatanField.val('Kepala Bidang TIK').prop('readonly', true);
        } else {
            // Show and enable sub_bidang
            subBidangGroup.show();
            subBidangField.prop('disabled', false);
            
            // Enable jabatan field and clear if it was set to Kepala Bidang TIK
            jabatanField.prop('readonly', false);
            if (jabatanField.val() === 'Kepala Bidang TIK') {
                jabatanField.val('');
            }
        }
    }

    // Initial check when page loads
    handleRoleChange();

    // Listen for role changes
    $('#role').on('change', handleRoleChange);

    // Trigger change event on page load if role is already selected
    if ($('#role').val() === 'KEPALA BIDANG') {
        $('#role').trigger('change');
    }
});
</script>
@endpush
@endsection