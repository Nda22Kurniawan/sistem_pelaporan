<?php

namespace App\Http\Controllers;

use App\Models\SuratPerintah;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SprinController extends Controller
{
    /**
     * Display a listing of the sprins.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $sprins = SuratPerintah::latest()->get();
        return view('sprin.index', compact('sprins'));
    }

    /**
     * Show the form for creating a new sprin.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // Check user role for create action
        if (!in_array(auth()->user()->role, ['KEPALA BIDANG', 'KEPALA SUB BIDANG'])) {
            return redirect()->route('sprin.index')
                ->with('error', 'Anda tidak memiliki izin untuk membuat surat perintah.');
        }

        $users = User::where('is_active', true)->get();
        return view('sprin.create', compact('users'));
    }

    /**
     * Store a newly created sprin in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        if (!in_array(auth()->user()->role, ['KEPALA BIDANG', 'KEPALA SUB BIDANG'])) {
            return redirect()->route('sprin.index')
                ->with('error', 'Anda tidak memiliki izin untuk membuat surat perintah.');
        }

        $validated = $request->validate([
            'nomor_surat' => 'required|string|max:255',
            'tanggal_surat' => 'required|date',
            'perihal' => 'required|string|max:255',
            'dasar_surat' => 'nullable|string',
            'file' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'personil' => 'required|array|min:1'
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $path = $file->store('surat-perintah', 'public');
            $validated['file'] = $path;
        }

        $sprin = SuratPerintah::create($validated);
        $sprin->users()->attach($request->personil);

        return redirect()->route('sprin.index')
            ->with('success', 'Surat Perintah berhasil dibuat');
    }

    /**
     * Display the specified sprin.
     *
     * @param  \App\Models\SuratPerintah  $sprin
     * @return \Illuminate\View\View
     */
    public function show(SuratPerintah $sprin)
    {
        return view('sprin.show', compact('sprin'));
    }

    /**
     * Show the form for editing the specified sprin.
     *
     * @param  \App\Models\SuratPerintah  $sprin
     * @return \Illuminate\View\View
     */
    public function edit(SuratPerintah $sprin)
    {
        // Check user role for edit action
        if (!in_array(auth()->user()->role, ['KEPALA BIDANG', 'KEPALA SUB BIDANG'])) {
            return redirect()->route('sprin.index')
                ->with('error', 'Anda tidak memiliki izin untuk mengedit surat perintah.');
        }

        $users = User::where('is_active', true)->get();
        return view('sprin.edit', compact('sprin', 'users'));
    }

    /**
     * Update the specified sprin in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SuratPerintah  $sprin
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, SuratPerintah $sprin)
    {

        if (!in_array(auth()->user()->role, ['KEPALA BIDANG', 'KEPALA SUB BIDANG'])) {
            return redirect()->route('sprin.index')
                ->with('error', 'Anda tidak memiliki izin untuk mengupdate surat perintah.');
        }

        $validated = $request->validate([
            'nomor_surat' => 'required|string|max:255',
            'tanggal_surat' => 'required|date',
            'perihal' => 'required|string|max:255',
            'dasar_surat' => 'nullable|string',
            'file' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'personil' => 'required|array|min:1'
        ]);

        if ($request->hasFile('file')) {
            if ($sprin->file) {
                Storage::disk('public')->delete($sprin->file);
            }

            $file = $request->file('file');
            $path = $file->store('surat-perintah', 'public');
            $validated['file'] = $path;
        }

        $sprin->update($validated);
        $sprin->users()->sync($request->personil);

        return redirect()->route('sprin.index')
            ->with('success', 'Surat Perintah berhasil diperbarui');
    }

    /**
     * Update the status of a specific surat perintah
     *
     * @param  \App\Models\SuratPerintah  $sprin
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateStatus(SuratPerintah $sprin)
    {
        // Check user role for status update
        if (!in_array(auth()->user()->role, ['KEPALA SUB BIDANG', 'ANGGOTA'])) {
            return redirect()->route('sprin.index')
                ->with('error', 'Anda tidak memiliki izin untuk mengubah status surat perintah.');
        }

        // Only allow changing from 'belum_mulai' to 'proses'
        if ($sprin->status !== 'belum_mulai') {
            return redirect()->route('sprin.index')
                ->with('error', 'Status surat perintah tidak dapat diubah.');
        }

        $sprin->update(['status' => 'proses']);

        return redirect()->route('sprin.index')
            ->with('success', 'Status Surat Perintah berhasil diperbarui');
    }

    /**
     * Remove the specified sprin from storage.
     *
     * @param  \App\Models\SuratPerintah  $sprin
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(SuratPerintah $sprin)
    {
        // Check user role for destroy action
        if (!in_array(auth()->user()->role, ['KEPALA BIDANG', 'KEPALA SUB BIDANG'])) {
            return redirect()->route('sprin.index')
                ->with('error', 'Anda tidak memiliki izin untuk menghapus surat perintah.');
        }

        // Existing destroy logic remains the same
        if ($sprin->file) {
            Storage::disk('public')->delete($sprin->file);
        }

        $sprin->delete();

        return redirect()->route('sprin.index')
            ->with('success', 'Surat Perintah berhasil dihapus');
    }
}
