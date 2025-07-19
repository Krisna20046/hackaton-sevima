<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KendaraanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Kendaraan::insert([
            ['merk' => 'Toyota', 'tipe' => 'SUV', 'transmisi' => 'Automatic', 'warna' => 'Black', 'tanggal_pembuatan' => '2022-01-15', 'jenis_bahan_bakar' => 'Gasoline'],
            ['merk' => 'Honda', 'tipe' => 'Sedan', 'transmisi' => 'Manual', 'warna' => 'White', 'tanggal_pembuatan' => '2021-05-23', 'jenis_bahan_bakar' => 'Diesel'],
            ['merk' => 'Ford', 'tipe' => 'Truck', 'transmisi' => 'Automatic', 'warna' => 'Blue', 'tanggal_pembuatan' => '2020-11-30', 'jenis_bahan_bakar' => 'Gasoline'],
            ['merk' => 'Chevrolet', 'tipe' => 'Coupe', 'transmisi' => 'Manual', 'warna' => 'Red', 'tanggal_pembuatan' => '2019-07-19', 'jenis_bahan_bakar' => 'Gasoline'],
            ['merk' => 'Nissan', 'tipe' => 'Hatchback', 'transmisi' => 'Automatic', 'warna' => 'Silver', 'tanggal_pembuatan' => '2023-03-10', 'jenis_bahan_bakar' => 'Electric'],
            ['merk' => 'BMW', 'tipe' => 'Convertible', 'transmisi' => 'Manual', 'warna' => 'Green', 'tanggal_pembuatan' => '2022-12-05', 'jenis_bahan_bakar' => 'Hybrid'],
            ['merk' => 'Audi', 'tipe' => 'SUV', 'transmisi' => 'Automatic', 'warna' => 'Black', 'tanggal_pembuatan' => '2021-08-20', 'jenis_bahan_bakar' => 'Gasoline'],
            ['merk' => 'Mercedes-Benz', 'tipe' => 'Sedan', 'transmisi' => 'Manual', 'warna' => 'White', 'tanggal_pembuatan' => '2020-02-15', 'jenis_bahan_bakar' => 'Diesel'],
            ['merk' => 'Yamaha', 'tipe' => 'Motorcycle', 'transmisi' => 'Manual', 'warna' => 'Blue', 'tanggal_pembuatan' => '2023-06-25', 'jenis_bahan_bakar' => 'Gasoline'],
            ['merk' => 'Kawasaki', 'tipe' => 'Motorcycle', 'transmisi' => 'Automatic', 'warna' => 'Red', 'tanggal_pembuatan' => '2022-09-30', 'jenis_bahan_bakar' => 'Gasoline'],
            ['merk' => 'Suzuki', 'tipe' => 'Motorcycle', 'transmisi' => 'Manual', 'warna' => 'Silver', 'tanggal_pembuatan' => '2021-04-10', 'jenis_bahan_bakar' => 'Electric'],
        ]);
    }
}
