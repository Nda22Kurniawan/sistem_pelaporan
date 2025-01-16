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
        $validated = $request->validate([
            'nomor_surat' => 'required|string|max:255',
            'tanggal_surat' => 'required|date',
            'perihal' => 'required|string|max:255',
            'dasar_surat' => 'nullable|string',
            'file' => 'nullable|file|mimes:pdf,doc,docx|max:2048'
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $path = $file->store('surat-perintah', 'public');
            $validated['file'] = $path;
        }

        SuratPerintah::create($validated);

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
        $validated = $request->validate([
            'nomor_surat' => 'required|string|max:255',
            'tanggal_surat' => 'required|date',
            'perihal' => 'required|string|max:255',
            'dasar_surat' => 'nullable|string',
            'file' => 'nullable|file|mimes:pdf,doc,docx|max:2048'
        ]);

        if ($request->hasFile('file')) {
            // Delete old file if exists
            if ($sprin->file) {
                Storage::disk('public')->delete($sprin->file);
            }
            
            $file = $request->file('file');
            $path = $file->store('surat-perintah', 'public');
            $validated['file'] = $path;
        }

        $sprin->update($validated);

        return redirect()->route('sprin.index')
            ->with('success', 'Surat Perintah berhasil diperbarui');
    }

    /**
     * Remove the specified sprin from storage.
     *
     * @param  \App\Models\SuratPerintah  $sprin
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(SuratPerintah $sprin)
    {
        // Delete file if exists
        if ($sprin->file) {
            Storage::disk('public')->delete($sprin->file);
        }
        
        $sprin->delete();

        return redirect()->route('sprin.index')
            ->with('success', 'Surat Perintah berhasil dihapus');
    }
}