<?php

namespace App\Livewire\Disposisi;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Disposisi;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class RiwayatDisposisi extends Component
{
    use WithPagination;

    public $search = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        // Query untuk mengambil riwayat disposisi yang dikirim oleh user yang sedang login
        $riwayat = Disposisi::with([
                'suratMasuk', // Memuat data surat terkait
                'penerima',   // Memuat semua penerima (user) dari pivot table
                'instruksi'   // PERUBAHAN: Menggunakan nama relasi yang benar ('instruksi')
            ])
            ->where('dari_user_id', auth()->id()) // Filter hanya disposisi yang dikirim olehnya
            ->when($this->search, function ($query) {
                // Logika pencarian berdasarkan perihal atau nomor surat
                $query->whereHas('suratMasuk', function ($q) {
                    $q->where('perihal', 'like', '%' . $this->search . '%')
                        ->orWhere('nomor_surat', 'like', '%' . $this->search . '%');
                });
            })
            ->latest() // Urutkan dari yang terbaru
            ->paginate(10);

        return view('livewire.disposisi.riwayat-disposisi', [
            'riwayat' => $riwayat,
        ]);
    }
}
