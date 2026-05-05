<?php

namespace App\Services;

use App\Models\BukuPerpus;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class BookPerpusService
{
    public function getAll(): LengthAwarePaginator
    {
        return BukuPerpus::query()
            ->latest()
            ->paginate(10);
    }

    public function store(array $data): BukuPerpus
    {
        return BukuPerpus::create($data);
    }

    public function find(int $id): BukuPerpus
    {
        return BukuPerpus::findOrFail($id);
    }

    public function update(int $id, array $data): BukuPerpus
    {
        $book = $this->find($id);
        $book->update($data);

        return $book->fresh(); // ambil data terbaru
    }

    public function delete(int $id): bool
    {
        $book = $this->find($id);
        return $book->delete();
    }
}