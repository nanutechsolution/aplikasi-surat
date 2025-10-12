<div class="bg-white shadow-sm sm:rounded-lg mt-8">
    <div class="p-6 bg-white border-b border-gray-200">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Kirim Disposisi</h3>
        <form wire:submit="kirim">
            <div class="space-y-4">
                <div>
                    <label for="kepada_user_id" class="block text-sm font-medium text-gray-700">Tujuan</label>
                    <select id="kepada_user_id" wire:model="kepada_user_id" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                        @if($users->isEmpty())
                        <option disabled>Tidak ada user lain</option>
                        @else
                        @foreach ($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                        @endif
                    </select>
                    @error('kepada_user_id') <span class="text-xs text-red-600">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label for="kategori_disposisi_id" class="block text-sm font-medium text-gray-700">
                        Disposisi
                    </label>
                    <select id="kategori_disposisi_id" wire:model="kategori_disposisi_id" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                        @if($kategori->isEmpty())
                        <option disabled>Tidak ada kategori</option>
                        @else
                        @foreach ($kategori as $kat)
                        <option value="{{ $kat->id }}">{{ $kat->nama }}</option>
                        @endforeach
                        @endif
                    </select>
                    @error('kategori_disposisi_id')
                    <span class="text-xs text-red-600">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="isi_disposisi" class="block text-sm font-medium text-gray-700">Keterangan</label>
                    <textarea id="isi_disposisi" wire:model="isi_disposisi" rows="4" class="mt-1 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border border-gray-300 rounded-md" placeholder="Tulis instruksi Anda di sini..."></textarea>
                    @error('isi_disposisi') <span class="text-xs text-red-600">{{ $message }}</span> @enderror
                </div>
                <div class="text-right">
                    <button type="submit" wire:loading.attr="disabled" wire:target="kirim" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 min-w-[120px]">

                        <span wire:loading.class="hidden" wire:target="kirim">
                            Kirim Disposisi
                        </span>

                        <span class="hidden" wire:loading.class.remove="hidden" wire:target="kirim">
                            Mengirim...
                        </span>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
