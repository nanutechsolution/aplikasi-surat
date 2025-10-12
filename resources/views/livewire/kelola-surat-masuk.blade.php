<div class="p-4 sm:p-6 lg:p-8">
    <div class="max-w-7xl mx-auto">

        <div class="flex flex-col md:flex-row justify-between items-center mb-6">
            <h2 class="text-2xl font-semibold text-gray-800 mb-4 md:mb-0">
                Manajemen Surat Masuk
            </h2>
            <div class="flex space-x-2">
                @can('kelola surat')
                <button wire:click="create" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Tambah Surat
                </button>
                @endcan
                {{-- <button wire:click="exportExcel" class="inline-flex items-center px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-md hover:bg-green-700">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                    </svg>
                    Export Excel
                </button> --}}
            </div>
        </div>

        <div class="mb-4">
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari nomor, perihal, atau pengirim..." class="w-full p-2 border border-gray-300 rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500">
        </div>

        <div class="grid grid-cols-1 gap-4 md:hidden">
            @forelse ($suratMasuk as $surat)
            <div class="bg-white shadow-sm rounded-lg p-4 border-l-4 border-blue-500">
                <div class="flex justify-between items-start">
                    <p class="text-lg font-bold text-gray-800 break-words">{{ $surat->perihal }}</p>
                    <a href="{{ route('surat.lihat', $surat) }}" wire:navigate class="ml-4 flex-shrink-0 text-sm text-indigo-600 hover:text-indigo-900">Lihat</a>
                </div>
                <div class="mt-2 space-y-1 text-sm text-gray-600">
                    <p><span class="font-semibold">No:</span> {{ $surat->nomor_surat }}</p>
                    <p><span class="font-semibold">Dari:</span> {{ $surat->pengirim }}</p>
                    <p class="mt-2 text-xs text-gray-400">Diterima: {{ $surat->tanggal_diterima->format('d M Y') }}</p>
                </div>
            </div>
            @empty
            <div class="bg-white shadow-sm rounded-lg p-8 text-center">
                <p class="text-gray-500">Data tidak ditemukan.</p>
            </div>
            @endforelse
        </div>

        <div class="hidden md:block bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nomor Surat</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Perihal</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pengirim</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tgl. Diterima</th>
                            <th class="relative px-6 py-3"><span class="sr-only">Aksi</span></th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($suratMasuk as $surat)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $surat->nomor_surat }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500 max-w-xs truncate">{{ $surat->perihal }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $surat->pengirim }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $surat->tanggal_diterima->format('d M Y') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="{{ route('surat.lihat', $surat) }}" wire:navigate class="text-indigo-600 hover:text-indigo-900">Lihat</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">Data tidak ditemukan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-6">{{ $suratMasuk->links() }}</div>

        @if($showModal)
        <div class="fixed inset-0 z-50 overflow-y-auto flex items-start justify-center p-4 pt-12 bg-black bg-opacity-50">
            <div class="relative w-full max-w-3xl">
                <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-xl">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold text-gray-900">Formulir Pencatatan Surat Masuk</h2>
                        <button wire:click="closeModal" class="text-gray-400 hover:text-gray-600">&times;</button>
                    </div>

                    <form wire:submit="simpan" x-data="{ isUploading: false, progress: 0 }" x-on:livewire-upload-start="isUploading = true" x-on:livewire-upload-finish="isUploading = false; progress = 0" x-on:livewire-upload-error="isUploading = false; progress = 0" x-on:livewire-upload-progress="progress = $event.detail.progress">
                        <div class="grid gap-6 mb-6 sm:grid-cols-2">
                            <div>
                                <label for="nomor_surat" class="block mb-2 text-sm font-medium text-gray-700">Nomor Surat <span class="text-red-500">*</span></label>
                                <input type="text" id="nomor_surat" wire:model="nomor_surat" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                                @error('nomor_surat') <span class="mt-1 text-xs text-red-600">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label for="tanggal_surat" class="block mb-2 text-sm font-medium text-gray-700">Tanggal Surat <span class="text-red-500">*</span></label>
                                <input type="date" id="tanggal_surat" wire:model="tanggal_surat" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                                @error('tanggal_surat') <span class="mt-1 text-xs text-red-600">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label for="tanggal_diterima" class="block mb-2 text-sm font-medium text-gray-700">Tanggal Diterima <span class="text-red-500">*</span></label>
                                <input type="date" id="tanggal_diterima" wire:model="tanggal_diterima" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                                @error('tanggal_diterima') <span class="mt-1 text-xs text-red-600">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label for="pengirim" class="block mb-2 text-sm font-medium text-gray-700">Pengirim <span class="text-red-500">*</span></label>
                                <input type="text" id="pengirim" readonly wire:model="pengirim" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                                @error('pengirim') <span class="mt-1 text-xs text-red-600">{{ $message }}</span> @enderror
                            </div>

                            <div class="sm:col-span-2">
                                <label for="perihal" class="block mb-2 text-sm font-medium text-gray-700">Perihal <span class="text-red-500">*</span></label>
                                <textarea id="perihal" rows="4" wire:model="perihal" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500" required></textarea>
                                @error('perihal') <span class="mt-1 text-xs text-red-600">{{ $message }}</span> @enderror
                            </div>

                            {{-- <div>
                                <label for="sifat_surat" class="block mb-2 text-sm font-medium text-gray-700">Sifat Surat <span class="text-red-500">*</span></label>
                                <select id="sifat_surat" wire:model="sifat_surat" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                    <option value="Biasa">Biasa</option>
                                    <option value="Penting">Penting</option>
                                    <option value="Segera">Segera</option>
                                    <option value="Rahasia">Rahasia</option>
                                </select>
                                @error('sifat_surat') <span class="mt-1 text-xs text-red-600">{{ $message }}</span> @enderror
                        </div> --}}

                        <div class="sm:col-span-2">
                            <label for="file_scan" class="block mb-2 text-sm font-medium text-gray-700">Upload Scan Surat (PDF, JPG, PNG (MAX. 2MB)) <span class="text-red-500">*</span></label>
                            <div x-data="{ isDragging: false }" x-on:dragover.prevent="isDragging = true" x-on:dragleave.prevent="isDragging = false" x-on:drop.prevent="isDragging = false; $wire.fileScan = $event.dataTransfer.files[0]">
                                <label for="file_scan_modal" :class="{'border-blue-500 bg-blue-50': isDragging}" class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed rounded-lg cursor-pointer hover:bg-gray-100">
                                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                        <svg class="w-8 h-8 mb-4 text-gray-500" fill="none" viewBox="0 0 20 16">
                                            <path stroke="currentColor" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L7 9m3-3 3 3" /></svg>
                                        <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">Klik atau seret file</span></p>
                                    </div>
                                    <input id="file_scan_modal" type="file" class="hidden" wire:model="fileScan" accept=".pdf,.jpg,.jpeg,.png,.webp" />
                                </label>
                            </div>
                            @error('fileScan') <span class="mt-1 text-xs text-red-600">{{ $message }}</span> @enderror
                            @if ($fileScan)
                            <div class="flex items-center justify-between p-2 mt-2 text-sm text-gray-700 bg-gray-100 rounded-lg">
                                <span>{{ $fileScan->getClientOriginalName() }}</span>
                                <button type="button" wire:click="$set('fileScan', null)" class="text-red-500 hover:text-red-700">&times;</button>
                            </div>
                            @endif
                            <div x-show="isUploading" class="w-full bg-gray-200 rounded-full h-2.5 mt-2">
                                <div class="bg-blue-600 h-2.5 rounded-full" :style="`width: ${progress}%`"></div>
                            </div>
                        </div>
                        <div class="mt-4 flex items-center space-x-2">
                            <input type="checkbox" wire:model.live="kirimDisposisi" id="kirimDisposisi" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                            <label for="kirimDisposisi" class="text-sm text-gray-700">Kirim disposisi langsung</label>
                        </div>
                        @if($kirimDisposisi)
                        <div class="mt-4 space-y-4 border p-4 rounded-lg bg-gray-50">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Tujuan Disposisi</label>
                                <select wire:model="tujuan_disposisi" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                    <option value="">-- Pilih Tujuan --</option>
                                    @foreach($daftarTujuan as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                                @error('tujuan_disposisi') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Disposisi</label>
                                <select id="kategoriSelect" class="tom-select mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" wire:model="kategori_disposisi_id">
                                    <option value="">-- Pilih Disposisi --</option>
                                    @foreach($daftarKategori as $kategori)
                                    <option value="{{ $kategori->id }}">{{ $kategori->nama }}</option>
                                    @endforeach
                                </select>
                                @error('kategori_disposisi_id')
                                <span class="text-red-600 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Instruksi (opsional)</label>
                                <textarea wire:model="instruksi_disposisi" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500"></textarea>
                            </div>
                        </div>
                        @endif
                </div>
                <div class="flex justify-end pt-4 border-t border-gray-200 mt-6 space-x-3">
                    <button type="button" wire:click="closeModal" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-200 rounded-md hover:bg-gray-300">
                        Batal
                    </button>
                    <button type="submit" wire:loading.attr="disabled" wire:target="simpan" class="inline-flex items-center px-6 py-2 text-sm font-semibold text-white bg-blue-600 rounded-lg shadow-md hover:bg-blue-700">
                        <span wire:loading.remove wire:target>Simpan Surat</span>
                        {{-- <span wire:loading wire:target>Menyimpan...</span> --}}
                    </button>
                </div>
                </form>
            </div>
        </div>
    </div>
    @endif


</div>
</div>
<script>
    document.addEventListener('livewire:load', () => {
        Livewire.on('init-tom-select', () => {
            console.log("jalankan");
            // Hancurkan instance TomSelect yang mungkin sudah ada sebelumnya untuk menghindari duplikasi
            if (document.getElementById('kategoriSelect').tomselect) {
                document.getElementById('kategoriSelect').tomselect.destroy();
            }

            // Inisialisasi TomSelect pada elemen
            const el = document.getElementById('kategoriSelect');
            const ts = new TomSelect(el, {
                create: false
                , sortField: {
                    field: "text"
                    , direction: "asc"
                }
                , placeholder: "Cari atau pilih...",
                // Sync nilai TomSelect ke Livewire saat ada perubahan
                onChange: function(value) {
                    @this.set('kategori_disposisi_id', value);
                }
            });
        });
    });

</script>
