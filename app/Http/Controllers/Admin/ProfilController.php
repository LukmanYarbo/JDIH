<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Profil;
use Illuminate\Http\Request;

class ProfilController extends Controller
{
    public function edit()
    {
        $profile = Profil::firstOrCreate([], [
            'visi' => '',
            'misi' => '',
            'sejarah' => '',
        ]);
        return view('admin.profile.edit', compact('profile'));
    }

    public function update(Request $request)
    {
        $profile = Profil::firstOrCreate([], [
            'visi' => '',
            'misi' => '',
            'sejarah' => '',
        ]);

        $request->validate([
            'visi' => 'required|string',
            'misi' => 'required|string',
            'sejarah' => 'nullable|string',
            'dasar_hukum' => 'nullable|string',
            'sk_tim' => 'nullable|string',
            'sop' => 'nullable|string',
            'maklumat_pelayanan' => 'nullable|string',
            'jam_operasional' => 'nullable|string',
            'alamat' => 'nullable|string|max:255',
            'telepon' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'whatsapp' => 'nullable|string|max:50',
            'facebook' => 'nullable|string|max:255',
            'instagram' => 'nullable|string|max:255',
            'youtube' => 'nullable|string|max:255',
            'twitter' => 'nullable|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:2048',
            'banner_header' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:6144', // max 6MB
            'struktur_organisasi' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:5120',
        ]);

        $data = $request->except(['logo', 'banner_header', 'struktur_organisasi', 'remove_logo', 'remove_banner_header', 'remove_struktur_organisasi']);

        // Handle removal flags
        if ($request->has('remove_logo')) {
            if ($profile->logo && file_exists(public_path($profile->logo))) {
                @unlink(public_path($profile->logo));
            }
            $data['logo'] = null;
        }

        if ($request->has('remove_banner_header')) {
            if ($profile->banner_header && file_exists(public_path($profile->banner_header))) {
                @unlink(public_path($profile->banner_header));
            }
            $data['banner_header'] = null;
        }

        if ($request->has('remove_struktur_organisasi')) {
            if ($profile->struktur_organisasi && file_exists(public_path($profile->struktur_organisasi))) {
                @unlink(public_path($profile->struktur_organisasi));
            }
            $data['struktur_organisasi'] = null;
        }

        // Handle uploads
        if ($request->hasFile('logo')) {
            if ($profile->logo && file_exists(public_path($profile->logo))) {
                @unlink(public_path($profile->logo));
            }
            
            $file = $request->file('logo');
            $filename = 'logo_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/profile'), $filename);
            $data['logo'] = 'uploads/profile/' . $filename;
        }

        if ($request->hasFile('banner_header')) {
            if ($profile->banner_header && file_exists(public_path($profile->banner_header))) {
                @unlink(public_path($profile->banner_header));
            }
            
            $file = $request->file('banner_header');
            $filename = 'banner_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/profile'), $filename);
            $data['banner_header'] = 'uploads/profile/' . $filename;
        }

        if ($request->hasFile('struktur_organisasi')) {
            if ($profile->struktur_organisasi && file_exists(public_path($profile->struktur_organisasi))) {
                @unlink(public_path($profile->struktur_organisasi));
            }
            
            $file = $request->file('struktur_organisasi');
            $filename = 'struktur_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/profile'), $filename);
            $data['struktur_organisasi'] = 'uploads/profile/' . $filename;
        }

        $profile->update($data);

        return redirect()->route('admin.profile.edit')->with('success', 'Profil & Pengaturan JDIH DPRD berhasil diperbarui.');
    }

    public function removeImage($type)
    {
        $profile = Profil::first();
        if (!$profile) {
            return redirect()->back();
        }

        $validTypes = ['banner_header', 'struktur_organisasi', 'logo'];
        if (!in_array($type, $validTypes)) {
            return redirect()->back()->with('error', 'Tipe gambar tidak valid.');
        }

        if ($profile->$type && file_exists(public_path($profile->$type))) {
            @unlink(public_path($profile->$type));
        }

        $profile->update([$type => null]);

        $label = $type === 'banner_header' ? 'Banner header (dikembalikan ke default)' : ($type === 'struktur_organisasi' ? 'Bagan struktur organisasi' : 'Logo');

        return redirect()->route('admin.profile.edit')->with('success', "Gambar {$label} berhasil dikosongkan.");
    }
}
