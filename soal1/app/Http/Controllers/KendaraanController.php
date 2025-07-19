<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kendaraan;
use Illuminate\Support\Facades\DB;

class KendaraanController extends Controller
{
    public function index()
    {
        return view('kendaraan.index');
    }
    public function data_kendaraan(Request $request)
    {
        $query = strtolower($request->input('search', ''));
        if (empty($query)) {
            $kendaraan = Kendaraan::paginate(5);
            return response()->json($kendaraan);
        }

        try {
            // $kendaraan = DB::table('kendaraans')
            //     ->select('kendaraans.*')
            //     ->orderByRaw("
            //         CASE
            //             WHEN LOWER(merk) LIKE ? THEN 1
            //             WHEN LOWER(tipe) LIKE ? THEN 2
            //             WHEN LOWER(transmisi) LIKE ? THEN 3
            //             WHEN LOWER(warna) LIKE ? THEN 4
            //             WHEN LOWER(jenis_bahan_bakar) LIKE ? THEN 5
            //             ELSE 6
            //         END", ["%{$query}%", "%{$query}%", "%{$query}%", "%{$query}%", "%{$query}%"])
            //     ->paginate(5);

            $kendaraan = Kendaraan::whereRaw("LOWER(merk) LIKE ?", ["%{$query}%"])
                ->orWhereRaw("LOWER(tipe) LIKE ?", ["%{$query}%"])
                ->orWhereRaw("LOWER(transmisi) LIKE ?", ["%{$query}%"])
                ->orWhereRaw("LOWER(warna) LIKE ?", ["%{$query}%"])
                ->orWhereRaw("LOWER(jenis_bahan_bakar) LIKE ?", ["%{$query}%"])
                ->paginate(5);
            } catch (\Exception $e) {
                return response()->json(['error' => 'Invalid query'], 400);
        }

        return response()->json($kendaraan);
    }

    public function kendaraan_detail($id)
    {
        $kendaraan = Kendaraan::find($id);
        if (!$kendaraan) {
            return response()->json(['error' => 'Kendaraan not found'], 404);
        }
        return response()->json($kendaraan);
    }

    public function upload_index()
    {
        return view('kendaraan.upload');
    }

    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required',
        ]);

        $file = $request->file('file');
        $filename = $file->getClientOriginalName();
        $file->storeAs('public/md', $filename);

        $fileContent = file_get_contents(storage_path('app/public/md/' . $filename));
        $lines = explode("\n", $fileContent);
        $kendaraans = [];
        foreach ($lines as $line) {
            if (strpos($line, '|') !== false) {
                $kendaraan = explode('|', $line);
                $kendaraans[] = [
                    'merk' => trim($kendaraan[0]),
                    'tipe' => trim($kendaraan[1]),
                    'transmisi' => trim($kendaraan[2]),
                    'warna' => trim($kendaraan[3]),
                    'tanggal_pembuatan' => trim($kendaraan[4]),
                    'jenis_bahan_bakar' => trim($kendaraan[5]),
                ];
            }
        }
        Kendaraan::insert($kendaraans);
        return redirect()->route('kendaraan.index')->with('success', 'Data berhasil diupload');
    }
}
