<div class="p-4 sm:p-6 lg:p-8">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <h2 class="text-2xl font-semibold text-gray-800">
                Manajemen Role & Hak Akses
            </h2>
            <p class="text-sm text-gray-600 mt-1">
                Pilih sebuah role untuk melihat dan mengubah hak akses yang dimilikinya.
            </p>
        </div>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <form wire:submit="simpan">
                    <!-- Dropdown Pilih Role -->
                    <div>
                        <label for="role_select" class="block text-sm font-medium text-gray-700">Pilih Role</label>
                        <select id="role_select" wire:model.live="selectedRoleId" class="mt-1 block w-full md:w-1/3 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">-- Pilih Role --</option>
                            @foreach ($roles as $role)
                            <option value="{{ $role->id }}">{{ Str::title($role->name) }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Tampilkan daftar permissions hanya jika sebuah role sudah dipilih -->
                    @if ($selectedRoleId)
                    <div class="mt-6">
                        <h3 class="text-lg font-medium text-gray-900">Hak Akses (Permissions)</h3>
                        <div class="mt-4 grid grid-cols-2 md:grid-cols-4 gap-4">
                            @forelse ($permissions as $permission)
                            <label for="permission_{{ $permission->id }}" class="flex items-center space-x-2 p-2 border rounded-md hover:bg-gray-50 cursor-pointer">
                                <input type="checkbox" id="permission_{{ $permission->id }}" wire:model="selectedPermissions" value="{{ $permission->name }}" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                                <span class="text-sm text-gray-800">{{ $permission->name }}</span>
                            </label>
                            @empty
                            <p class="col-span-full text-sm text-gray-500">Tidak ada data hak akses. Jalankan PermissionSeeder.</p>
                            @endforelse
                        </div>
                    </div>

                    <!-- Tombol Simpan -->
                    <div class="flex justify-end pt-4 mt-6 border-t">
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700">
                            Simpan Perubahan
                        </button>
                    </div>
                    @endif
                </form>
            </div>
        </div>
    </div>
</div>
