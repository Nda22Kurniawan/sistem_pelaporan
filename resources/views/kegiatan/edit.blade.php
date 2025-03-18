@extends('layout')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Edit Laporan Kegiatan</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('kegiatan.index') }}">Laporan Kegiatan</a></li>
                        <li class="breadcrumb-item active">Edit Laporan</li>
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
                            <h3 class="card-title">Form Edit Laporan Kegiatan</h3>
                        </div>
                        <form action="{{ route('kegiatan.update', $kegiatan->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="surat_perintah_id">Nomor Surat Perintah</label>
                                    <input type="text" class="form-control" 
                                        value="{{ $kegiatan->suratPerintah->nomor_surat }}" readonly>
                                    <input type="hidden" name="surat_perintah_id" value="{{ $kegiatan->surat_perintah_id }}">
                                </div>

                                <div class="form-group">
                                    <label for="nama_kegiatan">Nama Kegiatan</label>
                                    <input type="text" class="form-control @error('nama_kegiatan') is-invalid @enderror"
                                        id="nama_kegiatan" name="nama_kegiatan" value="{{ old('nama_kegiatan', $kegiatan->nama_kegiatan) }}" required readonly>
                                    @error('nama_kegiatan')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="deskripsi">Deskripsi</label>
                                    <textarea class="form-control @error('deskripsi') is-invalid @enderror"
                                        id="deskripsi" name="deskripsi" rows="3">{{ old('deskripsi', $kegiatan->deskripsi) }}</textarea>
                                    @error('deskripsi')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="tanggal_mulai">Tanggal Mulai</label>
                                            <input type="date" class="form-control @error('tanggal_mulai') is-invalid @enderror"
                                                id="tanggal_mulai" name="tanggal_mulai" value="{{ old('tanggal_mulai', $kegiatan->tanggal_mulai) }}" required>
                                            @error('tanggal_mulai')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="tanggal_selesai">Tanggal Selesai</label>
                                            <input type="date" class="form-control @error('tanggal_selesai') is-invalid @enderror"
                                                id="tanggal_selesai" name="tanggal_selesai" value="{{ old('tanggal_selesai', $kegiatan->tanggal_selesai) }}" required>
                                            @error('tanggal_selesai')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="lokasi">Lokasi</label>
                                    <input type="text" class="form-control @error('lokasi') is-invalid @enderror"
                                        id="lokasi" name="lokasi" value="{{ old('lokasi', $kegiatan->lokasi) }}" required>
                                    @error('lokasi')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label class="required">Personil</label>
                                    <div id="personnel-list" class="list-group mt-2">
                                        @foreach($kegiatan->users as $user)
                                        <div class="list-group-item">
                                            <div class="d-flex w-100 justify-content-between">
                                                <h5 class="mb-1">{{ $user->name }}</h5>
                                            </div>
                                            <p class="mb-1">{{ $user->pangkat }} - {{ $user->nrp }}</p>
                                            <input type="hidden" name="penanggung_jawab[]" value="{{ $user->id }}">
                                        </div>
                                        @endforeach
                                    </div>
                                    
                                    @error('penanggung_jawab')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="hasil_kegiatan">Hasil Kegiatan</label>
                                    <textarea class="form-control @error('hasil_kegiatan') is-invalid @enderror"
                                        id="hasil_kegiatan" name="hasil_kegiatan" rows="3">{{ old('hasil_kegiatan', $kegiatan->hasil_kegiatan) }}</textarea>
                                    @error('hasil_kegiatan')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="kesimpulan">Kesimpulan</label>
                                    <textarea class="form-control @error('kesimpulan') is-invalid @enderror"
                                        id="kesimpulan" name="kesimpulan" rows="3">{{ old('kesimpulan', $kegiatan->kesimpulan) }}</textarea>
                                    @error('kesimpulan')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>Dokumentasi Kegiatan Saat Ini</label>
                                    @if($kegiatan->image && count(json_decode($kegiatan->image)) > 0)
                                    <div class="row" id="existing-images">
                                        @foreach(json_decode($kegiatan->image) as $index => $imageData)
                                        <div class="col-md-3 col-sm-4 col-6 mb-3">
                                            <div class="card h-100 shadow-sm">
                                                <div style="height: 120px; overflow: hidden;">
                                                    <img src="data:image/jpeg;base64,{{ $imageData }}" class="img-fluid" style="object-fit: cover; height: 100%; width: 100%;">
                                                </div>
                                                <div class="card-body p-2 text-center">
                                                    <p class="card-text small text-muted mb-2">Gambar {{ $index + 1 }}</p>
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" id="delete-image-{{ $index }}" name="delete_images[]" value="{{ $index }}">
                                                        <label class="custom-control-label" for="delete-image-{{ $index }}">Hapus</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                    @else
                                    <p class="text-muted">Tidak ada gambar yang tersedia.</p>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label for="image">Tambah Dokumentasi Baru</label>
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
                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                <a href="{{ route('kegiatan.index') }}" class="btn btn-default">Batal</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@push('scripts')
<script src="/assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<script>
    $(document).ready(function() {
        // Initialize custom file input
        bsCustomFileInput.init();

        if (!$('#daily-results-container').length) {
            $('#hasil_kegiatan').parent().before(`
                <div class="form-group">
                    <label for="daily-results-container">Hasil Kegiatan Harian</label>
                    <div id="daily-results-container" class="card">
                        <div class="card-body">
                            <p class="text-muted" id="no-dates-message">Silakan pilih tanggal mulai dan tanggal selesai terlebih dahulu</p>
                            <div id="daily-entries-list">
                                <!-- Daily entries will be generated here -->
                            </div>
                        </div>
                    </div>
                </div>
            `);
        }

        // Function to generate daily entry fields
        function generateDailyEntries() {
            const startDate = new Date($('#tanggal_mulai').val());
            const endDate = new Date($('#tanggal_selesai').val());
            
            // Clear previous entries
            $('#daily-entries-list').empty();
            
            // Validate dates
            if (isNaN(startDate.getTime()) || isNaN(endDate.getTime())) {
                $('#no-dates-message').show();
                return;
            }
            
            if (startDate > endDate) {
                $('#daily-entries-list').append(`
                    <div class="alert alert-warning">
                        Tanggal mulai tidak boleh lebih besar dari tanggal selesai
                    </div>
                `);
                $('#no-dates-message').hide();
                return;
            }
            
            // Hide the message since we have valid dates
            $('#no-dates-message').hide();
            
            // Loop through each day in the range
            const currentDate = new Date(startDate);
            let index = 0;
            
            while (currentDate <= endDate) {
                const formattedDate = currentDate.toISOString().split('T')[0];
                const dayName = new Intl.DateTimeFormat('id-ID', { weekday: 'long' }).format(currentDate);
                const formattedDisplayDate = new Intl.DateTimeFormat('id-ID', { 
                    day: '2-digit', 
                    month: 'long', 
                    year: 'numeric' 
                }).format(currentDate);
                
                // Create input for each day
                $('#daily-entries-list').append(`
                    <div class="daily-entry card mb-3">
                        <div class="card-header bg-light">
                            <strong>${dayName}, ${formattedDisplayDate}</strong>
                        </div>
                        <div class="card-body">
                            <textarea 
                                class="form-control daily-result" 
                                rows="3" 
                                data-date="${formattedDate}" 
                                placeholder="Masukkan hasil kegiatan untuk tanggal ini"
                            ></textarea>
                        </div>
                    </div>
                `);
                
                // Move to next day
                currentDate.setDate(currentDate.getDate() + 1);
                index++;
            }

            // Add event listener to compile all results
            $('.daily-result').on('input', compileResults);
        }

        // Function to compile all daily results into the main hasil_kegiatan field
        function compileResults() {
            let compiledResults = '';
            
            $('.daily-entry').each(function() {
                const date = $(this).find('.daily-result').data('date');
                const dayName = $(this).find('.card-header strong').text();
                const content = $(this).find('.daily-result').val().trim();
                
                if (content) {
                    compiledResults += `${dayName}:\n${content}\n\n`;
                }
            });
            
            // Update the main hasil_kegiatan textarea
            $('#hasil_kegiatan').val(compiledResults.trim());
        }

        // Listen for changes to the date fields
        $('#tanggal_mulai, #tanggal_selesai').on('change', function() {
            generateDailyEntries();
        });

        // Initialize the form if dates are already set (e.g., from old input)
        if ($('#tanggal_mulai').val() && $('#tanggal_selesai').val()) {
            generateDailyEntries();
            
            // If there's existing hasil_kegiatan data, try to parse and distribute it
            const existingData = $('#hasil_kegiatan').val();
            if (existingData) {
                // This is a simple attempt to parse existing data back into daily entries
                // It assumes a format like "Day, Date: Content"
                const lines = existingData.split('\n');
                let currentEntry = '';
                let currentDate = '';
                
                for (let i = 0; i < lines.length; i++) {
                    const line = lines[i];
                    
                    // Check if this line starts a new entry
                    if (line.includes(':') && (line.includes('Senin') || line.includes('Selasa') || 
                        line.includes('Rabu') || line.includes('Kamis') || line.includes('Jumat') || 
                        line.includes('Sabtu') || line.includes('Minggu'))) {
                        
                        // Extract the date information
                        const dateInfo = line.split(':')[0].trim();
                        
                        // Find the textarea for this date and populate it
                        $('.daily-entry').each(function() {
                            if ($(this).find('.card-header strong').text() === dateInfo) {
                                // Found the right textarea, wait for next iterations to get content
                                currentDate = dateInfo;
                                currentEntry = '';
                            }
                        });
                    } else if (currentDate) {
                        // Add this line to the current entry
                        currentEntry += (currentEntry ? '\n' : '') + line;
                        
                        // If next line is empty or we're at the end, save this entry
                        if (!lines[i+1] || i === lines.length - 1) {
                            $('.daily-entry').each(function() {
                                if ($(this).find('.card-header strong').text() === currentDate) {
                                    $(this).find('.daily-result').val(currentEntry.trim());
                                    currentDate = '';
                                    currentEntry = '';
                                }
                            });
                        }
                    }
                }
            }
        }

        // Create a container for previews if it doesn't exist
        if (!$('#preview-container').length) {
            $('.form-group:has(#image)').append('<div id="preview-container" class="row mt-3"></div>');
        }
        
        // Create a container for selected files data
        if (!$('#selected-files-container').length) {
            $('.form-group:has(#image)').append('<div id="selected-files-container" class="d-none"></div>');
        }
        
        // Store the Data Transfer object for accumulating files
        let selectedFiles = new DataTransfer();
        
        // Handle file selection for multiple images
        $("#image").on("change", function(e) {
            const newFiles = this.files;
            
            // Add new files to our DataTransfer object
            for (let i = 0; i < newFiles.length; i++) {
                selectedFiles.items.add(newFiles[i]);
            }
            
            // Update the input with all accumulated files
            this.files = selectedFiles.files;
            
            // Update preview
            updatePreview(this.files);
            
            // Update label with count
            $(this).siblings(".custom-file-label").addClass("selected").html(selectedFiles.files.length + " file dipilih");
        });
        
        // Function to update the preview
        function updatePreview(files) {
            // Clear previous previews
            $("#preview-container").empty();
            
            if (files.length > 0) {
                // Generate previews for each file
                Array.from(files).forEach(function(file, index) {
                    // Skip non-image files
                    if (!file.type.match('image.*')) {
                        return;
                    }
                    
                    // Create preview elements
                    const reader = new FileReader();
                    
                    reader.onload = function(event) {
                        // Create preview card
                        const col = $('<div class="col-md-3 col-sm-4 col-6 mb-3"></div>');
                        const card = $('<div class="card h-100 shadow-sm"></div>');
                        const cardBody = $('<div class="card-body p-2 text-center"></div>');
                        const imgContainer = $('<div style="height: 120px; overflow: hidden;"></div>');
                        const img = $(`<img src="${event.target.result}" class="img-fluid" style="object-fit: cover; height: 100%; width: 100%;">`);
                        const fileName = $(`<p class="card-text small text-muted mt-2 mb-0">${file.name.length > 15 ? file.name.substring(0, 15) + '...' : file.name}</p>`);
                        const fileSize = $(`<p class="card-text small text-muted">${formatFileSize(file.size)}</p>`);
                        
                        // Add remove button
                        const removeBtn = $(`<button type="button" class="btn btn-sm btn-danger mt-1" data-index="${index}">Hapus</button>`);
                        removeBtn.on('click', function() {
                            removeFile($(this).data('index'));
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
                });
            }
        }
        
        // Function to remove a file
        function removeFile(index) {
            const dt = new DataTransfer();
            const input = document.getElementById('image');
            const { files } = input;
            
            // Add all files except the one to remove
            for (let i = 0; i < files.length; i++) {
                if (i !== index) {
                    dt.items.add(files[i]);
                }
            }
            
            // Update the selected files
            selectedFiles = dt;
            input.files = dt.files;
            
            // Update preview
            updatePreview(input.files);
            
            // Update label
            if (dt.files.length > 0) {
                $(input).siblings(".custom-file-label").addClass("selected").html(dt.files.length + " file dipilih");
            } else {
                $(input).siblings(".custom-file-label").removeClass("selected").html("Pilih file");
            }
        }
        
        // Helper function to format file size
        function formatFileSize(bytes) {
            if (bytes < 1024) return bytes + ' B';
            else if (bytes < 1048576) return (bytes / 1024).toFixed(1) + ' KB';
            else return (bytes / 1048576).toFixed(1) + ' MB';
        }
    });
</script>
@endpush

@endsection