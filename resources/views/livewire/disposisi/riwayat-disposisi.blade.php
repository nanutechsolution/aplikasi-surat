<div class="p-4 sm:p-6 lg:p-8">
    <div class="max-w-7xl mx-auto">
        <div class="flex flex-col md:flex-row justify-between items-center mb-6">
            <h2 class="text-2xl font-semibold text-gray-800 mb-4 md:mb-0">
                Riwayat Disposisi
            </h2>
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari perihal atau nomor surat..." class="w-full md:w-1/3 p-2 border border-gray-300 rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500">
        </div>

        {{-- 💻 Tampilan Desktop (Tabel) --}}
        <div class="hidden md:block overflow-x-auto bg-white shadow rounded-lg">
            <table class="min-w-full text-sm text-gray-700">
                <thead class="bg-gray-100 text-xs uppercase font-semibold">
                    <tr>
                        <th class="px-4 py-3 text-left">No</th>
                        <th class="px-4 py-3 text-left">Perihal Surat</th>
                        <th class="px-4 py-3 text-left">Tujuan</th>
                        <th class="px-4 py-3 text-left">Instruksi</th>
                        <th class="px-4 py-3 text-left">Catatan</th>
                        <th class="px-4 py-3 text-left">Tanggal Kirim</th>
                        <th class="px-4 py-3 text-left">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($riwayat as $index => $disposisi)
                    <tr class="border-t hover:bg-gray-50">
                        <td class="px-4 py-3 align-top">{{ $riwayat->firstItem() + $index }}</td>
                        <td class="px-4 py-3 align-top font-medium text-gray-800">
                            {{ $disposisi->suratMasuk->perihal }}
                            <p class="text-xs text-gray-500 font-normal">{{ $disposisi->suratMasuk->nomor_surat }}</p>
                        </td>
                        <td class="px-4 py-3 align-top">
                            {{-- PERUBAHAN: Loop untuk menampilkan banyak penerima --}}
                            <div class="flex flex-col space-y-1">
                                @foreach($disposisi->penerima as $penerima)
                                    <span>{{ $penerima->name }}</span>
                                @endforeach
                            </div>
                        </td>
                        <td class="px-4 py-3 align-top">
                            {{-- PERUBAHAN: Loop untuk menampilkan banyak instruksi --}}
                            <div class="flex flex-wrap gap-1">
                                @foreach($disposisi->instruksi as $instruksi)
                                    <span class="text-xs bg-gray-200 text-gray-800 px-2 py-1 rounded-full">{{ $instruksi->nama }}</span>
                                @endforeach
                            </div>
                        </td>
                        <td class="px-4 py-3 text-gray-600 max-w-xs truncate align-top">
                            {{-- PERUBAHAN: Menggunakan 'catatan' --}}
                            {{ $disposisi->catatan ?? '-' }}
                        </td>
                        <td class="px-4 py-3 text-xs text-gray-500 align-top">
                            {{ $disposisi->created_at->diffForHumans() }}
                        </td>
                        <td class="px-4 py-3 align-top">
                            <a href="{{ route('surat.lihat', $disposisi->suratMasuk) }}" wire:navigate class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-white bg-indigo-600 rounded hover:bg-indigo-700">
                                Lihat
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-4 py-6 text-center text-gray-500">
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

