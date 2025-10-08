<div class="p-4 sm:p-6 lg:p-8">
    <div class="max-w-7xl mx-auto">
        <div class="mb-6">
            <h2 class="text-2xl font-semibold text-gray-800">
                Log Aktivitas Sistem
            </h2>
            <p class="text-sm text-gray-500 mt-1">
                Riwayat semua kejadian penting yang tercatat di dalam aplikasi.
            </p>
        </div>

        <div class="bg-white shadow-sm sm:rounded-lg">
            <div class="divide-y divide-gray-200">
                @forelse ($activities as $activity)
                    <div class="p-4 flex items-start space-x-4">
                        <div class="flex-shrink-0">
                            <span class="inline-flex items-center justify-center h-8 w-8 rounded-full bg-blue-100 text-blue-800">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </span>
                        </div>
                        <div class="flex-grow">
                            <p class="text-sm text-gray-800">
                                <span class="font-semibold">{{ $activity->causer->name ?? 'Sistem' }}</span>
                                {{-- Mengganti 'created' menjadi 'membuat data baru' --}}
                                {{ str_replace(['created', 'updated', 'deleted'], ['membuat data baru', 'memperbarui data', 'menghapus data'], $activity->description) }}
                            </p>
                            <p class="text-xs text-gray-500">
                                {{ $activity->created_at->diffForHumans() }} &middot; {{ $activity->created_at->format('d M Y, H:i') }}
                            </p>
                        </div>
                        <div class="flex-shrink-0">
                            <span class="text-xs font-semibold px-2.5 py-1 rounded-full bg-gray-100 text-gray-800">
                                {{ $activity->log_name }}
                            </span>
                        </div>
                    </div>
                @empty
                    <div class="p-6 text-center text-gray-500">
                        Belum ada aktivitas yang tercatat.
                    </div>
                @endforelse
            </div>
        </div>

        <div class="mt-6">
            {{ $activities->links() }}
        </div>
    </div>
</div>
