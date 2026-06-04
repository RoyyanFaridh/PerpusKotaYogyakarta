@props(['eksemplar'])

@php
$buku           = $eksemplar->buku;
$categoryColorMap = [
    'Umum/Komputer'        => 'bg-primary-50 text-primary-700',
    'Filsafat & Psikologi' => 'bg-warning-50 text-warning-700',
    'Agama'                => 'bg-danger-50 text-danger-700',
    'Ilmu Sosial'          => 'bg-success-50 text-success-700',
    'Bahasa'               => 'bg-primary-50 text-primary-800',
    'Sains & Matematika'   => 'bg-success-50 text-success-800',
    'Teknologi'            => 'bg-neutral-100 text-neutral-600',
    'Seni & Rekreasi'      => 'bg-warning-50 text-warning-800',
    'Literatur & Sastra'   => 'bg-neutral-100 text-neutral-500',
    'Geografi & Sejarah'   => 'bg-primary-50 text-primary-600',
];
$catClass = $categoryColorMap[$buku->kategori ?? ''] ?? 'bg-neutral-100 text-neutral-500';
@endphp

<tr class="hover:bg-neutral-50 transition-colors">

    {{-- Judul --}}
    <td class="px-5 py-3">
        <p class="text-xs font-semibold text-neutral-800 leading-snug line-clamp-2">{{ $buku->judul }}</p>
        <p class="text-xs text-neutral-400 mt-0.5">{{ $buku->pengarang }}
            @if ($buku->tahun_terbit)
                · {{ $buku->tahun_terbit }}
            @endif
        </p>
    </td>

    {{-- ISBN --}}
    <td class="px-4 py-3 text-center">
        <span class="text-xs font-mono text-neutral-500">{{ $buku->isbn ?? '—' }}</span>
    </td>

    {{-- Kategori --}}
    <td class="px-4 py-3 text-center">
        @if ($buku->kategori)
            <span class="text-xs font-medium px-2 py-0.5 rounded-full {{ $catClass }}">
                {{ $buku->kategori }}
            </span>
        @else
            <span class="text-xs text-neutral-400">—</span>
        @endif
    </td>

    {{-- Stok --}}
    <td class="px-4 py-3 text-center">
        @if ($eksemplar->stok > 0)
            <span class="text-xs font-medium px-2 py-0.5 rounded-full bg-success-50 text-success-700">
                {{ $eksemplar->stok }} tersedia
            </span>
        @else
            <span class="text-xs font-medium px-2 py-0.5 rounded-full bg-danger-50 text-danger-700">
                Habis
            </span>
        @endif
    </td>

    <td class="px-4 py-3 text-center">
        @if ($eksemplar->paket?->is_aktif)
            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium bg-success-50 text-success-700">
                Tampil
            </span>
        @else
            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium bg-neutral-100 text-neutral-500">
                Tersembunyi
            </span>
        @endif
    </td>

    {{-- Aksi --}}
    <td class="px-4 py-3 text-center">
        <div class="flex items-center justify-center gap-1.5">
            <button type="button"
                onclick="bukaModalEditBuku({{ json_encode([
                    'id'            => $buku->id,
                    'judul'         => $buku->judul,
                    'pengarang'     => $buku->pengarang,
                    'penerbit'      => $buku->penerbit,
                    'isbn'          => $buku->isbn,
                    'tahun_terbit'  => $buku->tahun_terbit,
                    'tempat_terbit' => $buku->tempat_terbit,
                    'resume'        => $buku->resume,
                    'kategori'      => $buku->kategori,
                    'deskripsi'     => $buku->deskripsi,
                    'is_visible'    => $buku->is_visible,
                    'cover'         => $buku->cover,
                    'eksemplar_id'  => $eksemplar->id,
                    'stok'          => $eksemplar->stok,
                    'paket_id'      => $eksemplar->paket_id,
                ]) }})"
                class="flex items-center gap-1 px-2.5 py-1.5 rounded-lg text-xs font-medium text-neutral-500 border border-neutral-200 hover:border-warning-300 hover:text-warning-600 hover:bg-warning-50 transition-colors">
                <x-icons.edit/>
                <span>Edit</span>
            </button>
            <button type="button"
                onclick="bukaModalHapusBuku(
                    '{{ route('admin.buku.destroy', $buku) }}',
                    '{{ addslashes($buku->judul) }}'
                )"
                class="flex items-center gap-1 px-2.5 py-1.5 rounded-lg text-xs font-medium text-neutral-500 border border-neutral-200 hover:border-danger-300 hover:text-danger-600 hover:bg-danger-50 transition-colors">
                <x-icons.delete/>
                <span>Hapus</span>
            </button>
        </div>
    </td>

</tr>