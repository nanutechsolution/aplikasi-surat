<div class="p-4 sm:p-6 lg:p-8">
    <div class="max-w-4xl mx-auto">
        <div class="bg-white shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h2 class="text-2xl font-semibold text-gray-800 mb-6">Buat Laporan Surat</h2>

                <form wire:submit.prevent="generatePdf">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label for="jenis_surat" class="block text-sm font-medium text-gray-700">Jenis Surat</label>
                            <select id="jenis_surat" wire:model="jenis_surat" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                <option value="masuk">Surat Masuk</option>
                                <option value="keluar">Surat Keluar</option>
                            </select>
                        </div>

                        <div>
                            <label for="tanggal_mulai" class="block text-sm font-medium text-gray-700">Dari Tanggal</label>
                            <input type="date" id="tanggal_mulai" wire:model="tanggal_mulai" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            @error('tanggal_mulai') <span class="text-xs text-red-600">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="tanggal_selesai" class="block text-sm font-medium text-gray-700">Sampai Tanggal</label>
                            <input type="date" id="tanggal_selesai" wire:model="tanggal_selesai" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            @error('tanggal_selesai') <span class="text-xs text-red-600">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="mt-8 text-right">
                        <button type="submit" class="inline-flex items-center px-6 py-3 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                            Unduh Laporan PDF
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
