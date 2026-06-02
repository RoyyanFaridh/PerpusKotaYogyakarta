<?php

namespace App\Services;

use App\Models\Buku;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class BukuService
{
    public function getAll(array $filters = []): LengthAwarePaginator
    {
        return $this->buildQuery($filters)->paginate(15);
    }

    public function find(int $id): Buku
    {
        return Buku::findOrFail($id);
    }

    public function store(array $data): Buku
    {
        if (isset($data['cover']) && $data['cover'] instanceof UploadedFile) {
            $data['cover'] = $data['cover']->store('covers', 'public');
        }

        return Buku::create($data);
    }

    public function update(int $id, array $data): Buku
    {
        $buku = $this->find($id);

        if (isset($data['cover']) && $data['cover'] instanceof UploadedFile) {
            // Hapus cover lama jika ada
            if ($buku->cover) {
                Storage::disk('public')->delete($buku->cover);
            }
            $data['cover'] = $data['cover']->store('covers', 'public');
        } else {
            // Jika tidak ada file baru, jangan overwrite cover lama
            unset($data['cover']);
        }

        $buku->update($data);
        return $buku->fresh();
    }

    public function delete(int $id): bool
    {
        $buku = $this->find($id);

        // Hapus cover saat buku dihapus
        if ($buku->cover) {
            Storage::disk('public')->delete($buku->cover);
        }

        return $buku->delete();
    }

    public function cariByIsbn(string $isbn): ?Buku
    {
        return Buku::where('isbn', $isbn)->first();
    }

    private function buildQuery(array $filters = [])
    {
        $query = Buku::with(['lokasi', 'member', 'paket'])->latest();

        if (! empty($filters['search'])) {
            $query->cari($filters['search']);
        }

        if (! empty($filters['kategori'])) {
            $query->where('kategori', $filters['kategori']);
        }

        if (! empty($filters['lokasi'])) {
            $query->where('lokasi_id', $filters['lokasi']);
        }

        if (! empty($filters['paket'])) {
            if ($filters['paket'] === 'tanpa_paket') {
                $query->whereNull('paket_id');   // ← ganti ini
            } else {
                $query->where('paket_id', $filters['paket']);
            }
        }

        if (isset($filters['visibility'])) {
            match ($filters['visibility']) {
                'visible' => $query->visible(),
                'hidden'  => $query->where(function ($q) {
                    $q->whereNull('paket_id')->where('is_visible', false)
                    ->orWhereHas('paket', fn($p) => $p->where('is_aktif', false));
                }),
                default   => null,
            };
        }

        return $query;
    }
}