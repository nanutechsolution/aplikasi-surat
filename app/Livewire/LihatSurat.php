<?php

namespace App\Livewire;

use App\Models\SuratMasuk;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
class LihatSurat extends Component
{
    #[Layout('layouts.app')]

    public SuratMasuk $surat; // Properti untuk menampung data surat

    // Method mount dipanggil saat komponen dibuat
    // Laravel akan otomatis meng-inject model SuratMasuk berkat Route Model Binding
    public function mount(SuratMasuk $surat)
    {
        $this->surat = $surat;
    }
    public function delete()
    {
        // 1. Hapus file fisik dari storage
        Storage::disk('public')->delete($this->surat->file_path);

        // 2. Hapus record dari database
        $this->surat->delete();

        // 3. Kirim notifikasi sukses
        session()->flash('sukses', 'Surat berhasil dihapus.');

        // 4. Arahkan pengguna kembali ke halaman daftar
        return $this->redirect(route('surat-masuk'), navigate: true);
    }

    #[On('disposisiTerkirim')]
    public function refreshDisposisiList()
    {
        // Cukup dengan method kosong, Livewire akan otomatis me-refresh komponen
        // dan mengambil data disposisi yang baru.
    }
    public function render()
    {
        return view('livewire.lihat-surat');
    }
}
