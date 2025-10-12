<?php

namespace App\Livewire;

use App\Models\Disposisi;
use App\Models\KategoriDisposisi;
use App\Models\SuratMasuk;
use App\Models\User;
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
    public $kirimDisposisi = false;
    public $tujuan_disposisi;
    public $kategori_disposisi_id;
    public $instruksi_disposisi;
    public $daftarTujuan = [];
    public $daftarKategori = [];

    // Properti untuk search
    public string $search = '';

    // Method untuk membuka modal tambah data
    public function create()
    {
        $this->reset();
        $this->resetValidation();

        $this->daftarTujuan = User::select('id', 'name')
            ->where('id', '!=', auth()->id())
            ->get();

        $this->daftarKategori = KategoriDisposisi::select('id', 'nama')->get();

        $this->sifat_surat = 'Biasa';
        $this->tanggal_diterima = now()->format('Y-m-d');
        $this->pengirim = auth()->user()->name;
        $this->showModal = true;


    }

    public function updatedKirimDisposisi($value)
    {

        if ($value) {
            $this->instruksi_disposisi = '';
            $this->dispatch('init-tom-select');

        } else {
            $this->tujuan_disposisi = null;
            $this->kategori_disposisi_id = null;
            $this->instruksi_disposisi = null;
        }
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
            'perihal' => 'required|string',
            'sifat_surat' => 'required|in:Biasa,Penting,Segera,Rahasia',
            'fileScan' => 'required|file|mimes:pdf,jpg,jpeg,png,webp|max:2048',
            'tujuan_disposisi' => 'nullable|exists:users,id',
            'kategori_disposisi_id' => 'nullable|exists:kategori_disposisi,id',
            'instruksi_disposisi' => 'nullable|string|max:500',
        ];
    }
    public function mount()
    {
        if (auth()->check()) {
            $this->pengirim = auth()->user()->name;
        }

        $this->daftarTujuan = \App\Models\User::select('id', 'name')
            ->where('id', '!=', auth()->id())
            ->get();
        $this->daftarKategori = KategoriDisposisi::select('id', 'nama')->get();
    }



    public function simpan()
    {
        $validatedData = $this->validate();
        $path = $this->fileScan->store('surat-files', 'public');

        $surat = SuratMasuk::create(array_merge($validatedData, [
            'pengirim' => $this->pengirim,
            'file_path' => $path,
            'user_id' => auth()->id(),
        ]));
        // Kalau user pilih kirim disposisi langsung
        if ($this->kirimDisposisi && $this->tujuan_disposisi && $this->kategori_disposisi_id) {
            $disposisi = Disposisi::create([
                'surat_masuk_id' => $surat->id,
                'dari_user_id' => auth()->id(),              // WAJIB
                'kepada_user_id' => $this->tujuan_disposisi, // PASTIKAN pakai nama kolom yg benar
                'kategori_disposisi_id' => $this->kategori_disposisi_id,
                'isi_disposisi' => $this->instruksi_disposisi,
            ]);

            // Notifikasi ke penerima (optional)
            $penerima = User::find($this->tujuan_disposisi);
            if ($penerima) {
                $penerima->notify(new \App\Notifications\DisposisiBaruNotification($disposisi));
            }
        }

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
