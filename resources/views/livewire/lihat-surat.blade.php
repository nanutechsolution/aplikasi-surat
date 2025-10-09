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
                            @if($fileType === 'pdf')
                            {{-- Tampilkan iframe jika file adalah PDF --}}
                            <iframe src="{{ asset('storage/' . $surat->file_path) }}" width="100%" height="100%" frameborder="0"></iframe>
                            @elseif($fileType === 'image')
                            {{-- Tampilkan gambar jika file adalah image --}}
                            <img src="{{ asset('storage/' . $surat->file_path) }}" alt="Lampiran Gambar" class="w-full h-full object-contain">
                            @else
                            {{-- Pesan jika tipe file tidak didukung untuk pratinjau --}}
                            <div class="flex items-center justify-center h-full">
                                <p class="text-gray-500">Pratinjau tidak tersedia untuk tipe file ini.</p>
                            </div>
                            @endif
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
                        <h3 class="text-xl font-bold text-gray-900 mb-6">Informasi Detail Surat</h3>

                        <div class="space-y-6">

                            <div class="flex items-start space-x-4">
                                <div class="flex-shrink-0 w-8 pt-1 text-center">
                                    <svg class="w-6 h-6 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" /></svg>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Perihal</dt>
                                    <dd class="mt-1 text-base font-semibold text-gray-900">{{ $surat->perihal }}</dd>
                                </div>
                            </div>

                            <div class="flex items-start space-x-4">
                                <div class="flex-shrink-0 w-8 text-center">
                                    <svg class="w-6 h-6 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 4.5h16.5m-16.5 4.5h16.5m-16.5 4.5h16.5m-16.5 4.5h16.5" /></svg>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Nomor Surat</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $surat->nomor_surat }}</dd>
                                </div>
                            </div>

                            <div class="flex items-start space-x-4">
                                <div class="flex-shrink-0 w-8 text-center">
                                    <svg class="w-6 h-6 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" /></svg>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Pengirim</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $surat->pengirim }}</dd>
                                </div>
                            </div>

                            <div class="flex items-start space-x-4">
                                <div class="flex-shrink-0 w-8 text-center">
                                    <svg class="w-6 h-6 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345h5.518a.562.562 0 01.32.958l-4.418 3.223a.563.563 0 00-.182.635l2.125 5.111a.562.562 0 01-.84.62l-4.418-3.223a.563.563 0 00-.676 0l-4.418 3.223a.562.562 0 01-.84-.62l2.125-5.111a.563.563 0 00-.182-.635l-4.418-3.223a.562.562 0 01.32-.958h5.518a.563.563 0 00.475-.345L11.48 3.5z" /></svg>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Sifat Surat</dt>
                                    <dd class="mt-1">
                                        @php
                                        $badgeColor = 'bg-blue-100 text-blue-800'; // Default
                                        if (in_array(strtolower($surat->sifat_surat), ['penting', 'segera', 'rahasia'])) {
                                        $badgeColor = 'bg-red-100 text-red-800';
                                        }
                                        @endphp
                                        <span class="px-2.5 py-1 text-xs font-semibold rounded-full {{ $badgeColor }}">
                                            {{ $surat->sifat_surat }}
                                        </span>
                                    </dd>
                                </div>
                            </div>

                            <hr class="border-gray-200">

                            <div class="flex items-start space-x-4">
                                <div class="flex-shrink-0 w-8 pt-1 text-center">
                                    <svg class="w-6 h-6 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0h18M-4.5 12h22.5" /></svg>
                                </div>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-4 w-full">
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Tanggal Surat</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ $surat->tanggal_surat->format('d F Y') }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Tanggal Diterima</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ $surat->tanggal_diterima->format('d F Y') }}</dd>
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-start space-x-4">
                                <div class="flex-shrink-0 w-8 text-center">
                                    <svg class="w-6 h-6 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Dicatat oleh</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $surat->user->name }}</dd>
                                </div>
                            </div>
                        </div>

                        <div class="mt-8 pt-6 border-t border-gray-200">
                            <h4 class="text-sm font-semibold text-gray-500 mb-3">Aksi Surat</h4>
                            <div class="space-y-3">
                                @can('kelola surat')
                                <a href="{{ route('surat.edit', $surat) }}" wire:navigate class="inline-flex items-center justify-center w-full px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.5L14.732 3.732z"></path>
                                    </svg>
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
                </div>
                @can('kirim disposisi')
                <livewire:form-disposisi :surat="$surat" />
                @endcan
                @if($surat->disposisi->isNotEmpty())
                <div class="bg-white shadow-sm sm:rounded-lg mt-8">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Visualisasi Alur Disposisi</h3>
                        <div class="mermaid text-center" wire:ignore>
                            {{ $dispositionFlowchart }}
                        </div>
                    </div>
                </div>
                @endif
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


<script type="module">
    import mermaid from 'https://cdn.jsdelivr.net/npm/mermaid@10/dist/mermaid.esm.min.mjs';

    // Fungsi untuk menjalankan atau me-render ulang mermaid
    function renderMermaid() {
        // Hapus atribut 'data-processed' agar Mermaid mau me-render ulang elemen yang sama
        document.querySelectorAll('.mermaid').forEach(el => {
            el.removeAttribute('data-processed');
        });
        mermaid.run();
    }

    // Jalankan saat halaman pertama kali dimuat
    mermaid.initialize({ startOnLoad: false }); // startOnLoad kita set false
    document.addEventListener('DOMContentLoaded', () => {
        renderMermaid();
    });

    // Tambahkan listener untuk menangkap sinyal dari Livewire
    window.addEventListener('rerender-mermaid', event => {
        // Ambil elemen mermaid dan pastikan isinya sudah terupdate dari Livewire
        // Kita butuh sedikit delay agar Livewire selesai update DOM
        setTimeout(() => {
            renderMermaid();
        }, 50);
    });
</script>
