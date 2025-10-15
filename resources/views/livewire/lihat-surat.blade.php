<div class="p-4 sm:p-6 lg:p-8" x-data="{ showDeleteModal: false }">
    <div class="max-w-7xl mx-auto">

        <div class="mb-6">
            <a href="{{ route('surat-masuk') }}" wire:navigate class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-800 text-sm font-medium rounded-md hover:bg-gray-300">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali ke Daftar
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            {{-- Kolom Kiri: Pratinjau Dokumen --}}
            <div class="lg:col-span-2">
                <div class="bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Pratinjau Dokumen</h3>
                        <div class="w-full h-[80vh] bg-gray-100 rounded-md">
                            @if($fileType === 'pdf')
                            <iframe src="{{ asset('storage/' . $surat->file_path) }}" width="100%" height="100%" frameborder="0"></iframe>
                            @elseif($fileType === 'image')
                            <img src="{{ asset('storage/' . $surat->file_path) }}" alt="Lampiran Gambar" class="w-full h-full object-contain">
                            @else
                            <div class="flex items-center justify-center h-full">
                                <p class="text-gray-500">Pratinjau tidak tersedia untuk tipe file ini.</p>
                            </div>
                            @endif
                        </div>
                        <a href="{{ asset('storage/' . $surat->file_path) }}" download class="inline-block mt-4 text-sm text-blue-600 hover:text-blue-800">
                            Unduh Dokumen
                        </a>
                    </div>
                </div>
            </div>

            {{-- Kolom Kanan: Detail, Aksi, dan Riwayat --}}
            <div class="lg:col-span-1 space-y-8">
                {{-- Informasi Detail Surat --}}
                <div class="bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-6">Informasi Detail Surat</h3>
                        <div class="space-y-4">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Perihal</dt>
                                <dd class="mt-1 text-base font-semibold text-gray-900">{{ $surat->perihal }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Nomor Surat</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $surat->nomor_surat }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Pengirim</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $surat->pengirim }}</dd>
                            </div>
                            <div class="grid grid-cols-2 gap-4 pt-2">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Tanggal Surat</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $surat->tanggal_surat->format('d F Y') }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Tanggal Diterima</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $surat->tanggal_diterima->format('d F Y') }}</dd>
                                </div>
                            </div>
                            <div class="grid grid-cols-3 gap-4 pt-2">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Sifat</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $surat->sifat_surat }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Klasifikasi</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $surat->klasifikasi }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Derajat</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $surat->derajat }}</dd>
                                </div>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Dicatat oleh</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $surat->user->name }}</dd>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Aksi Surat --}}
                <div class="bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h4 class="text-lg font-semibold text-gray-900 mb-4">Aksi Surat</h4>
                        <div class="space-y-3">
                            @if($surat->disposisi->isNotEmpty())
                            <button onclick="printDisposisi()" class="inline-flex items-center justify-center w-full px-4 py-2 bg-gray-600 text-white text-sm font-medium rounded-md hover:bg-gray-700">
                                Cetak Lembar Disposisi
                            </button>
                            @else
                            <div class="text-center p-3 bg-gray-50 rounded-md">
                                <p class="text-xs text-gray-500">Fitur cetak akan tersedia setelah disposisi dibuat.</p>
                            </div>
                            @endif

                            @can('kelola surat')
                            <a href="{{ route('surat.edit', $surat) }}" wire:navigate class="inline-flex items-center justify-center w-full px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700">
                                Edit Surat
                            </a>
                            @endcan
                            @role('admin')
                            <button @click="showDeleteModal = true" class="inline-flex items-center justify-center w-full px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-md hover:bg-red-700">
                                Hapus Surat
                            </button>
                            @endrole
                        </div>
                    </div>
                </div>

                {{-- Riwayat Disposisi --}}
                <div class="bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Riwayat Disposisi</h3>
                        <div class="space-y-6">
                            @forelse ($surat->disposisi->sortByDesc('created_at') as $item)
                            <div class="relative pl-8 border-l border-gray-200">
                                <div class="absolute top-1 left-[-9px] w-4 h-4 bg-blue-500 rounded-full border-2 border-white"></div>
                                <p class="text-sm font-semibold text-gray-800">
                                    {{ $item->pengirim->name }}
                                </p>
                                <p class="text-xs text-gray-500">
                                    Kepada:
                                    @foreach($item->penerima as $penerima)
                                    <span class="font-medium text-gray-700">{{ $penerima->name }}</span>{{ !$loop->last ? ',' : '' }}
                                    @endforeach
                                </p>
                                <div class="flex flex-wrap gap-1 mt-2">
                                    @foreach($item->instruksi as $instruksi)
                                    <span class="text-xs bg-gray-200 text-gray-800 px-2 py-1 rounded-full">{{ $instruksi->nama }}</span>
                                    @endforeach
                                </div>
                                @if($item->catatan)
                                <p class="text-sm text-gray-600 mt-2 p-2 bg-gray-50 rounded-md">"{{ $item->catatan }}"</p>
                                @endif
                                <p class="text-xs text-gray-400 mt-2">{{ $item->created_at->diffForHumans() }}</p>
                            </div>
                            @empty
                            <p class="text-sm text-gray-500">Belum ada disposisi untuk surat ini.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    {{-- Modal Konfirmasi Hapus --}}
    <div x-show="showDeleteModal" @keydown.escape.window="showDeleteModal = false" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black bg-opacity-50" style="display: none;">
        <div @click.outside="showDeleteModal = false" class="relative w-full max-w-md p-6 bg-white rounded-lg shadow-xl">
            <h3 class="text-lg font-bold text-gray-900">Konfirmasi Penghapusan</h3>
            <p class="mt-2 text-sm text-gray-600">
                Apakah Anda yakin ingin menghapus surat ini? Tindakan ini tidak dapat diurungkan.
            </p>
            <div class="mt-6 flex justify-end space-x-3">
                <button @click="showDeleteModal = false" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-200 rounded-md hover:bg-gray-300">
                    Batal
                </button>
                <button wire:click="delete" @click="showDeleteModal = false" class="px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-md hover:bg-red-700">
                    Ya, Hapus
                </button>
            </div>
        </div>
    </div>

    @if($surat->disposisi->isNotEmpty())
    {{-- AREA CETAK (Tersembunyi) --}}
    <div id="lembar-disposisi" class="hidden">
        @php
        $disposisiCetak = $surat->disposisi->first();
        $penerimaCetak = $disposisiCetak ? $disposisiCetak->penerima->pluck('name')->all() : [];
        $instruksiCetak = $disposisiCetak ? $disposisiCetak->instruksi->pluck('nama')->all() : [];
        $daftarTujuanForm = [
        'KASUBDIT 24.1', 'KASUBDIT 24.2', 'KASUBDIT 24.3', 'KASUBDIT 24.4',
        'TIM ANEV', 'TIM MONEV', 'KOORD. TIM ANEV DE II', 'TATA USAHA',
        '', '', ''
        ];
        $daftarInstruksiForm = [
        ['UDL', 'Siapkan Bahan'], ['UDK', 'Siapkan Jawaban'], ['Menghadap', 'Koordinasikan'],
        ['Wakili', 'Jadwalkan'], ['Acc', 'Monitor'], ['Pelajari/Teliti', 'Cek Kembali'],
        ['Catat', 'Edarkan'], ['Balas', 'Laporkan Hasil'], ['Pedoman', 'Saran'],
        ['Tindak Lanjuti', 'Rencanakan'], ['Selesaikan', 'Dalami'], ['Bahan Masukan', 'Arsip'],
        ['Ingatkan', 'Sesuai Juk Pimpinan'], ['Dukung', 'Copy']
        ];
        $totalRows = count($daftarInstruksiForm);
        @endphp
        <div class="font-sans text-xs p-4">
            <h2 class="text-center font-bold text-sm mb-4">LEMBAR DISPOSISI DIREKTUR-24</h2>

            <table class="w-full border-collapse border-black text-xs">
                <tbody>
                    <tr class="border-t border-l border-r border-black">
                        <td class="w-[30%] p-1"></td>
                        <td class="p-1 border-l border-black" colspan="2"><strong>KLASIFIKASI:</strong> {{ $surat->klasifikasi }}</td>
                        <td class="p-1 border-l border-black" colspan="2"><strong>DERAJAT:</strong> {{ $surat->derajat }}</td>
                    </tr>
                    <tr>
                        <td class="w-[15%] border-t border-l border-r border-black p-1 text-center align-middle" rowspan="3"><strong>PENGIRIM</strong></td>
                        <td class="w-[15%] border-t border-l border-r border-black p-1"><strong>DARI</strong></td>
                        <td class="border-t border-r border-black p-1">{{ $surat->pengirim }}</td>
                        <td class="w-[10%] border-t border-l border-r border-black p-1"><strong>TGL.</strong></td>
                        <td class="border-t border-r border-black p-1">{{ $surat->tanggal_surat->format('d-m-Y') }}</td>
                    </tr>
                    <tr>
                        <td class="border-t border-l border-r border-black p-1"><strong>NOMOR</strong></td>
                        <td class="border-t border-r border-black p-1" colspan="3">{{ $surat->nomor_surat }}</td>
                    </tr>
                    <tr>
                        <td class="border-t border-l border-r border-black p-1"><strong>LAMPIRAN</strong></td>
                        <td class="border-t border-r border-black p-1 h-4" colspan="3">&nbsp;</td>
                    </tr>
                    <tr>
                        <td class="w-[15%] border-t border-l border-r border-black p-1 text-center align-middle" rowspan="2"><strong>AGENDA</strong></td>
                        <td class="w-[15%] border-t border-l border-r border-black p-1"><strong>NOMOR</strong></td>
                        <td class="border-t border-r border-black p-1 h-4">&nbsp;</td>
                        <td class="w-[10%] border-t border-l border-r border-black p-1"><strong>Cat. Arsip:</strong></td>
                        <td class="border-t border-r border-black p-1 h-4">&nbsp;</td>
                    </tr>
                    <tr>
                        <td class="border-t border-b border-l border-r border-black p-1"><strong>TGL/WAKTU</strong></td>
                        <td class="border-t border-b border-r border-black p-1">{{ $surat->tanggal_diterima->format('d-m-Y') }}</td>
                        <td class="border-t border-b border-l border-r border-black p-1"><strong>Pukul:</strong></td>
                        <td class="border-t border-b border-r border-black p-1 h-4">&nbsp;</td>
                    </tr>
                </tbody>
            </table>

            <table class="w-full border-collapse border border-black mt-2 text-xs">
                <thead>
                    <tr class="border-b-2 border-black">
                        <th class="p-1 text-center" rowspan="2" colspan="2">DIAJUKAN/DITERUSKAN KEPADA YTH.</th>
                        <th class="p-1 text-center border-l border-black" rowspan="2">PARAF</th>
                        <th class="p-1 text-center border-l border-black" colspan="2">TANGGAL</th>
                        <th class="p-1 text-center border-l border-black" colspan="2" rowspan="2">DISPOSISI</th>
                    </tr>
                    <tr class="border-b-2 border-black">
                        <th class="p-1 text-center border-t border-l border-black">MULAI</th>
                        <th class="p-1 text-center border-t border-l border-black">KEMBALI</th>
                    </tr>
                </thead>
                <tbody>
                    @for ($i = 0; $i < $totalRows; $i++) <tr class="border-t border-black">
                        <td class="border-r border-black p-1 text-center align-top w-[5%]">
                            @if ($i < 11) {{ $i + 1 }} @else &nbsp; @endif </td>
                        <td class="border-r border-black p-1 align-top w-[30%]">
                            @if ($i < count($daftarTujuanForm) && $daftarTujuanForm[$i] !='' ) <span class="inline-block w-4 text-center">
                                @if(in_array($daftarTujuanForm[$i], $penerimaCetak)) ✓ @else &nbsp; @endif
                                </span>
                                <span>{{ $daftarTujuanForm[$i] }}</span>
                                @else
                                &nbsp;
                                @endif
                        </td>
                        <td class="border-r border-black p-1 h-6"></td>
                        <td class="border-r border-black p-1"></td>
                        <td class="border-r border-black p-1"></td>

                        @php $row = $daftarInstruksiForm[$i]; @endphp
                        <td class="border-r border-black p-1 w-[20%]">
                            <span class="inline-block border border-black w-3 h-3 mr-1">@if(in_array($row[0], $instruksiCetak)) ✓ @endif</span>{{ $row[0] }}
                        </td>
                        <td class="p-1 w-[20%]">
                            <span class="inline-block border border-black w-3 h-3 mr-1">@if(in_array($row[1], $instruksiCetak)) ✓ @endif</span>{{ $row[1] }}
                        </td>
                        </tr>
                        @endfor
                </tbody>
            </table>
            <div class="border-l border-r border-b border-black p-1">
                <p><strong>CATATAN:</strong></p>
                <p class="mt-1 h-16">{{ $disposisiCetak->catatan ?? '' }}</p>
            </div>
        </div>
    </div>

    <style>
        @media print {
            @page {
                size: A4;
                margin: 0;
            }

            body * {
                visibility: hidden;
            }

            #lembar-disposisi,
            #lembar-disposisi * {
                visibility: visible;
            }

            #lembar-disposisi {
                display: block !important;
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
            }
        }

    </style>
    <script>
        function printDisposisi() {
            window.print();
        }

    </script>
    @endif
</div>
