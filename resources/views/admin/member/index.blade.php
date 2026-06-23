@extends('layouts.admin')
@section('title', 'Member')
@section('page-title', 'Member')
@section('page-subtitle', 'Kelola data member perpustakaan')

@push('scripts')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/id.js"></script>

    <script>
        (function initFilters() {
            const searchInput  = document.getElementById('searchInput');
            const resetFilter  = document.getElementById('resetFilter');

            const picker = flatpickr("#filterTanggalRange", {
                mode: "range",
                dateFormat: "d M Y",
                locale: "id",
                maxDate: "today",
                onChange: function(selectedDates) {
                    if (selectedDates.length === 2) {
                        const mulai = flatpickr.formatDate(selectedDates[0], "Y-m-d");
                        const akhir = flatpickr.formatDate(selectedDates[1], "Y-m-d");
                        const params = new URLSearchParams(window.location.search);
                        params.set('tanggal_mulai', mulai);
                        params.set('tanggal_akhir', akhir);
                        params.delete('page');
                        window.location.href = '?' + params.toString();
                    }
                }
            });

            const params = new URLSearchParams(window.location.search);
            const tanggalMulai = params.get('tanggal_mulai');
            const tanggalAkhir = params.get('tanggal_akhir');
            if (tanggalMulai && tanggalAkhir) {
                picker.setDate([new Date(tanggalMulai), new Date(tanggalAkhir)], false);
            }

            if (searchInput && params.get('search')) {
                searchInput.value = params.get('search');
            }

            let searchTimer;
            searchInput?.addEventListener('input', () => {
                clearTimeout(searchTimer);
                searchTimer = setTimeout(() => {
                    const params = new URLSearchParams(window.location.search);
                    const search = searchInput.value.trim();
                    search ? params.set('search', search) : params.delete('search');
                    params.delete('page');
                    window.location.href = '?' + params.toString();
                }, 400);
            });

            resetFilter?.addEventListener('click', () => {
                searchInput.value = '';
                picker.clear();
                window.location.href = window.location.pathname;
            });
        })();
    </script>

    {{-- Styling flatpickr sama persis dengan transaksi --}}
    <style>
        .flatpickr-calendar {
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.10);
            font-family: 'Poppins', sans-serif;
            padding: 0;
            overflow: hidden;
            width: 300px !important;
        }
        .flatpickr-months {
            background: white;
            padding: 12px 8px;
            border-bottom: 1px solid #f3f4f6;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .flatpickr-month {
            height: auto;
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: visible;
        }
        .flatpickr-current-month {
            font-size: 14px;
            font-weight: 600;
            color: #111827;
            padding: 0;
            position: static;
            width: auto;
            left: unset;
            transform: none;
            display: flex;
            align-items: center;
            gap: 2px;
        }
        .flatpickr-current-month .flatpickr-monthDropdown-months {
            font-size: 14px;
            font-weight: 600;
            color: #111827;
            background: transparent;
            border: none;
            padding: 2px 6px;
            cursor: pointer;
            border-radius: 4px;
            -webkit-appearance: none;
            appearance: none;
        }
        .flatpickr-current-month .flatpickr-monthDropdown-months:hover {
            background: #f3f4f6;
        }
        .flatpickr-current-month input.cur-year {
            font-size: 14px;
            font-weight: 600;
            color: #111827;
            background: transparent;
            border: none;
            padding: 2px 4px;
            border-radius: 4px;
            width: 52px;
            pointer-events: auto !important;
            cursor: text;
        }
        .flatpickr-current-month input.cur-year:hover,
        .flatpickr-current-month input.cur-year:focus {
            background: #f3f4f6;
            outline: none;
        }
        .flatpickr-current-month .numInputWrapper {
            display: flex;
            align-items: center;
        }
        .flatpickr-current-month .arrowUp,
        .flatpickr-current-month .arrowDown {
            display: block !important;
            opacity: 0.4;
            padding: 0 2px;
        }
        .flatpickr-current-month .arrowUp:hover,
        .flatpickr-current-month .arrowDown:hover {
            opacity: 1;
        }
        .flatpickr-prev-month,
        .flatpickr-next-month {
            position: static !important;
            width: 30px;
            height: 30px;
            display: flex !important;
            align-items: center;
            justify-content: center;
            padding: 0;
            margin: 0;
            border-radius: 6px;
            color: #6b7280;
            fill: #6b7280;
            transition: background 120ms;
            flex-shrink: 0;
        }
        .flatpickr-prev-month:hover,
        .flatpickr-next-month:hover {
            background: #f3f4f6;
            color: #111827;
            fill: #111827;
        }
        .flatpickr-prev-month svg,
        .flatpickr-next-month svg {
            width: 14px;
            height: 14px;
        }
        span.flatpickr-weekday {
            font-size: 11px;
            font-weight: 500;
            color: #9ca3af;
            text-transform: uppercase;
            letter-spacing: 0.4px;
        }
        .flatpickr-weekdays {
            background: white;
            padding: 8px 12px 4px;
        }
        .flatpickr-days {
            padding: 4px 12px 14px;
            border: none;
        }
        .dayContainer {
            padding: 0;
            min-width: unset;
            max-width: unset;
            width: 100%;
        }
        .flatpickr-day {
            font-size: 13px;
            font-weight: 400;
            color: #374151;
            height: 38px;
            line-height: 38px;
            max-width: 38px;
            border-radius: 8px;
            border: 1.5px solid transparent;
            margin: 2px;
            transition: background 120ms, color 120ms, border-color 120ms;
            flex-basis: calc(14.28% - 4px) !important;
        }
        .flatpickr-day:not(.disabled):not(.flatpickr-disabled):not(.prevMonthDay):not(.nextMonthDay):hover {
            background: #f3f4f6;
            border-color: #e5e7eb;
            color: #111827;
        }
        .flatpickr-day.prevMonthDay,
        .flatpickr-day.nextMonthDay {
            color: #d1d5db;
        }
        .flatpickr-day.today {
            border-color: #04448D;
            color: #04448D;
            font-weight: 600;
        }
        .flatpickr-day.selected,
        .flatpickr-day.startRange,
        .flatpickr-day.endRange {
            background: #04448D;
            border-color: #04448D;
            color: white;
            font-weight: 500;
        }
        .flatpickr-day.startRange {
            border-radius: 8px 0 0 8px;
        }
        .flatpickr-day.endRange {
            border-radius: 0 8px 8px 0;
        }
        .flatpickr-day.startRange.endRange {
            border-radius: 8px;
        }
        .flatpickr-day.today.selected,
        .flatpickr-day.today.startRange,
        .flatpickr-day.today.endRange {
            background: #04448D;
            border-color: #04448D;
            color: white;
        }
        .flatpickr-day.inRange {
            background: rgba(4, 68, 141, 0.08);
            border-color: transparent;
            color: #1e3a5f;
            border-radius: 0;
        }
        .flatpickr-day.flatpickr-disabled,
        .flatpickr-day.disabled {
            color: #e5e7eb;
            cursor: not-allowed;
        }
        .flatpickr-day.flatpickr-disabled:hover {
            background: transparent;
            border-color: transparent;
        }
        .flatpickr-day:focus {
            outline: 2px solid rgba(4, 68, 141, 0.4);
            outline-offset: 1px;
        }
        @media (prefers-reduced-motion: reduce) {
            .flatpickr-day,
            .flatpickr-prev-month,
            .flatpickr-next-month {
                transition: none;
            }
        }
    </style>
@endpush
@section('content')
<div class="flex flex-col gap-10">

    <div class="relative overflow-hidden rounded-xl bg-white border border-neutral-200">
        <div class="absolute top-0 left-0 right-0 h-0.5 bg-primary-400"></div>

        <div class="flex items-center justify-between gap-4 px-5 pt-5 pb-4 border-b border-neutral-100">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-primary-50 text-primary-700 flex items-center justify-center shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                        <circle cx="12" cy="7" r="4"/>
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-semibold text-neutral-800 leading-tight">Daftar Member</p>
                    <p class="text-xs text-neutral-400 leading-tight">{{ $members->total() }} member terdaftar</p>
                </div>
            </div>
            <div class="flex items-center gap-2 shrink-0">
                <a href="{{ route('admin.member.export') }}"
                title="Export Excel"
                class="flex items-center gap-1.5 px-2.5 py-2 sm:px-3.5 rounded-lg text-xs font-medium text-neutral-600 border border-neutral-200 hover:bg-neutral-50 transition-colors">
                    <svg class="w-3.5 h-3.5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                        <polyline points="7 10 12 15 17 10"/>
                        <line x1="12" y1="15" x2="12" y2="3"/>
                    </svg>
                    <span class="hidden sm:inline">Export Excel</span>
                </a>
                <button type="button"
                        onclick="bukaModalMember()"
                        title="Tambah Member"
                        class="flex items-center gap-1.5 px-2.5 py-2 sm:px-3.5 rounded-lg text-xs font-semibold text-white bg-primary-600 hover:bg-primary-700 transition-colors">
                    <svg class="w-3.5 h-3.5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
                    </svg>
                    <span class="hidden sm:inline">Tambah Member</span>
                </button>
            </div>
        </div>

        <div class="grid grid-cols-1 border-b border-neutral-100">
            <div class="px-5 py-3.5 flex flex-col gap-0.5">
                <span class="text-xs text-neutral-400 font-medium">Total Member</span>
                <span class="text-2xl font-semibold tabular-nums text-neutral-800">{{ $totalMember }}</span>
            </div>
        </div>

        <div class="flex items-center gap-3 px-5 py-3.5">
                <div class="relative flex-1">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-neutral-400 pointer-events-none"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                    </svg>
                    <input id="searchInput" type="text"
                        placeholder="Cari nama atau nomor telepon..."
                        class="w-full pl-9 pr-4 py-2 text-sm text-neutral-700 bg-neutral-50 border border-neutral-200 rounded-lg placeholder-neutral-400 focus:outline-none focus:ring-2 focus:ring-primary-200 focus:border-primary-400 transition"/>
                </div>
                <input type="text"
                    id="filterTanggalRange"
                    class="px-3 py-2 text-sm text-neutral-600 bg-neutral-50 border border-neutral-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-200 focus:border-primary-400 transition whitespace-nowrap"
                    placeholder="Pilih rentang waktu">
                <button id="resetFilter"
                        class="px-3 py-2 text-xs text-neutral-500 hover:text-neutral-700 transition shrink-0">
                    Reset
                </button>
            </div>
        </div>
    </div>

    @if (session('success'))
        <div class="flex items-center gap-2.5 px-5 py-3 bg-success-50 border border-success-100 rounded-xl text-success-700 text-sm font-medium">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="flex items-center gap-2.5 px-5 py-3 bg-danger-50 border border-danger-100 rounded-xl text-danger-700 text-sm font-medium">
            {{ session('error') }}
        </div>
    @endif

    <div class="relative overflow-hidden rounded-xl bg-white border border-neutral-200 my-4">
        <div class="absolute top-0 left-0 right-0 h-0.5 bg-primary-400"></div>

        <div class="overflow-x-auto custom-scroll">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-neutral-100 bg-neutral-50">
                        <th class="text-left   text-xs font-semibold text-neutral-500 px-5 py-3">Nama</th>
                        <th class="text-left   text-xs font-semibold text-neutral-500 px-4 py-3">Email</th>
                        <th class="text-center text-xs font-semibold text-neutral-500 px-4 py-3">No. Telepon</th>
                        <th class="text-left   text-xs font-semibold text-neutral-500 px-4 py-3">Alamat</th>
                        <th class="text-center text-xs font-semibold text-neutral-500 px-4 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-neutral-100">
                    @forelse ($members as $member)
                        <tr class="hover:bg-neutral-50 transition-colors">
                            <td class="px-5 py-3.5">
                                <p class="text-xs font-semibold text-neutral-800">{{ $member->nama }}</p>
                            </td>
                            <td class="px-4 py-3.5 text-xs text-neutral-500">
                                {{ $member->email ?? '—' }}
                            </td>
                            <td class="px-4 py-3.5 text-center">
                                <span class="text-xs font-mono font-semibold text-neutral-800">{{ $member->no_telp }}</span>
                            </td>
                            <td class="px-4 py-3.5 max-w-xs">
                                <p class="text-xs text-neutral-500 whitespace-normal leading-relaxed">
                                    {{ $member->alamat ?? '—' }}
                                </p>
                            </td>
                            <td class="px-4 py-3.5">
                                <div class="flex items-center justify-center gap-1.5">
                                    <button type="button"
                                            onclick="bukaModalEdit({{ json_encode([
                                                'id'      => $member->id,
                                                'no_telp' => $member->no_telp,
                                                'nama'    => $member->nama,
                                                'email'   => $member->email,
                                                'alamat'  => $member->alamat,
                                            ]) }})"
                                            class="flex items-center gap-1.5 px-2.5 py-1.5 rounded-lg text-xs font-medium text-neutral-500 border border-neutral-200 hover:border-warning-300 hover:text-warning-600 hover:bg-warning-50 transition-colors">
                                        <x-icons.edit/>
                                        <span>Edit</span>
                                    </button>
                                    <button type="button"
                                            onclick="bukaModalHapusMember(
                                                '{{ route('admin.member.destroy', $member) }}',
                                                '{{ addslashes($member->nama) }}'
                                            )"
                                            class="flex items-center gap-1.5 px-2.5 py-1.5 rounded-lg text-xs font-medium text-neutral-500 border border-neutral-200 hover:border-danger-300 hover:text-danger-600 hover:bg-danger-50 transition-colors">
                                        <x-icons.delete/>
                                        <span>Hapus</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-5 py-12 text-center">
                                <div class="flex flex-col items-center gap-2">
                                    <div class="w-10 h-10 rounded-2xl bg-neutral-100 flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-neutral-400"
                                             viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                             stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                                            <circle cx="12" cy="7" r="4"/>
                                        </svg>
                                    </div>
                                    <p class="text-sm font-medium text-neutral-500">Belum ada member</p>
                                    <p class="text-xs text-neutral-400">Tambah member terlebih dahulu</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($members->hasPages())
            <div class="px-5 py-3 bg-neutral-50 border-t border-neutral-100">
                {{ $members->withQueryString()->links() }}
            </div>
        @endif
    </div>

</div>

@include('admin.member.create')
@include('admin.member.edit')
@include('admin.member.destroy')

@push('scripts')
<script>
(function () {
    const searchInput = document.getElementById('searchInput');
    let debounce;
    searchInput?.addEventListener('input', function () {
        clearTimeout(debounce);
        const q = this.value.trim();
        debounce = setTimeout(() => {
            const params = new URLSearchParams(window.location.search);
            if (q) params.set('search', q);
            else params.delete('search');
            params.delete('page');
            window.location.href = `${window.location.pathname}?${params.toString()}`;
        }, 400);
    });

    const params = new URLSearchParams(window.location.search);
    if (searchInput && params.get('search')) {
        searchInput.value = params.get('search');
    }
})();
</script>
@endpush
@endsection