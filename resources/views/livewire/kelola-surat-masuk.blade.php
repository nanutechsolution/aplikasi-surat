<div class="p-4 sm:p-6 lg:p-8">
    <div class="max-w-3xl mx-auto">

        @if (session('sukses'))
        <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50" role="alert">
            <span class="font-medium">Berhasil!</span> {{ session('sukses') }}
        </div>
        @endif
        @can('kelola surat')
        <div class="p-6 bg-white border border-gray-200 rounded-lg shadow">
            <h2 class="mb-6 text-2xl font-bold text-gray-900 text-center">Formulir Pencatatan Surat Masuk</h2>

            <form wire:submit="simpan" x-data="{ isUploading: false, progress: 0 }" x-on:livewire-upload-start="isUploading = true" x-on:livewire-upload-finish="isUploading = false; progress = 0" x-on:livewire-upload-error="isUploading = false; progress = 0" x-on:livewire-upload-progress="progress = $event.detail.progress">

                <div class="grid gap-6 mb-6 sm:grid-cols-2">
                    <div>
                        <label for="nomor_surat" class="block mb-2 text-sm font-medium text-gray-700">Nomor Surat <span class="text-red-500">*</span></label>
                        <input type="text" id="nomor_surat" wire:model="nomor_surat" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="Contoh: 001/SM/XII/2023" required>
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
                        <input type="text" id="pengirim" wire:model="pengirim" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="Nama instansi/orang pengirim" required>
                        @error('pengirim') <span class="mt-1 text-xs text-red-600">{{ $message }}</span> @enderror
                    </div>

                    <div class="sm:col-span-2">
                        <label for="perihal" class="block mb-2 text-sm font-medium text-gray-700">Perihal <span class="text-red-500">*</span></label>
                        <textarea id="perihal" rows="4" wire:model="perihal" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500" placeholder="Isi ringkas surat" required></textarea>
                        @error('perihal') <span class="mt-1 text-xs text-red-600">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="sifat_surat" class="block mb-2 text-sm font-medium text-gray-700">Sifat Surat <span class="text-red-500">*</span></label>
                        <select id="sifat_surat" wire:model="sifat_surat" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                            <option value="Biasa">Biasa</option>
                            <option value="Penting">Penting</option>
                            <option value="Segera">Segera</option>
                            <option value="Rahasia">Rahasia</option>
                        </select>
                        @error('sifat_surat') <span class="mt-1 text-xs text-red-600">{{ $message }}</span> @enderror
                    </div>

                    <div class="sm:col-span-2">
                        <label for="file_scan" class="block mb-2 text-sm font-medium text-gray-700">Upload Scan Surat (PDF, max 2MB) <span class="text-red-500">*</span></label>
                        <div x-data="{ isDragging: false }" x-on:dragover.prevent="isDragging = true" x-on:dragleave.prevent="isDragging = false" x-on:drop.prevent="isDragging = false; $wire.fileScan = $event.dataTransfer.files[0]">

                            <label for="file_scan" :class="{'border-blue-500 bg-blue-50': isDragging, 'border-gray-300 bg-gray-50': !isDragging}" class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed rounded-lg cursor-pointer hover:bg-gray-100 transition-colors duration-200 ease-in-out">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                    <svg class="w-8 h-8 mb-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L7 9m3-3 3 3" />
                                    </svg>
                                    <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">Klik untuk upload</span> atau seret dan lepas</p>
                                    <p class="text-xs text-gray-500">PDF (MAX. 2MB)</p>
                                </div>
                                <input id="file_scan" type="file" class="hidden" wire:model="fileScan" accept=".pdf" />
                            </label>
                        </div>

                        @error('fileScan') <span class="mt-1 text-xs text-red-600">{{ $message }}</span> @enderror

                        @if ($fileScan)
                        <div class="flex items-center justify-between p-2 mt-2 text-sm text-gray-700 bg-gray-100 border border-gray-200 rounded-lg">
                            <span>{{ $fileScan->getClientOriginalName() }}</span>
                            <button type="button" wire:click="$set('fileScan', null)" class="text-red-500 hover:text-red-700">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>
                        @endif

                        <div x-show="isUploading" class="w-full bg-gray-200 rounded-full h-2.5 mt-2">
                            <div class="bg-blue-600 h-2.5 rounded-full" :style="`width: ${progress}%`"></div>
                        </div>
                        <p x-show="isUploading" class="mt-1 text-xs text-blue-600">Mengunggah... <span x-text="progress"></span>%</p>
                    </div>
                </div>

                <div class="flex justify-end pt-4 border-t border-gray-200 mt-6">
                    <button type="submit" wire:loading.attr="disabled" wire:target="simpan, fileScan" class="inline-flex items-center px-6 py-3 text-sm font-semibold text-white bg-blue-600 rounded-lg shadow-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-300 ease-in-out">
                        <span wire:loading.remove wire:target="simpan, fileScan">
                            <svg class="w-5 h-5 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-4 0V4m0 3a4 4 0 014 4H8a4 4 0 014-4z"></path>
                            </svg>
                            Simpan Surat
                        </span>
                        <span wire:loading wire:target="simpan, fileScan" class="flex items-center">
                            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Menyimpan...
                        </span>
                    </button>
                </div>
            </form>
        </div>
        @endcan
        <div class="mt-8">
            <div class="max-w-7xl mx-auto">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="flex flex-col md:flex-row justify-between items-center mb-4">
                            <h2 class="text-xl font-semibold text-gray-800 mb-4 md:mb-0">
                                Daftar Surat Masuk
                            </h2>
                            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari nomor, perihal, atau pengirim..." class="w-full md:w-1/3 p-2 border border-gray-300 rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nomor Surat</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Perihal</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pengirim</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tgl. Diterima</th>
                                        <th scope="col" class="relative px-6 py-3">
                                            <span class="sr-only">Aksi</span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse ($suratMasuk as $surat)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $surat->nomor_surat }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 max-w-xs truncate">{{ $surat->perihal }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $surat->pengirim }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $surat->tanggal_diterima->format('d M Y') }}</td>
                                        @can('kelola surat')
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <a href="{{ route('surat.lihat', $surat) }}" wire:navigate class="text-indigo-600 hover:text-indigo-900">Lihat</a>
                                        </td>
                                        @else
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <a href="{{ route('surat.lihat', $surat) }}" wire:navigate class="text-indigo-600 hover:text-indigo-900">Lihat</a>
                                        </td>
                                        @endcan
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">
                                            Data tidak ditemukan.
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-4">
                            {{ $suratMasuk->links() }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
