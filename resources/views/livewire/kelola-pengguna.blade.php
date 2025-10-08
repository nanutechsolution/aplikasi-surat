<div class="p-4 sm:p-6 lg:p-8">
    <div class="max-w-7xl mx-auto">
        <div class="flex flex-col md:flex-row justify-between items-center mb-6">
            <h2 class="text-2xl font-semibold text-gray-800 mb-4 md:mb-0">
                Kelola Pengguna
            </h2>
            <button wire:click="create" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Tambah Pengguna
            </button>
        </div>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Peran</th>
                            <th class="relative px-6 py-3"><span class="sr-only">Aksi</span></th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($users as $user)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $user->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $user->email }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    {{ $user->roles->first()->name ?? 'N/A' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <button wire:click="edit({{ $user->id }})" class="text-indigo-600 hover:text-indigo-900">Edit</button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">Tidak ada data pengguna.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="mt-4">{{ $users->links() }}</div>

        @if($showModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black bg-opacity-50">
            <div class="relative w-full max-w-lg p-6 bg-white rounded-lg shadow-xl">
                <h3 class="text-lg font-bold text-gray-900">{{ $isEditMode ? 'Edit Pengguna' : 'Tambah Pengguna Baru' }}</h3>
                <form wire:submit.prevent="save" class="mt-4 space-y-4">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Nama</label>
                        <input type="text" id="name" wire:model.defer="name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        @error('name') <span class="text-xs text-red-600">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" id="email" wire:model.defer="email" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        @error('email') <span class="text-xs text-red-600">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label for="role" class="block text-sm font-medium text-gray-700">Peran</label>
                        <select id="role" wire:model.defer="role" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            <option value="">Pilih Peran</option>
                            @foreach($roles as $role)
                            <option value="{{ $role->name }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                        @error('role') <span class="text-xs text-red-600">{{ $message }}</span> @enderror
                    </div>
                    @unless($isEditMode)
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                        <input type="password" id="password" wire:model.defer="password" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        @error('password') <span class="text-xs text-red-600">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi Password</label>
                        <input type="password" id="password_confirmation" wire:model.defer="password_confirmation" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    </div>
                    @endunless
                    <div class="mt-6 flex justify-end space-x-3">
                        <button type="button" wire:click="closeModal" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-200 rounded-md hover:bg-gray-300">Batal</button>
                        <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700">{{ $isEditMode ? 'Update' : 'Simpan' }}</button>
                    </div>
                </form>
            </div>
        </div>
        @endif
    </div>
</div>
