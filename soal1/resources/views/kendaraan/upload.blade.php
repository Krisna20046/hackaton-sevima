@extends('layouts.app')

@section('title', 'Hackaton - Upload')

@section('content')
<div class="container mx-auto p-4">
    <form action="{{ route('kendaraan.upload') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-4">
            <label for="file" class="block text-gray-700 text-sm font-bold mb-2">Upload file:</label>
            <input type="file" name="file" id="file" class="px-4 py-2 border border-gray-300 rounded-lg">
            @error('file')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>
        <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-lg">Upload</button>
    </form>
</div>
@endsection

