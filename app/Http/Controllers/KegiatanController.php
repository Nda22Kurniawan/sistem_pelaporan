<?php

namespace App\Http\Controllers;

use App\Models\Kegiatan;
use App\Models\SuratPerintah;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class KegiatanController extends Controller
{
    /**
     * Display a listing of the activities.
     */
    public function index()
    {
        $kegiatans = Kegiatan::with('suratPerintah')->latest()->paginate(10);
        return view('kegiatan.index', compact('kegiatans'));
    }

    /**
     * Show the form for creating a new activity report.
     */
    // public function create()
    // {
    //     $suratPerintahs = SuratPerintah::where('status', 'aktif')->get();
    //     $users = User::all(); // Fetch all users for responsible persons selection
    //     return view('kegiatan.create', compact('suratPerintahs', 'users'));
    // }
    public function create()
    {
        // Get Surat Perintah that don't have associated Laporan Kegiatan yet
        $suratPerintahs = SuratPerintah::whereNotExists(function ($query) {
            $query->select('id')
                ->from('kegiatans')
                ->whereColumn('surat_perintah_id', 'surat_perintahs.id');
        })->get();

        $users = User::all();

        return view('kegiatan.create', compact('suratPerintahs', 'users'));
    }

    /**
     * Store a newly created activity report in storage.
     */
    public function store(Request $request)
    {
        // Validate the request
        $validatedData = $request->validate([
            'surat_perintah_id' => 'required|exists:surat_perintahs,id',
            'nama_kegiatan' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'lokasi' => 'required|string|max:255',
            'penanggung_jawab' => 'required|array|min:1',
            'penanggung_jawab.*' => 'exists:users,id',
            'jumlah_peserta' => 'nullable|integer|min:0',
            'hasil_kegiatan' => 'nullable|string',
            'kesimpulan' => 'nullable|string',
            'image' => 'nullable|array',
            'image.*' => 'image|mimes:jpeg,png,jpg|max:2048'
        ]);

        // Begin database transaction
        DB::beginTransaction();
        try {
            // Process image uploads
            $imageUploads = [];
            if ($request->hasFile('image')) {
                foreach ($request->file('image') as $file) {
                    $path = $file->store('kegiatan_dokumentasi', 'public');
                    $imageUploads[] = $path;
                }
            }

            // Convert penanggung_jawab to comma-separated string of user names
            $penanggungJawabNames = User::whereIn('id', $validatedData['penanggung_jawab'])
                ->pluck('name')
                ->implode(', ');

            // Create the Kegiatan record
            $kegiatan = Kegiatan::create([
                'surat_perintah_id' => $validatedData['surat_perintah_id'],
                'nama_kegiatan' => $validatedData['nama_kegiatan'],
                'deskripsi' => $validatedData['deskripsi'] ?? null,
                'tanggal_mulai' => $validatedData['tanggal_mulai'],
                'tanggal_selesai' => $validatedData['tanggal_selesai'],
                'lokasi' => $validatedData['lokasi'],
                'penanggung_jawab' => $penanggungJawabNames,
                'jumlah_peserta' => $validatedData['jumlah_peserta'] ?? null,
                'hasil_kegiatan' => $validatedData['hasil_kegiatan'] ?? null,
                'kesimpulan' => $validatedData['kesimpulan'] ?? null,
                'image' => $imageUploads ? json_encode($imageUploads) : null
            ]);

            DB::commit();

            return redirect()->route('kegiatan.index')
                ->with('success', 'Laporan Kegiatan berhasil dibuat.');
        } catch (\Exception $e) {
            DB::rollBack();

            // Delete any uploaded images if transaction fails
            if (!empty($imageUploads)) {
                foreach ($imageUploads as $imagePath) {
                    Storage::disk('public')->delete($imagePath);
                }
            }

            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal membuat Laporan Kegiatan: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified activity report.
     */
    public function show(Kegiatan $kegiatan)
    {
        // Decode image paths if they exist
        $kegiatan->image = $kegiatan->image ? json_decode($kegiatan->image) : [];
        return view('kegiatan.show', compact('kegiatan'));
    }

    /**
     * Show the form for editing the specified activity report.
     */
    // public function edit(Kegiatan $kegiatan)
    // {
    //     $suratPerintahs = SuratPerintah::where('status', 'aktif')->get();
    //     $users = User::all();

    //     // Decode image paths
    //     $kegiatan->image = $kegiatan->image ? json_decode($kegiatan->image) : [];

    //     return view('kegiatan.edit', compact('kegiatan', 'suratPerintahs', 'users'));
    // }
    public function edit(Kegiatan $kegiatan)
    {
        $suratPerintahs = SuratPerintah::all();
        $users = User::all();

        // Decode image paths
        $kegiatan->image = $kegiatan->image ? json_decode($kegiatan->image) : [];

        return view('kegiatan.edit', compact('kegiatan', 'suratPerintahs', 'users'));
    }

    /**
     * Update the specified activity report in storage.
     */
    public function update(Request $request, Kegiatan $kegiatan)
    {
        // Validate the request
        $validatedData = $request->validate([
            'surat_perintah_id' => 'required|exists:surat_perintahs,id',
            'nama_kegiatan' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'lokasi' => 'required|string|max:255',
            'penanggung_jawab' => 'required|array|min:1',
            'penanggung_jawab.*' => 'exists:users,id',
            'jumlah_peserta' => 'nullable|integer|min:0',
            'hasil_kegiatan' => 'nullable|string',
            'kesimpulan' => 'nullable|string',
            'image' => 'nullable|array',
            'image.*' => 'image|mimes:jpeg,png,jpg|max:2048',
            'remove_images' => 'nullable|array'
        ]);

        DB::beginTransaction();
        try {
            // Process existing images
            $existingImages = json_decode($kegiatan->image, true) ?? [];

            // Remove selected images
            if ($request->has('remove_images')) {
                foreach ($request->remove_images as $imageToRemove) {
                    Storage::disk('public')->delete($imageToRemove);
                    $existingImages = array_diff($existingImages, [$imageToRemove]);
                }
            }

            // Upload new images
            if ($request->hasFile('image')) {
                foreach ($request->file('image') as $file) {
                    $path = $file->store('kegiatan_dokumentasi', 'public');
                    $existingImages[] = $path;
                }
            }

            // Convert penanggung_jawab to comma-separated string of user names
            $penanggungJawabNames = User::whereIn('id', $validatedData['penanggung_jawab'])
                ->pluck('name')
                ->implode(', ');

            // Update the Kegiatan record
            $kegiatan->update([
                'surat_perintah_id' => $validatedData['surat_perintah_id'],
                'nama_kegiatan' => $validatedData['nama_kegiatan'],
                'deskripsi' => $validatedData['deskripsi'] ?? null,
                'tanggal_mulai' => $validatedData['tanggal_mulai'],
                'tanggal_selesai' => $validatedData['tanggal_selesai'],
                'lokasi' => $validatedData['lokasi'],
                'penanggung_jawab' => $penanggungJawabNames,
                'jumlah_peserta' => $validatedData['jumlah_peserta'] ?? null,
                'hasil_kegiatan' => $validatedData['hasil_kegiatan'] ?? null,
                'kesimpulan' => $validatedData['kesimpulan'] ?? null,
                'image' => $existingImages ? json_encode($existingImages) : null
            ]);

            DB::commit();

            return redirect()->route('kegiatan.index')
                ->with('success', 'Laporan Kegiatan berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();

            // Delete any newly uploaded images if transaction fails
            if (isset($newImages)) {
                foreach ($newImages as $imagePath) {
                    Storage::disk('public')->delete($imagePath);
                }
            }

            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal memperbarui Laporan Kegiatan: ' . $e->getMessage());
        }
    }

    public function updateStatus(Request $request, Kegiatan $kegiatan)
    {
        $request->validate([
            'status' => 'required|in:Diterima,Ditolak'
        ]);

        $kegiatan->status = $request->status;
        $kegiatan->save();

        // Jika status Diterima, update status Surat Perintah menjadi selesai
        if ($request->status === 'Diterima') {
            $suratPerintah = SuratPerintah::where('nomor_surat', $kegiatan->suratPerintah->nomor_surat)->first();
            if ($suratPerintah) {
                $suratPerintah->status = 'selesai';
                $suratPerintah->save();
            }
        }

        return redirect()->back()->with('success', 'Status laporan kegiatan berhasil diperbarui');
    }

    /**
     * Remove the specified activity report from storage.
     */
    public function destroy(Kegiatan $kegiatan)
    {
        // Delete associated images
        if ($kegiatan->image) {
            $imagePaths = json_decode($kegiatan->image);
            foreach ($imagePaths as $path) {
                Storage::disk('public')->delete($path);
            }
        }

        $kegiatan->delete();

        return redirect()->route('kegiatan.index')
            ->with('success', 'Laporan Kegiatan berhasil dihapus.');
    }
}
