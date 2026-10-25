<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Tampilkan halaman pengaturan surat dan identitas lembaga
     */
    public function index()
    {
        $settings = Setting::getAll();
        return view('settings.index', compact('settings'));
    }

    /**
     * Simpan pembaruan pengaturan
     */
    public function update(Request $request)
    {
        $request->validate([
            'nama_yayasan'           => 'required|string|max:255',
            'alamat_yayasan'         => 'nullable|string|max:255',
            'ketua_yayasan'          => 'required|string|max:255',
            'kepala_tpq'             => 'required|string|max:255',
            'kepala_rtq'             => 'required|string|max:255',
            'tanggal_surat_masehi'   => 'required|string|max:100',
            'tanggal_surat_hijriyah' => 'required|string|max:100',
            'nomor_sk_munaqasyah'    => 'nullable|string|max:150',
            'tahun_ajaran'           => 'nullable|string|max:50',
        ]);

        $keys = [
            'nama_yayasan',
            'alamat_yayasan',
            'ketua_yayasan',
            'kepala_tpq',
            'kepala_rtq',
            'tanggal_surat_masehi',
            'tanggal_surat_hijriyah',
            'nomor_sk_munaqasyah',
            'tahun_ajaran',
        ];

        foreach ($keys as $key) {
            Setting::set($key, $request->input($key));
        }

        return redirect()->route('settings.index')->with('success', 'Pengaturan surat kelulusan & identitas lembaga berhasil disimpan.');
    }

    /**
     * Download cadangan database (JSON format)
     */
    public function backup()
    {
        $backupData = [
            'meta' => [
                'aplikasi'          => 'Database Sekolah Ar-Raudhah',
                'pengembang'        => 'Yayasan Cahaya Amanah Ar-Raudhah',
                'tanggal_backup'    => now()->format('Y-m-d H:i:s'),
                'total_santri'      => \App\Models\Santri::count(),
                'total_penilaian'   => \App\Models\Penilaian::count(),
            ],
            'settings'   => \App\Models\Setting::all(),
            'units'      => \App\Models\Unit::all(),
            'santris'    => \App\Models\Santri::with('penilaian')->get(),
        ];

        $filename = 'backup_munaqasyah_arraudhah_' . now()->format('Y_m_d_His') . '.json';
        $json = json_encode($backupData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

        return response($json, 200, [
            'Content-Type'        => 'application/json',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }
}
