<?php

namespace App\Services;

use App\Models\Buku;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

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
        return Buku::create($data);
    }

    public function update(int $id, array $data): Buku
    {
        $buku = $this->find($id);
        $buku->update($data);
        return $buku->fresh();
    }

    public function delete(int $id): bool
    {
        return $this->find($id)->delete();
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
            $query->where('paket_id', $filters['paket']);
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