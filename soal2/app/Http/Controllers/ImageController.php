<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Image as ImageModel;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    public function index()
    {
        return view('compressor.index');
    }

    public function compress(Request $request)
    {
        $request->validate([
            'image' => 'required|image'
        ]);

        $image = new ImageModel();
        $originalFile = $request->file('image');
        $image->old_origin_name = $originalFile->getClientOriginalName();
        $image->new_origin_name = 'compressed_' . $originalFile->getClientOriginalName();
        $image->old_name = $originalFile->hashName();
        $image->old_path = $originalFile->store('public/images/original');
        $image->old_size = $originalFile->getSize();

        $compressedImage = Image::make($originalFile)
            ->resize(800, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })
            ->encode('jpg', 75);

        $path = 'public/images/compressed/' . $image->new_origin_name;
        Storage::put($path, $compressedImage);
        $image->new_name = $image->new_origin_name;
        $image->new_path = $path;
        $image->new_size = Storage::size($path);
        $image->save();

        return response()->json([
            'message' => 'Image compressed and saved successfully',
            'data' => $image
        ]);
    }
}
