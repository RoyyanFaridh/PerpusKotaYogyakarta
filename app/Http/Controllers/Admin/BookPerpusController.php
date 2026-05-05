<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\BookPerpusService;
use Illuminate\Http\Request;

class BookPerpusController extends Controller
{
    protected BookPerpusService $service;

    public function __construct(BookPerpusService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $books = $this->service->getAll();
        return view('admin.buku-perpus.index', compact('books'));
    }

    public function create()
    {
        return view('admin.buku-perpus.create');
    }

    public function store(Request $request)
    {
        $this->service->store($request->all());

        return redirect()->route('admin.buku-perpus.index');
    }

    public function show(int $id)
    {
        $book = $this->service->find($id);
        return view('admin.buku-perpus.show', compact('book'));
    }

    public function edit(int $id)
    {
        $book = $this->service->find($id);
        return view('admin.buku-perpus.edit', compact('book'));
    }

    public function update(Request $request, int $id)
    {
        $this->service->update($id, $request->all());

        return redirect()->route('admin.buku-perpus.index');
    }

    public function destroy(int $id)
    {
        $this->service->delete($id);

        return redirect()->route('admin.buku-perpus.index');
    }
}