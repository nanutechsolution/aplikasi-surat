<?php

namespace App\Livewire;

use App\Models\Disposisi;
use App\Models\KategoriDisposisi;
use App\Models\SuratMasuk;
use App\Models\User;
use Illuminate\Support\Collection;
use Livewire\Component;
use App\Notifications\DisposisiBaruNotification;
class FormDisposisi extends Component
{
    public SuratMasuk $surat;
    public Collection $users;

    // Properti yang terhubung ke form
    public $kepada_user_id;
    public $isi_disposisi;
    public $kategori_disposisi_id;
    public $kategori;
    public function mount(SuratMasuk $surat)
    {
        $this->surat = $surat;
        // Ambil semua user kecuali diri sendiri, untuk pilihan tujuan disposisi
        $this->users = User::where('id', '!=', auth()->id())->get();
        $this->kategori = KategoriDisposisi::all();

        // Set user pertama sebagai default jika ada
        if ($this->users->isNotEmpty()) {
            $this->kepada_user_id = $this->users->first()->id;
        }

        if ($this->kategori->isNotEmpty()) {
            $this->kategori_disposisi_id = $this->kategori->first()->id;
        }

    }

    protected function rules()
    {
        return [
            'kepada_user_id' => 'required|exists:users,id',
            'isi_disposisi' => 'required|string|min:5',
            'kategori_disposisi_id' => 'nullable|exists:kategori_disposisi,id',
        ];
    }

    public function kirim()
    {
        $this->validate();

        $disposisiBaru = Disposisi::create([
            'surat_masuk_id' => $this->surat->id,
            'dari_user_id' => auth()->id(),
            'kepada_user_id' => $this->kepada_user_id,
            'isi_disposisi' => $this->isi_disposisi,
            'kategori_disposisi_id' => $this->kategori_disposisi_id,

        ]);
        $penerima = User::find($this->kepada_user_id);
        if ($penerima) {
            $penerima->notify(new DisposisiBaruNotification($disposisiBaru));
        }
        // Kosongkan form setelah berhasil
        $this->reset('isi_disposisi');

        // Kirim event untuk memberitahu komponen lain bahwa disposisi berhasil dikirim
        $this->dispatch('disposisiTerkirim');

        // Opsi: Kirim notifikasi sukses ke user
        // session()->flash('sukses', 'Disposisi berhasil dikirim.');
    }

    public function render()
    {
        return view('livewire.form-disposisi');
    }
}
