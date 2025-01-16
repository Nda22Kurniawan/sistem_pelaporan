<?php

namespace App\Http\Controllers;

use App\Models\Kegiatan;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    /**
     * Display a listing of the laporan kegiatan.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $kegiatans = Kegiatan::with('suratPerintah')
                            ->latest()
                            ->get();
        
        return view('laporan.index', compact('kegiatans'));
    }

    /**
     * Show the form for creating a new laporan.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('laporan.create');
    }

    /**
     * Store a newly created laporan in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'surat_perintah_id' => 'required|exists:surat_perintahs,id',
            'nama_kegiatan' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'lokasi' => 'required|string|max:255',
            'penanggung_jawab' => 'required|string|max:255',
            'jumlah_peserta' => 'nullable|integer|min:0',
            'hasil_kegiatan' => 'nullable|string',
            'kesimpulan' => 'nullable|string',
            'image.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        // Handle multiple image uploads
        if ($request->hasFile('image')) {
            $images = [];
            foreach ($request->file('image') as $file) {
                $path = $file->store('kegiatan-images', 'public');
                $images[] = $path;
            }
            $validated['image'] = json_encode($images);
        }

        Kegiatan::create($validated);

        return redirect()->route('laporan.index')
                        ->with('success', 'Laporan kegiatan berhasil ditambahkan');
    }

    /**
     * Display the specified laporan.
     *
     * @param  \App\Models\Kegiatan  $kegiatan
     * @return \Illuminate\View\View
     */
    public function show(Kegiatan $kegiatan)
    {
        return view('laporan.show', compact('kegiatan'));
    }

    /**
     * Show the form for editing the specified laporan.
     *
     * @param  \App\Models\Kegiatan  $kegiatan
     * @return \Illuminate\View\View
     */
    public function edit(Kegiatan $kegiatan)
    {
        return view('laporan.edit', compact('kegiatan'));
    }

    /**
     * Update the specified laporan in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Kegiatan  $kegiatan
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Kegiatan $kegiatan)
    {
        $validated = $request->validate([
            'surat_perintah_id' => 'required|exists:surat_perintahs,id',
            'nama_kegiatan' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'lokasi' => 'required|string|max:255',
            'penanggung_jawab' => 'required|string|max:255',
            'jumlah_peserta' => 'nullable|integer|min:0',
            'hasil_kegiatan' => 'nullable|string',
            'kesimpulan' => 'nullable|string',
            'image.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        // Handle multiple image uploads
        if ($request->hasFile('image')) {
            $images = [];
            foreach ($request->file('image') as $file) {
                $path = $file->store('kegiatan-images', 'public');
                $images[] = $path;
            }
            $validated['image'] = json_encode($images);
        }

        $kegiatan->update($validated);

        return redirect()->route('laporan.index')
                        ->with('success', 'Laporan kegiatan berhasil diperbarui');
    }

    /**
     * Remove the specified laporan from storage.
     *
     * @param  \App\Models\Kegiatan  $kegiatan
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Kegiatan $kegiatan)
    {
        $kegiatan->delete();

        return redirect()->route('laporan.index')
                        ->with('success', 'Laporan kegiatan berhasil dihapus');
    }
}