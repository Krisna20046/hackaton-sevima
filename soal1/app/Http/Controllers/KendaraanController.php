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
        
        // $kendaraan = Kendaraan::whereRaw("LOWER(merk) LIKE ?", ["%{$query}%"])
        //     ->orWhereRaw("LOWER(tipe) LIKE ?", ["%{$query}%"])
        //     ->orWhereRaw("LOWER(transmisi) LIKE ?", ["%{$query}%"])
        //     ->orWhereRaw("LOWER(warna) LIKE ?", ["%{$query}%"])
        //     ->orWhereRaw("LOWER(jenis_bahan_bakar) LIKE ?", ["%{$query}%"])
        //     ->paginate(5);

        try {
            $kendaraan = DB::table('kendaraans')
                ->select('kendaraans.*')
                ->selectRaw('ts_rank(searchable_text, plainto_tsquery(?)) AS relevance', [$query])
                ->whereRaw("searchable_text @@ plainto_tsquery(?)", [$query])
                ->orderBy('relevance', 'desc')
                ->paginate(5);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Invalid query'], 400);
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
