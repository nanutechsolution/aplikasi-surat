<div class="p-4 sm:p-6 lg:p-8">
    <div class="max-w-3xl mx-auto">
        <div class="p-6 bg-white border border-gray-200 rounded-lg shadow">
            <h2 class="mb-6 text-2xl font-bold text-gray-900 text-center">Edit Surat Masuk</h2>

            <form wire:submit="update" x-data="{ isUploading: false, progress: 0 }"
                x-on:livewire-upload-start="isUploading = true"
                x-on:livewire-upload-finish="isUploading = false; progress = 0"
                x-on:livewire-upload-error="isUploading = false; progress = 0"
                x-on:livewire-upload-progress="progress = $event.detail.progress">

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
                        <input type="text" id="pengirim" wire:model="pengirim" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                        @error('pengirim') <span class="mt-1 text-xs text-red-600">{{ $message }}</span> @enderror
                    </div>

                    <div class="sm:col-span-2">
                        <label for="perihal" class="block mb-2 text-sm font-medium text-gray-700">Perihal <span class="text-red-500">*</span></label>
                        <textarea id="perihal" rows="4" wire:model="perihal" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500" required></textarea>
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
                        <label class="block mb-2 text-sm font-medium text-gray-700">Ganti Scan Surat (Opsional)</label>

                        <div x-data="{ isDragging: false }"
                            x-on:dragover.prevent="isDragging = true"
                            x-on:dragleave.prevent="isDragging = false"
                            x-on:drop.prevent="isDragging = false; $wire.fileScan = $event.dataTransfer.files[0]">
                            <label for="file_scan_edit" :class="{'border-blue-500 bg-blue-50': isDragging, 'border-gray-300 bg-gray-50': !isDragging}" class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed rounded-lg cursor-pointer hover:bg-gray-100 transition-colors duration-200 ease-in-out">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                    <svg class="w-8 h-8 mb-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L7 9m3-3 3 3"/></svg>
                                    <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">Klik atau seret file baru</span> untuk mengganti</p>
                                    <p class="text-xs text-gray-500">PDF (MAX. 2MB)</p>
                                </div>
                                <input id="file_scan_edit" type="file" class="hidden" wire:model="fileScan" accept=".pdf" />
                            </label>
                        </div>

                        @error('fileScan') <span class="mt-1 text-xs text-red-600">{{ $message }}</span> @enderror

                        <div class="mt-2 text-sm">
                            @if ($fileScan)
                                <div class="flex items-center justify-between p-2 text-gray-700 bg-gray-100 border border-gray-200 rounded-lg">
                                    <span>File baru: {{ $fileScan->getClientOriginalName() }}</span>
                                    <button type="button" wire:click="$set('fileScan', null)" class="text-red-500 hover:text-red-700">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                    </button>
                                </div>
                            @else
                                <p class="text-gray-600">File saat ini:
                                    <a href="{{ asset('storage/' . $existingFilePath) }}" target="_blank" class="text-blue-600 hover:underline">
                                        Lihat File
                                    </a>
                                </p>
                            @endif
                        </div>

                        <div x-show="isUploading" class="w-full bg-gray-200 rounded-full h-2.5 mt-2">
                            <div class="bg-blue-600 h-2.5 rounded-full" :style="`width: ${progress}%`"></div>
                        </div>
                    </div>
                </div>

                <div class="flex justify-between items-center pt-4 border-t border-gray-200 mt-6">
                    <a href="{{ route('surat.lihat', $surat) }}" wire:navigate class="text-sm font-medium text-gray-600 hover:text-gray-900">
                        &larr; Batal
                    </a>
                    <button type="submit" wire:loading.attr="disabled" wire:target="update, fileScan" class="inline-flex items-center px-6 py-3 text-sm font-semibold text-white bg-blue-600 rounded-lg shadow-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-300 ease-in-out">
                        <span wire:loading.remove wire:target="update, fileScan">
                            Simpan Perubahan
                        </span>
                        <span wire:loading wire:target="update, fileScan" class="flex items-center">
                            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                            Menyimpan...
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
