<div class="p-4 sm:p-6 lg:p-8">
    <div class="max-w-7xl mx-auto">
        <div class="flex flex-col md:flex-row justify-between items-center mb-6">
            <h2 class="text-2xl font-semibold text-gray-800 mb-4 md:mb-0">Kelola Surat Keluar</h2>
            <button wire:click="create" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700">
                Tambah Surat Keluar
            </button>
        </div>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nomor Surat</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tujuan</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Perihal</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tgl. Surat</th>
                            <th class="relative px-6 py-3"><span class="sr-only">Aksi</span></th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($suratKeluarList as $surat)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $surat->nomor_surat }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $surat->tujuan }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 max-w-xs truncate">{{ $surat->perihal }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $surat->tanggal_surat->format('d M Y') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <button wire:click="edit({{ $surat->id }})" class="text-indigo-600 hover:text-indigo-900">Edit</button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">Tidak ada data surat keluar.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="mt-4">{{ $suratKeluarList->links() }}</div>

        @if($showModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black bg-opacity-50">
            <div x-data="{ isUploading: false, progress: 0 }" x-on:livewire-upload-start="isUploading = true" x-on:livewire-upload-finish="isUploading = false; progress = 0" x-on:livewire-upload-error="isUploading = false; progress = 0" x-on:livewire-upload-progress="progress = $event.detail.progress" class="relative w-full max-w-lg p-6 bg-white rounded-lg shadow-xl">

                <h3 class="text-lg font-bold text-gray-900">{{ $isEditMode ? 'Edit Surat Keluar' : 'Tambah Surat Keluar' }}</h3>

                <form wire:submit.prevent="save" class="mt-4 space-y-4">
                    <div>
                        <label for="nomor_surat" class="block text-sm font-medium text-gray-700">Nomor Surat</label>
                        <input type="text" id="nomor_surat" wire:model.defer="nomor_surat" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        @error('nomor_surat') <span class="text-xs text-red-600">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label for="tujuan" class="block text-sm font-medium text-gray-700">Tujuan</label>
                        <input type="text" id="tujuan" wire:model.defer="tujuan" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        @error('tujuan') <span class="text-xs text-red-600">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label for="tanggal_surat" class="block text-sm font-medium text-gray-700">Tanggal Surat</label>
                        <input type="date" id="tanggal_surat" wire:model.defer="tanggal_surat" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        @error('tanggal_surat') <span class="text-xs text-red-600">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label for="perihal" class="block text-sm font-medium text-gray-700">Perihal</label>
                        <textarea id="perihal" wire:model.defer="perihal" rows="4" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"></textarea>
                        @error('perihal') <span class="text-xs text-red-600">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-700">File Scan (PDF, max 2MB)</label>
                        <div x-data="{ isDragging: false }" x-on:dragover.prevent="isDragging = true" x-on:dragleave.prevent="isDragging = false" x-on:drop.prevent="isDragging = false; $wire.fileScan = $event.dataTransfer.files[0]">

                            <label for="file_scan_keluar" :class="{'border-blue-500 bg-blue-50': isDragging, 'border-gray-300 bg-gray-50': !isDragging}" class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed rounded-lg cursor-pointer hover:bg-gray-100 transition-colors">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                    <svg class="w-8 h-8 mb-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L7 9m3-3 3 3" /></svg>
                                    <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">Klik atau seret file</span></p>
                                    <p class="text-xs text-gray-500">PDF (MAX. 2MB)</p>
                                </div>
                                <input id="file_scan_keluar" type="file" class="hidden" wire:model="fileScan" />
                            </label>
                        </div>
                        @error('fileScan') <span class="mt-1 text-xs text-red-600">{{ $message }}</span> @enderror

                        <div class="mt-2 text-sm">
                            @if ($fileScan)
                            <div class="flex items-center justify-between p-2 text-gray-700 bg-gray-100 rounded-lg">
                                <span>File baru: {{ $fileScan->getClientOriginalName() }}</span>
                                <button type="button" wire:click="$set('fileScan', null)" class="text-red-500 hover:text-red-700">&times;</button>
                            </div>
                            @elseif ($isEditMode && $existingFilePath)
                            <p class="text-gray-600">File saat ini:
                                <a href="{{ asset('storage/' . $existingFilePath) }}" target="_blank" class="text-blue-600 hover:underline">Lihat File</a>
                            </p>
                            @endif
                        </div>

                        <div x-show="isUploading" class="w-full bg-gray-200 rounded-full h-2.5 mt-2">
                            <div class="bg-blue-600 h-2.5 rounded-full" :style="`width: ${progress}%`"></div>
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end space-x-3">
                        <button type="button" wire:click="closeModal" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-200 rounded-md hover:bg-gray-300">Batal</button>
                        <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700">
                            <span wire:loading.remove wire:target="save, fileScan">{{ $isEditMode ? 'Update' : 'Simpan' }}</span>
                            <span wire:loading wire:target="save, fileScan">Menyimpan...</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
        @endif
    </div>
</div>
