<?php

namespace App\Livewire\Disposisi;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Disposisi;

use Livewire\Attributes\Layout;
class RiwayatDisposisi extends Component
{
    use WithPagination;
    #[Layout('layouts.app')]
    public $search = '';

    public function render()
    {
        $riwayat = Disposisi::with(['suratMasuk', 'penerima', 'kategori'])
            ->where('dari_user_id', auth()->id()) // ✅ hanya disposisi yang dikirim oleh user ini
            ->when($this->search, function ($query) {
                $query->whereHas('suratMasuk', function ($q) {
                    $q->where('perihal', 'like', '%' . $this->search . '%')
                        ->orWhere('nomor_surat', 'like', '%' . $this->search . '%');
                });
            })
            ->latest()
            ->paginate(10);

        return view('livewire.disposisi.riwayat-disposisi', [
            'riwayat' => $riwayat,
        ]);
    }
}
