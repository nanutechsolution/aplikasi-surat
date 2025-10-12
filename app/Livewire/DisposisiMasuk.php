<?php

namespace App\Livewire;

use App\Models\Disposisi;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

class DisposisiMasuk extends Component
{
    use WithPagination;

    #[Layout('layouts.app')]

    public string $search = '';

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    /**
     * Method baru untuk mengubah status disposisi.
     */
    public function tandaiSelesai(Disposisi $disposisi)
    {
        // Pastikan hanya penerima yang bisa mengubah status
        if ($disposisi->kepada_user_id === auth()->id()) {
            $disposisi->update(['status' => 'Selesai']);
            // Opsi: Kirim notifikasi sukses
            session()->flash('status_sukses', 'Status disposisi telah diperbarui.');
        }
    }

    public function render()
    {
        $userId = auth()->id();
        $disposisiData = \App\Models\Disposisi::query()
            ->where('kepada_user_id', $userId)
            ->when($this->search, function ($query) {
                $query->whereHas('suratMasuk', function ($subQuery) {
                    $subQuery->where('perihal', 'like', "%{$this->search}%")
                        ->orWhere('nomor_surat', 'like', "%{$this->search}%");
                });
            })
            ->latest()
            ->paginate(10);

        return view('livewire.disposisi-masuk', [
            'disposisiMasuk' => $disposisiData,
        ]);
    }
}
