<div class="p-4 sm:p-6 lg:p-8" x-data="{ showDeleteModal: false }">
    <div class="max-w-7xl mx-auto">

        <div class="mb-6">
            <a href="{{ route('surat-masuk') }}" wire:navigate class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-800 text-sm font-medium rounded-md hover:bg-gray-300">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali ke Daftar
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            <div class="lg:col-span-2">
                <div class="bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Pratinjau Dokumen</h3>
                        <div class="w-full h-[80vh] bg-gray-100 rounded-md">
                            <iframe src="{{ asset('storage/' . $surat->file_path) }}" width="100%" height="100%" frameborder="0"></iframe>
                        </div>
                        <a href="{{ asset('storage/' . $surat->file_path) }}" download class="inline-block mt-4 text-sm text-blue-600 hover:text-blue-800">
                            Unduh Dokumen
                        </a>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-1">
                <div class="bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Detail Surat</h3>
                        <dl class="space-y-4">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Nomor Surat</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $surat->nomor_surat }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Perihal</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $surat->perihal }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Pengirim</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $surat->pengirim }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Sifat Surat</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    <span class="px-2 py-1 text-xs font-semibold text-blue-800 bg-blue-100 rounded-full">
                                        {{ $surat->sifat_surat }}
                                    </span>
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Tanggal Surat</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $surat->tanggal_surat->format('d F Y') }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Tanggal Diterima</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $surat->tanggal_diterima->format('d F Y') }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Dicatat oleh</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $surat->user->name }}</dd>
                            </div>
                        </dl>

                        <div class="mt-6 pt-4 border-t border-gray-200 space-y-3">
                            @can('kelola surat')
                            <a href="{{ route('surat.edit', $surat) }}" wire:navigate class="inline-flex items-center justify-center w-full px-4 py-2 bg-blue-600 text-white ...">
                                Edit Surat
                            </a>
                            @endcan
                            @role('admin')
                            <button @click="showDeleteModal = true" class="inline-flex items-center justify-center w-full px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-md hover:bg-red-700">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                                Hapus Surat
                            </button>
                            @endrole
                        </div>
                    </div>
                </div>
                @can('kirim disposisi')
                <livewire:form-disposisi :surat="$surat" />
                @endcan
                <div class="bg-white shadow-sm sm:rounded-lg mt-8">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Riwayat Disposisi</h3>
                        <div class="space-y-4">
                            @forelse ($surat->disposisi->sortByDesc('created_at') as $item)
                            <div class="border-l-4 border-blue-500 pl-4">
                                <p class="text-sm font-semibold text-gray-800">
                                    {{ $item->pengirim->name }} &rarr; {{ $item->penerima->name }}
                                </p>
                                <p class="text-sm text-gray-600 mt-1">"{{ $item->isi_disposisi }}"</p>
                                <p class="text-xs text-gray-400 mt-2">{{ $item->created_at->diffForHumans() }}</p>
                            </div>
                            @empty
                            <p class="text-sm text-gray-500">Belum ada disposisi untuk surat ini.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div x-show="showDeleteModal" @keydown.escape.window="showDeleteModal = false" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black bg-opacity-50" style="display: none;">
        <div @click.outside="showDeleteModal = false" class="relative w-full max-w-md p-6 bg-white rounded-lg shadow-xl">
            <h3 class="text-lg font-bold text-gray-900">Konfirmasi Penghapusan</h3>
            <p class="mt-2 text-sm text-gray-600">
                Apakah Anda yakin ingin menghapus surat ini? Tindakan ini tidak dapat diurungkan.
            </p>
            <div class="mt-6 flex justify-end space-x-3">
                <button @click="showDeleteModal = false" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-200 rounded-md hover:bg-gray-300">
                    Batal
                </button>
                <button wire:click="delete" @click="showDeleteModal = false" class="px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-md hover:bg-red-700">
                    Ya, Hapus
                </button>
            </div>
        </div>
    </div>
</div>
