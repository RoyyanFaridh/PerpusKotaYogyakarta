<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SimpanBukuRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $bukuId = $this->route('buku');

        return [
            'judul'         => 'required|string|max:255',
            'pengarang'     => 'required|string|max:255',
            'penerbit'      => 'nullable|string|max:255',
            'isbn' => [
                'nullable',
                'string',
                Rule::unique('bukus', 'isbn')->ignore($bukuId),
            ],
            'tahun_terbit'  => 'nullable|integer|min:1900|max:' . date('Y'),
            'tempat_terbit' => 'nullable|string|max:255',
            'resume'        => 'nullable|string',
            'cover'         => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'kategori'      => 'nullable|string|max:255',
            'deskripsi'     => 'nullable|string',
            'is_visible'    => 'boolean',
            'eksemplar_id' => 'nullable|exists:buku_eksemplars,id',
            'paket_id'      => 'nullable|exists:pakets,id',
            'stok'          => 'required|integer|min:0',
        ];
    }

    public function messages(): array
    {
        return [
            'judul.required'       => 'Judul buku wajib diisi',
            'pengarang.required'   => 'Pengarang wajib diisi',
            'isbn.unique'          => 'ISBN sudah terdaftar',
            'tahun_terbit.integer' => 'Tahun terbit harus berupa angka',
            'tahun_terbit.min'     => 'Tahun terbit tidak valid',
            'tahun_terbit.max'     => 'Tahun terbit tidak boleh melebihi tahun sekarang',
            'stok.required'        => 'Stok wajib diisi',
            'stok.min'             => 'Stok tidak boleh negatif',
            'paket_id.exists'      => 'Paket tidak ditemukan',
            'cover.image'          => 'Cover harus berupa gambar',
            'cover.mimes'          => 'Format cover harus jpg, jpeg, png, atau webp',
            'cover.max'            => 'Ukuran cover maksimal 2MB',
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
            'paket_id'      => 'Paket',
            'is_visible'    => 'Visibilitas',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_visible' => $this->boolean('is_visible'),
        ]);
    }
}