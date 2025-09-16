<x-filament-widgets::widget>
    <div class="fi-ta-widget">
{{-- Bagian Bawah: Daftar Kelompok --}}
        <div class="mt-6">
    <h2 class="text-lg font-semibold text-gray-950 dark:text-white">Daftar Kelompok</h2>
    <div class="fi-wi-stats-overview grid gap-6 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 mt-4">
        @foreach ($kelompok as $item)
            <div class="fi-wi-stats-overview-card relative overflow-hidden rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
                <div class="grid gap-y-2">
                    <span class="text-sm font-medium text-gray-500 dark:text-gray-400">
                        {{ $item->nama_kelompok }}
                    </span>
                    <span class="text-2xl font-semibold tracking-tight text-blue-950 dark:text-white">
                        {{ $item->total_maba }}
                    </span>
                    <div class="flex items-center gap-x-4 text-xs">
                        <span class="text-blue-600 font-semibold">L: {{ $item->jumlah_laki }}</span>
                        <span class="text-pink-600 font-semibold">P: {{ $item->jumlah_perempuan }}</span>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

        
    </div>
</x-filament-widgets::widget>