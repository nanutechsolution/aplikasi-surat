<div class="p-4 sm:p-6 lg:p-8">
    <div class="max-w-7xl mx-auto">
        <div class="flex flex-col md:flex-row justify-between items-center mb-6">
            <h2 class="text-2xl font-semibold text-gray-800 mb-4 md:mb-0">
                Disposisi Masuk
            </h2>
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari perihal atau nomor surat..." class="w-full md:w-1/3 p-2 border border-gray-300 rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500">
        </div>

        <div class="space-y-4">
            @forelse ($disposisiMasuk as $disposisi)

            <div class="bg-white shadow-sm rounded-lg p-5 border-l-4
            {{ $disposisi->status === 'Selesai' ? 'border-gray-400 bg-gray-50' : 'border-indigo-500' }}">

                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm text-gray-500">
                            Dari: <span class="font-semibold">{{ $disposisi->pengirim->name }}</span>
                        </p>
                        <p class="text-lg font-bold text-gray-800 mt-1">
                            Surat: {{ $disposisi->suratMasuk->perihal }}
                        </p>
                        <p class="text-sm text-gray-600 mt-1">
                            Disposisi:
                            <span class="inline-block px-2 py-0.5 text-xs rounded-full bg-indigo-100 text-indigo-800">
                                {{ $disposisi->kategori?->nama ?? 'Tanpa Kategori' }}
                            </span>
                        </p>
                    </div>
                    <span class="text-xs font-semibold px-2.5 py-1 rounded-full
                    {{ $disposisi->status === 'Selesai' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                        {{ $disposisi->status }}
                    </span>
                </div>
                <div class="mt-4 p-3 bg-gray-50 rounded-md">
                    <p class="text-sm text-gray-700">"{{ $disposisi->isi_disposisi }}"</p>
                </div>

                <div class="mt-4 flex justify-between items-center">
                    <span class="text-xs text-gray-400">{{ $disposisi->created_at->diffForHumans() }}</span>
                    <div class="flex items-center space-x-3">
                        @if ($disposisi->status !== 'Selesai')
                        <button wire:click="tandaiSelesai({{ $disposisi->id }})" class="inline-flex items-center px-3 py-1.5 bg-green-600 text-white text-xs font-medium rounded-md hover:bg-green-700">
                            Tandai Selesai
                        </button>
                        @endif

                        <a href="{{ route('surat.lihat', $disposisi->suratMasuk) }}" wire:navigate class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md hover:bg-indigo-700">
                            Lihat Detail Surat
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <div class="bg-white shadow-sm rounded-lg p-8 text-center">
                <p class="text-gray-500">Tidak ada disposisi untuk Anda saat ini.</p>
            </div>
            @endforelse
        </div>

        <div class="mt-6">
            {{ $disposisiMasuk->links() }}
        </div>
    </div>
</div>
