<div class="p-4 sm:p-6 lg:p-8">
    <div class="max-w-7xl mx-auto">
        <div class="flex flex-col md:flex-row justify-between items-center mb-6">
            <h2 class="text-2xl font-semibold text-gray-800 mb-4 md:mb-0">
                Riwayat Disposisi
            </h2>
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari perihal atau nomor surat..." class="w-full md:w-1/3 p-2 border border-gray-300 rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500">
        </div>

        {{-- 📱 Tampilan Mobile (Card) --}}
        <div class="space-y-4 md:hidden">
            @forelse ($riwayat as $disposisi)
            <div class="bg-white shadow rounded-lg p-4 border-l-4
                {{ $disposisi->status === 'Selesai' ? 'border-gray-400 bg-gray-50' : 'border-indigo-500' }}">

                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-xs text-gray-500">
                            Kepada: <span class="font-semibold">{{ $disposisi->penerima->name }}</span>
                        </p>
                        <p class="text-sm font-bold text-gray-800 mt-1">
                            {{ $disposisi->suratMasuk->perihal }}
                        </p>
                        <p class="text-xs mt-1">
                            <span class="inline-block px-2 py-0.5 rounded-full bg-indigo-100 text-indigo-800">
                                {{ $disposisi->kategori?->nama ?? 'Tanpa Kategori' }}
                            </span>
                        </p>
                    </div>
                    <span class="text-xs font-semibold px-2.5 py-1 rounded-full
                    {{ $disposisi->status === 'Selesai' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                        {{ $disposisi->status }}
                    </span>
                </div>

                <div class="mt-3 text-gray-700 text-sm bg-gray-50 rounded-md p-2">
                    "{{ $disposisi->isi_disposisi }}"
                </div>

                <div class="mt-3 flex justify-between items-center text-xs text-gray-400">
                    <span>{{ $disposisi->created_at->diffForHumans() }}</span>
                    <a href="{{ route('surat.lihat', $disposisi->suratMasuk) }}" wire:navigate class="text-indigo-600 hover:underline">
                        Lihat Surat
                    </a>
                </div>
            </div>
            @empty
            <div class="bg-white shadow-sm rounded-lg p-8 text-center">
                <p class="text-gray-500">Belum ada disposisi yang Anda kirim.</p>
            </div>
            @endforelse
        </div>

        {{-- 💻 Tampilan Desktop (Tabel) --}}
        <div class="hidden md:block overflow-x-auto bg-white shadow rounded-lg">
            <table class="min-w-full text-sm text-gray-700">
                <thead class="bg-gray-100 text-xs uppercase font-semibold">
                    <tr>
                        <th class="px-4 py-3 text-left">No</th>
                        <th class="px-4 py-3 text-left">Tujuan</th>
                        <th class="px-4 py-3 text-left">Perihal Surat</th>
                        <th class="px-4 py-3 text-left">Disposi</th>
                        <th class="px-4 py-3 text-left">Keterangan</th>
                        <th class="px-4 py-3 text-left">Status</th>
                        <th class="px-4 py-3 text-left">Tanggal</th>
                        <th class="px-4 py-3 text-left">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($riwayat as $index => $disposisi)
                    <tr class="border-t hover:bg-gray-50">
                        <td class="px-4 py-3">{{ $riwayat->firstItem() + $index }}</td>
                        <td class="px-4 py-3">{{ $disposisi->penerima->name }}</td>
                        <td class="px-4 py-3 font-medium text-gray-800">
                            {{ $disposisi->suratMasuk->perihal }}
                        </td>
                        <td class="px-4 py-3">
                            <span class="inline-block px-2 py-0.5 rounded-full bg-indigo-100 text-indigo-800">
                                {{ $disposisi->kategori?->nama ?? 'Tanpa Kategori' }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-gray-600 max-w-xs truncate">
                            {{ $disposisi->isi_disposisi }}
                        </td>
                        <td class="px-4 py-3">
                            <span class="px-2.5 py-1 rounded-full text-xs font-semibold
                                {{ $disposisi->status === 'Selesai' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                {{ $disposisi->status }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-xs text-gray-500">
                            {{ $disposisi->created_at->format('d M Y H:i') }}
                        </td>
                        <td class="px-4 py-3">
                            <a href="{{ route('surat.lihat', $disposisi->suratMasuk) }}" wire:navigate class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-white bg-indigo-600 rounded hover:bg-indigo-700">
                                Lihat
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-4 py-6 text-center text-gray-500">
                            Belum ada disposisi yang Anda kirim.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $riwayat->links() }}
        </div>
    </div>
</div>
