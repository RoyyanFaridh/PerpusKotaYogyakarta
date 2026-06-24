{{--
    Partial: Filter Tahun & Bulan untuk halaman Statistik.
    Variabel yang dibutuhkan dari view pemanggil:
    - $tahun (int)        : tahun terpilih
    - $bulan (?int)       : bulan terpilih, null = semua
    - $tahunOptions (arr) : daftar tahun untuk dropdown
    - $routeName (string) : nama route saat ini (untuk action form), misal 'admin.statistik.transaksi'
--}}
<form method="GET" action="{{ route($routeName) }}" class="flex flex-wrap items-end gap-3">

    <div class="flex flex-col gap-1">
        <label for="tahun" class="text-xs font-medium text-neutral-600">Tahun</label>
        <select id="tahun" name="tahun"
                onchange="this.form.submit()"
                class="rounded-lg border border-neutral-200 text-sm px-3 py-2 bg-white text-neutral-700 focus:outline-none focus:ring-2 focus:ring-primary-200 focus:border-primary-300">
            @foreach($tahunOptions as $opt)
                <option value="{{ $opt }}" @selected($opt === $tahun)>{{ $opt }}</option>
            @endforeach
        </select>
    </div>

    <div class="flex flex-col gap-1">
        <label for="bulan" class="text-xs font-medium text-neutral-600">Bulan</label>
        <select id="bulan" name="bulan"
                onchange="this.form.submit()"
                class="rounded-lg border border-neutral-200 text-sm px-3 py-2 bg-white text-neutral-700 focus:outline-none focus:ring-2 focus:ring-primary-200 focus:border-primary-300">
            <option value="semua" @selected($bulan === null)>Semua Bulan</option>
            @foreach([
                1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
                5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
                9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember',
            ] as $num => $label)
                <option value="{{ $num }}" @selected($bulan === $num)>{{ $label }}</option>
            @endforeach
        </select>
    </div>

    <noscript>
        <button type="submit" class="rounded-lg bg-primary text-white text-sm font-medium px-4 py-2 hover:bg-primary-600 transition-colors">
            Terapkan
        </button>
    </noscript>
</form>