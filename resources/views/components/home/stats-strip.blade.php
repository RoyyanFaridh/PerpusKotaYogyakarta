<div class="relative z-10 flex flex-wrap justify-center border-t border-b border-primary-100 bg-primary-100/50">
    <div class="flex-1 min-w-40 bg-white px-8 py-7 text-center transition-colors duration-200 border-r border-primary-100 hover:bg-primary-50">
        <div class="font-extrabold text-[2.1rem] text-primary">{{ number_format($totalBuku ?? 1240) }}</div>
        <div class="text-[0.78rem] font-medium tracking-[0.08em] uppercase text-neutral-500 mt-1">Koleksi Buku</div>
    </div>
    <div class="flex-1 min-w-40 bg-white px-8 py-7 text-center transition-colors duration-200 border-r border-primary-100 hover:bg-primary-50">
        <div class="font-extrabold text-[2.1rem] text-primary">{{ number_format($totalAnggota ?? 380) }}</div>
        <div class="text-[0.78rem] font-medium tracking-[0.08em] uppercase text-neutral-500 mt-1">Anggota Aktif</div>
    </div>
    <div class="flex-1 min-w-40 bg-white px-8 py-7 text-center transition-colors duration-200 hover:bg-primary-50">
        <div class="font-extrabold text-[2.1rem] text-primary">{{ number_format($totalTukar ?? 2100) }}</div>
        <div class="text-[0.78rem] font-medium tracking-[0.08em] uppercase text-neutral-500 mt-1">Penukaran Berhasil</div>
    </div>
</div>