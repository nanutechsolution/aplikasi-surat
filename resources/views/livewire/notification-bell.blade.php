<div x-data="{ open: false }" class="relative">
    <button @click="open = !open" class="relative p-2 text-gray-500 rounded-full hover:bg-gray-100 hover:text-gray-600 focus:outline-none">
        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
        </svg>
        @if($unreadCount > 0)
            <span class="absolute top-0 right-0 h-5 w-5 -mt-1 -mr-1 flex items-center justify-center rounded-full bg-red-500 text-white text-xs">
                {{ $unreadCount }}
            </span>
        @endif
    </button>

    <div x-show="open" @click.outside="open = false"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="transform opacity-0 scale-95"
         x-transition:enter-end="transform opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-75"
         x-transition:leave-start="transform opacity-100 scale-100"
         x-transition:leave-end="transform opacity-0 scale-95"
         class="absolute right-0 w-80 mt-2 origin-top-right bg-white rounded-md shadow-lg z-50"
         style="display: none;">
        <div class="py-2">
            <div class="px-4 py-2 text-sm font-semibold text-gray-700 border-b">Notifikasi</div>
            <div class="max-h-80 overflow-y-auto">
                @forelse ($unreadNotifications as $notification)
                    <div class="flex items-start px-4 py-3 border-b hover:bg-gray-100 -mx-2">
                        <div class="flex-grow">
                            <p class="text-sm text-gray-700">{{ $notification->data['pesan'] }}</p>
                            <a href="{{ route('surat.lihat', $notification->data['surat_id']) }}" @click="open = false" wire:click="markAsRead('{{ $notification->id }}')" class="text-xs text-blue-600 hover:underline">Lihat Detail</a>
                        </div>
                        <button wire:click="markAsRead('{{ $notification->id }}')" class="ml-2 text-xs text-gray-400 hover:text-gray-600" title="Tandai sudah dibaca">
                            &times;
                        </button>
                    </div>
                @empty
                    <p class="text-sm text-gray-500 text-center py-4">Tidak ada notifikasi baru.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
