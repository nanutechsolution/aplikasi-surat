<?php

namespace App\Livewire;

use App\Models\SuratMasuk;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

class KelolaSuratMasuk extends Component
{
    use WithFileUploads, WithPagination;

    #[Layout('layouts.app')]

    // Properti untuk Modal & Form
    public bool $showModal = false;

    // Properti yang di-binding
    public $nomor_surat, $tanggal_surat, $tanggal_diterima, $pengirim, $perihal, $sifat_surat = 'Biasa', $fileScan;

    // Properti untuk search
    public string $search = '';

    // Method untuk membuka modal tambah data
    public function create()
    {
        $this->reset();
        $this->resetValidation();
        $this->sifat_surat = 'Biasa';
        $this->tanggal_diterima = now()->format('Y-m-d');
        $this->showModal = true;


    }

    // Method untuk menutup modal
    public function closeModal()
    {
        $this->showModal = false;
        $this->reset();
        $this->resetValidation();
    }

    protected function rules()
    {
        return [
            'nomor_surat' => 'required|string|max:255|unique:surat_masuk',
            'tanggal_surat' => 'required|date',
            'tanggal_diterima' => 'required|date|after_or_equal:tanggal_surat',
            'pengirim' => 'required|string|max:255',
            'perihal' => 'required|string',
            'sifat_surat' => 'required|in:Biasa,Penting,Segera,Rahasia',
            'fileScan' => 'required|file|mimes:pdf,jpg,jpeg,png,webp|max:2048',
        ];
    }

    public function simpan()
    {
        $validatedData = $this->validate();
        $path = $this->fileScan->store('surat-files', 'public');

        SuratMasuk::create(array_merge($validatedData, [
            'file_path' => $path,
            'user_id' => auth()->id(),
        ]));

        $this->closeModal();
        $this->dispatch('notify', message: 'Surat masuk berhasil dicatat.', type: 'success');
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function render()
    {
        $suratMasuk = SuratMasuk::query()
            ->when($this->search, function ($query) {
                $query->where('nomor_surat', 'like', "%{$this->search}%")
                    ->orWhere('perihal', 'like', "%{$this->search}%")
                    ->orWhere('pengirim', 'like', "%{$this->search}%");
            })
            ->latest('tanggal_diterima')
            ->paginate(10);

        return view('livewire.kelola-surat-masuk', [
            'suratMasuk' => $suratMasuk,
        ]);
    }
}
