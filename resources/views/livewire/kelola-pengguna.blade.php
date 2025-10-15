<div class="p-4 sm:p-6 lg:p-8">
    <div class="max-w-7xl mx-auto">
        <!-- Header Halaman -->
        <div class="flex flex-col md:flex-row justify-between items-center mb-6">
            <h2 class="text-2xl font-semibold text-gray-800 mb-4 md:mb-0">
                Manajemen Pengguna
            </h2>
            <button wire:click="create" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                Tambah Pengguna
            </button>
        </div>

        <!-- Search Input -->
        <div class="mb-4">
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari nama atau email pengguna..." class="w-full p-2 border border-gray-300 rounded-lg text-sm">
        </div>

        <!-- Tabel Data -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jabatan</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Role</th>
                            <th class="relative px-6 py-3"><span class="sr-only">Aksi</span></th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($users as $user)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $user->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $user->email }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $user->jabatan->nama ?? '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    {{ $user->roles->first()->name ?? '-' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                                <button wire:click="edit({{ $user->id }})" class="text-indigo-600 hover:text-indigo-900">Edit</button>
                                <button wire:click="hapus({{ $user->id }})" wire:confirm="Anda yakin ingin menghapus pengguna ini?" class="text-red-600 hover:text-red-900">Hapus</button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">Data pengguna tidak ditemukan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="mt-4">{{ $users->links() }}</div>

        <!-- Modal Form -->
        @if($showModal)
        <div class="fixed inset-0 z-50 overflow-y-auto flex items-center justify-center bg-black bg-opacity-50" x-data @click.self="$wire.closeModal()">
            <div class="relative w-full max-w-lg p-4">
                <div class="p-6 bg-white rounded-lg shadow-xl">
                    <form wire:submit="simpan">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">{{ $userId ? 'Edit Pengguna' : 'Tambah Pengguna Baru' }}</h3>
                        <div class="space-y-4">
                            <!-- Nama, Email -->
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700">Nama</label>
                                <input type="text" wire:model="name" class="mt-1 block w-full ...">
                                @error('name') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                                <input type="email" wire:model="email" class="mt-1 block w-full ...">
                                @error('email') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                            </div>
                            <!-- Jabatan, Role, Atasan -->
                            <div>
                                <label for="jabatanId" class="block text-sm font-medium text-gray-700">Jabatan</label>
                                <select wire:model="jabatanId" class="mt-1 block w-full ...">
                                    <option value="">Pilih Jabatan</option>
                                    @foreach($daftarJabatan as $jabatan)
                                        <option value="{{ $jabatan->id }}">{{ $jabatan->nama }}</option>
                                    @endforeach
                                </select>
                                @error('jabatanId') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label for="roleName" class="block text-sm font-medium text-gray-700">Role</label>
                                <select wire:model="roleName" class="mt-1 block w-full ...">
                                    <option value="">Pilih Role</option>
                                    @foreach($allRoles as $role)
                                        <option value="{{ $role }}">{{ Str::title($role) }}</option>
                                    @endforeach
                                </select>
                                @error('roleName') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                            </div>
                             <div>
                                <label for="managerId" class="block text-sm font-medium text-gray-700">Atasan Langsung</label>
                                <select wire:model="managerId" class="mt-1 block w-full ...">
                                    <option value="">Tidak Ada Atasan</option>
                                    @foreach($daftarManajer as $manajer)
                                        <option value="{{ $manajer->id }}">{{ $manajer->name }}</option>
                                    @endforeach
                                </select>
                                @error('managerId') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                            </div>
                            <!-- Password -->
                             <div>
                                <label for="password" class="block text-sm font-medium text-gray-700">Password {{ $userId ? '(Isi jika ingin mengubah)' : '' }}</label>
                                <input type="password" wire:model="password" class="mt-1 block w-full ...">
                                @error('password') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                            </div>
                             <div>
                                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi Password</label>
                                <input type="password" wire:model="password_confirmation" class="mt-1 block w-full ...">
                            </div>
                        </div>
                        <div class="flex justify-end pt-4 mt-6 space-x-2 border-t">
                            <button type="button" wire:click="closeModal" class="px-4 py-2 ...">Batal</button>
                            <button type="submit" class="px-4 py-2 ...">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
