<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfilController extends Controller
{
    public function edit()
    {
        $profile = \App\Models\Profil::firstOrCreate([], [
            'visi' => '',
            'misi' => '',
            'sejarah' => '',
        ]);
        return view('admin.profile.edit', compact('profile'));
    }

    public function update(Request $request)
    {
        $profile = \App\Models\Profil::firstOrCreate([], [
            'visi' => '',
            'misi' => '',
            'sejarah' => '',
        ]);

        $request->validate([
            'visi' => 'required|string',
            'misi' => 'required|string',
            'sejarah' => 'nullable|string',
            'alamat' => 'nullable|string|max:255',
            'telepon' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:2048', // max 2MB
            'struktur_organisasi' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:5120', // max 5MB
        ]);

        $data = $request->except(['logo', 'struktur_organisasi']);

        // Handle logo upload
        if ($request->hasFile('logo')) {
            // Delete old logo
            if ($profile->logo && file_exists(public_path($profile->logo))) {
                @unlink(public_path($profile->logo));
            }
            
            $file = $request->file('logo');
            $filename = 'logo_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/profile'), $filename);
            $data['logo'] = 'uploads/profile/' . $filename;
        }

        // Handle organization structure upload
        if ($request->hasFile('struktur_organisasi')) {
            // Delete old structure image
            if ($profile->struktur_organisasi && file_exists(public_path($profile->struktur_organisasi))) {
                @unlink(public_path($profile->struktur_organisasi));
            }
            
            $file = $request->file('struktur_organisasi');
            $filename = 'struktur_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/profile'), $filename);
            $data['struktur_organisasi'] = 'uploads/profile/' . $filename;
        }

        $profile->update($data);

        return redirect()->route('admin.profile.edit')->with('success', 'Profil DPRD Bolmut berhasil diperbarui.');
    }
}
