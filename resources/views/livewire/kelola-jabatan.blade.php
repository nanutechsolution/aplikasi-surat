<div class="p-4 sm:p-6 lg:p-8">
    <div class="max-w-7xl mx-auto">
        <!-- Header Halaman -->
        <div class="flex flex-col md:flex-row justify-between items-center mb-6">
            <h2 class="text-2xl font-semibold text-gray-800 mb-4 md:mb-0">
                Manajemen Jabatan
            </h2>
            <button wire:click="create" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                Tambah Jabatan
            </button>
        </div>

        <!-- Tabel Data -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Jabatan</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Dibuat Pada</th>
                            <th class="relative px-6 py-3"><span class="sr-only">Aksi</span></th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($daftarJabatan as $jabatan)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $jabatan->nama }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $jabatan->created_at->format('d M Y') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                                <button wire:click="edit({{ $jabatan->id }})" class="text-indigo-600 hover:text-indigo-900">Edit</button>
                                <button wire:click="hapus({{ $jabatan->id }})" wire:confirm="Anda yakin ingin menghapus jabatan ini? Pengguna dengan jabatan ini akan kehilangan jabatannya." class="text-red-600 hover:text-red-900">Hapus</button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="px-6 py-4 text-center text-sm text-gray-500">Belum ada data jabatan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="mt-4">{{ $daftarJabatan->links() }}</div>

        <!-- Modal Form -->
        @if($showModal)
        <div class="fixed inset-0 z-50 overflow-y-auto flex items-center justify-center bg-black bg-opacity-50" x-data @click.self="$wire.closeModal()">
            <div class="relative w-full max-w-lg p-4">
                <div class="p-6 bg-white rounded-lg shadow-xl">
                    <form wire:submit="simpan">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">{{ $jabatanId ? 'Edit Jabatan' : 'Tambah Jabatan Baru' }}</h3>
                        <div>
                            <label for="nama" class="block text-sm font-medium text-gray-700">Nama Jabatan</label>
                            <input type="text" id="nama" wire:model="nama" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" autofocus>
                            @error('nama') <span class="text-red-600 text-sm mt-1">{{ $message }}</span> @enderror
                        </div>
                        <div class="flex justify-end pt-4 mt-4 space-x-2 border-t">
                            <button type="button" wire:click="closeModal" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-200 rounded-md hover:bg-gray-300">Batal</button>
                            <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
