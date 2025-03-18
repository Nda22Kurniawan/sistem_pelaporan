<?php

namespace App\Http\Controllers;

use App\Models\Kegiatan;
use App\Models\SuratPerintah;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

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
    public function create()
    {
        $suratPerintahs = SuratPerintah::with('users')->whereNotExists(function ($query) {
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
        $validatedData = $request->validate([
            'surat_perintah_id' => 'required|exists:surat_perintahs,id',
            'nama_kegiatan' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'lokasi' => 'required|string|max:255',
            'penanggung_jawab' => 'required|array|min:1',
            'penanggung_jawab.*' => 'exists:users,id',
            'hasil_kegiatan' => 'nullable|string',
            'kesimpulan' => 'nullable|string',
            'image' => 'nullable|array',
            'image.*' => 'image|mimes:jpeg,png,jpg|max:2048'
        ]);

        DB::beginTransaction();
        try {
            $imageUploads = [];
            if ($request->hasFile('image')) {
                foreach ($request->file('image') as $file) {
                    $binaryData = file_get_contents($file->getRealPath());
                    $imageUploads[] = base64_encode($binaryData);
                }
            }

            $penanggungJawabNames = User::whereIn('id', $validatedData['penanggung_jawab'])
                ->pluck('name')
                ->implode(', ');

            $kegiatan = Kegiatan::create([
                'surat_perintah_id' => $validatedData['surat_perintah_id'],
                'nama_kegiatan' => $validatedData['nama_kegiatan'],
                'deskripsi' => $validatedData['deskripsi'] ?? null,
                'tanggal_mulai' => $validatedData['tanggal_mulai'],
                'tanggal_selesai' => $validatedData['tanggal_selesai'],
                'lokasi' => $validatedData['lokasi'],
                'penanggung_jawab' => $penanggungJawabNames,
                'hasil_kegiatan' => $validatedData['hasil_kegiatan'] ?? null,
                'kesimpulan' => $validatedData['kesimpulan'] ?? null,
                'image' => $imageUploads ? json_encode($imageUploads) : null
            ]);

            $kegiatan->users()->attach($validatedData['penanggung_jawab']);

            DB::commit();

            return redirect()->route('kegiatan.index')
                ->with('success', 'Laporan Kegiatan berhasil dibuat.');
        } catch (\Exception $e) {
            DB::rollBack();

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
        $kegiatan->image = $kegiatan->image ? json_decode($kegiatan->image) : [];
        return view('kegiatan.show', compact('kegiatan'));
    }

    /**
     * Show the form for editing the specified activity report.
     */
    public function edit(Kegiatan $kegiatan)
    {
        $kegiatan->load(['suratPerintah', 'users']);

        return view('kegiatan.edit', compact('kegiatan'));
    }

    /**
     * Update the specified activity report in storage.
     */
    public function update(Request $request, Kegiatan $kegiatan)
    {
        $validatedData = $request->validate([
            'deskripsi' => 'nullable|string',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'lokasi' => 'required|string|max:255',
            'penanggung_jawab' => 'required|array|min:1',
            'penanggung_jawab.*' => 'exists:users,id',
            'hasil_kegiatan' => 'nullable|string',
            'kesimpulan' => 'nullable|string',
            'image' => 'nullable|array',
            'image.*' => 'image|mimes:jpeg,png,jpg|max:2048',
            'delete_images' => 'nullable|array',
            'delete_images.*' => 'integer'
        ]);

        DB::beginTransaction();
        try {
            $existingImages = [];
            if ($kegiatan->image) {
                $existingImages = json_decode($kegiatan->image, true);

                if ($request->has('delete_images')) {
                    foreach ($request->delete_images as $index) {
                        if (isset($existingImages[$index])) {
                            unset($existingImages[$index]);
                        }
                    }
                    $existingImages = array_values($existingImages);
                }
            }

            if ($request->hasFile('image')) {
                foreach ($request->file('image') as $file) {
                    $binaryData = file_get_contents($file->getRealPath());
                    $existingImages[] = base64_encode($binaryData);
                }
            }

            $penanggungJawabNames = User::whereIn('id', $validatedData['penanggung_jawab'])
                ->pluck('name')
                ->implode(', ');

            $kegiatan->update([
                'deskripsi' => $validatedData['deskripsi'] ?? null,
                'tanggal_mulai' => $validatedData['tanggal_mulai'],
                'tanggal_selesai' => $validatedData['tanggal_selesai'],
                'lokasi' => $validatedData['lokasi'],
                'penanggung_jawab' => $penanggungJawabNames,
                'hasil_kegiatan' => $validatedData['hasil_kegiatan'] ?? null,
                'kesimpulan' => $validatedData['kesimpulan'] ?? null,
                'image' => !empty($existingImages) ? json_encode($existingImages) : null
            ]);

            $kegiatan->users()->sync($validatedData['penanggung_jawab']);

            DB::commit();

            return redirect()->route('kegiatan.show', $kegiatan->id)
                ->with('success', 'Laporan Kegiatan berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();

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

    public function generatePdf(Kegiatan $kegiatan)
    {
        $kegiatan->load(['suratPerintah', 'users']);
        $kegiatan->image = $kegiatan->image ? json_decode($kegiatan->image) : [];
        $pdf = PDF::loadView('kegiatan.pdf', compact('kegiatan'));
        $pdf->setPaper('a4', 'portrait');
        return $pdf->download('laporan-kegiatan-' . $kegiatan->id . '.pdf');
    }

    public function previewPdf(Kegiatan $kegiatan)
    {
        $kegiatan->load(['suratPerintah', 'users']);
        $kegiatan->image = $kegiatan->image ? json_decode($kegiatan->image) : [];

        // Update path to match your folder structure
        $logo_path = public_path('images/logo-polri.png');
        $logo_polri = null;

        if (file_exists($logo_path)) {
            $logo_polri = base64_encode(file_get_contents($logo_path));
        }

        $pdf = PDF::loadView('kegiatan.pdf', [
            'kegiatan' => $kegiatan,
            'logo_polri' => $logo_polri
        ]);
        $pdf->setPaper('a4', 'portrait');

        return $pdf->stream('laporan-kegiatan-' . $kegiatan->id . '.pdf');
    }
}
