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

    public function getPerpus(array $filters = []): LengthAwarePaginator
    {
        return $this->buildQuery($filters)->perpus()->paginate(15);
    }

    public function getTukar(array $filters = []): LengthAwarePaginator
    {
        return $this->buildQuery($filters)->tukar()->paginate(15);
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
        $query = Buku::with(['lokasi', 'member'])->latest();

        if (! empty($filters['search'])) {
            $query->cari($filters['search']);
        }

        if (! empty($filters['kategori'])) {
            $query->where('kategori', $filters['kategori']);
        }

        if (! empty($filters['kondisi'])) {
            $query->where('kondisi', $filters['kondisi']);
        }

        if (! empty($filters['lokasi'])) {
            $query->where('lokasi_id', $filters['lokasi']);
        }

        return $query;
    }
}