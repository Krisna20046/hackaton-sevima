@extends('layouts.app')

@section('title', 'Hackaton - Kendaraan')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-3xl font-bold mb-4">List Kendaraan</h1>
    <div class="flex items-center mb-4">
        <input type="text" id="search" class="w-full px-4 py-2 rounded-lg border border-gray-300" placeholder="Cari">
    </div>
    <table class="table-auto w-full mb-4">
        <thead>
            <tr class="bg-gray-200">
                <th class="px-4 py-2">Merk</th>
                <th class="px-4 py-2">Tipe</th>
                <th class="px-4 py-2">Transmisi</th>
                <th class="px-4 py-2">Warna</th>
                <th class="px-4 py-2">Tanggal Pembuatan</th>
                <th class="px-4 py-2">Jenis Bahan Bakar</th>
            </tr>
        </thead>
        <tbody id="kendaraan-list">
        </tbody>
    </table>
    <div class="flex justify-center" id="pagination">
    </div>
</div>

<script>
const searchInput = document.getElementById('search');
let searchTimeout = null;

searchInput.addEventListener('input', function() {
    if (searchTimeout) {
        clearTimeout(searchTimeout);
    }

    searchTimeout = setTimeout(function() {
        const query = searchInput.value;
        fetchKendaraan(query);
    }, 500);
});

function fetchKendaraan(query = '', page = 1) {
    const formData = new FormData();
    formData.append('search', query);
    formData.append('page', page);

    fetch('/api/kendaraan', {
        method: 'POST',
        body: formData
    })
        .then(response => response.json())
        .then(data => {
            const kendaraanList = document.getElementById('kendaraan-list');
            kendaraanList.innerHTML = '';

            data.data.forEach(kendaraan => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td class="px-4 py-2">${kendaraan.merk}</td>
                    <td class="px-4 py-2">${kendaraan.tipe}</td>
                    <td class="px-4 py-2">${kendaraan.transmisi}</td>
                    <td class="px-4 py-2">${kendaraan.warna}</td>
                    <td class="px-4 py-2">${kendaraan.tanggal_pembuatan}</td>
                    <td class="px-4 py-2">${kendaraan.jenis_bahan_bakar}</td>
                `;
                kendaraanList.appendChild(row);
            });

            const pagination = document.getElementById('pagination');
            pagination.innerHTML = '';

            if (data.current_page > 1) {
                const prevButton = document.createElement('button');
                prevButton.innerHTML = 'Previous';
                prevButton.addEventListener('click', function() {
                    fetchKendaraan(query, data.current_page - 1);
                });
                pagination.appendChild(prevButton);
            }

            if (data.current_page < data.last_page) {
                const nextButton = document.createElement('button');
                nextButton.innerHTML = 'Next';
                nextButton.addEventListener('click', function() {
                    fetchKendaraan(query, data.current_page + 1);
                });
                pagination.appendChild(nextButton);
            }
        });
}

fetchKendaraan();
</script>
@endsection

