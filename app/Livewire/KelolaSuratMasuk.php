<?php

namespace App\Livewire;

use App\Models\SuratMasuk;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;
class KelolaSuratMasuk extends Component
{
    use WithFileUploads;
    use WithPagination;

    #[Layout('layouts.app')]

    public $nomor_surat;
    public $tanggal_surat;
    public $tanggal_diterima;
    public $pengirim;
    public $perihal;
    public $sifat_surat = 'Biasa';
    public $fileScan;
    public string $search = '';
    protected function rules()
    {
        return [
            'nomor_surat' => 'required|string|max:255',
            'tanggal_surat' => 'required|date',
            'tanggal_diterima' => 'required|date|after_or_equal:tanggal_surat',
            'pengirim' => 'required|string|max:255',
            'perihal' => 'required|string',
            'sifat_surat' => 'required|in:Biasa,Penting,Segera,Rahasia',
            'fileScan' => 'required|file|mimes:pdf|max:2048',
        ];
    }

    public function simpan()
    {
        // Jalankan validasi
        $validatedData = $this->validate();

        // Simpan file yang di-upload
        $path = $this->fileScan->store('surat-files', 'public');

        // Simpan data ke database
        SuratMasuk::create([
            'nomor_surat' => $this->nomor_surat,
            'tanggal_surat' => $this->tanggal_surat,
            'tanggal_diterima' => $this->tanggal_diterima,
            'pengirim' => $this->pengirim,
            'perihal' => $this->perihal,
            'sifat_surat' => $this->sifat_surat,
            'file_path' => $path,
            'user_id' => auth()->id(),
        ]);
        $this->dispatch('notify', message: 'Surat berhasil dicatat', type: 'success');
        // Kirim notifikasi sukses

        // Kosongkan kembali form
        $this->reset(['nomor_surat', 'tanggal_surat', 'tanggal_diterima', 'pengirim', 'perihal', 'sifat_surat', 'fileScan']);
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
            ->latest('tanggal_diterima') // Urutkan dari yang terbaru
            ->paginate(10); // Ambil 10 data per halaman

        return view('livewire.kelola-surat-masuk', [
            'suratMasuk' => $suratMasuk,
        ]);
    }
}
