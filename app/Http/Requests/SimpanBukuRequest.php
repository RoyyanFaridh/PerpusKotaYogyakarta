<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SimpanBukuRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'judul'         => 'required|string|max:255',
            'pengarang'     => 'required|string|max:255',
            'penerbit'      => 'nullable|string|max:255',
            'isbn'          => 'nullable|string|unique:bukus,isbn,' . $this->route('buku'),
            'tahun_terbit'  => 'nullable|integer|min:1900|max:' . date('Y'),
            'tempat_terbit' => 'nullable|string|max:255',
            'resume'        => 'nullable|string',
            'stok'          => 'required|integer|min:0',
            'kategori'      => 'nullable|string|max:255',
            'sumber'        => 'required|in:perpus,tukar',
            'kondisi'       => 'nullable|in:baik,cukup,rusak',
            'deskripsi'     => 'nullable|string',
            'lokasi_id'     => 'nullable|exists:lokasis,id',
        ];
    }

    public function messages(): array
    {
        return [
            'judul.required'        => 'Judul buku wajib diisi',
            'pengarang.required'    => 'Pengarang wajib diisi',
            'isbn.unique'           => 'ISBN sudah terdaftar',
            'tahun_terbit.integer'  => 'Tahun terbit harus berupa angka',
            'tahun_terbit.min'      => 'Tahun terbit tidak valid',
            'tahun_terbit.max'      => 'Tahun terbit tidak boleh melebihi tahun sekarang',
            'stok.required'         => 'Stok wajib diisi',
            'stok.min'              => 'Stok tidak boleh negatif',
            'sumber.required'       => 'Sumber buku wajib diisi',
            'sumber.in'             => 'Sumber harus perpus atau tukar',
            'kondisi.in'            => 'Kondisi harus baik, cukup, atau rusak',
            'lokasi_id.exists'      => 'Lokasi tidak ditemukan',
        ];
    }

    public function attributes(): array
    {
        return [
            'judul'         => 'Judul Buku',
            'pengarang'     => 'Pengarang',
            'penerbit'      => 'Penerbit',
            'isbn'          => 'ISBN',
            'tahun_terbit'  => 'Tahun Terbit',
            'tempat_terbit' => 'Tempat Terbit',
            'stok'          => 'Stok',
            'kategori'      => 'Kategori',
            'sumber'        => 'Sumber',
            'kondisi'       => 'Kondisi',
            'lokasi_id'     => 'Lokasi',
        ];
    }
}