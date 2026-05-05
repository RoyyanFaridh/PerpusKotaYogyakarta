<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SimpanBukuPerpusRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'judul' => 'required|string|max:255',
            'penulis' => 'required|string|max:255',
            'tahun' => 'required|integer|min:1900|max:' . date('Y'),
        ];
    }

    public function messages(): array
    {
        return [
            'judul.required' => 'Judul buku wajib diisi',
            'penulis.required' => 'Penulis wajib diisi',
            'tahun.required' => 'Tahun wajib diisi',
            'tahun.integer' => 'Tahun harus berupa angka',
            'tahun.min' => 'Tahun tidak valid',
            'tahun.max' => 'Tahun tidak boleh melebihi tahun sekarang',
        ];
    }

    public function attributes(): array
    {
        return [
            'judul' => 'Judul Buku',
            'penulis' => 'Penulis',
            'tahun' => 'Tahun Terbit',
        ];
    }
}