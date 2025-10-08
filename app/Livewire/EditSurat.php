<?php

namespace App\Livewire;

use App\Models\SuratMasuk;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;

class EditSurat extends Component
{
    use WithFileUploads;

    #[Layout('layouts.app')]

    public SuratMasuk $surat;

    // Properti yang di-binding dengan form
    public $nomor_surat;
    public $tanggal_surat;
    public $tanggal_diterima;
    public $pengirim;
    public $perihal;
    public $sifat_surat;
    public $fileScan; // Untuk file baru
    public $existingFilePath;

    public function mount(SuratMasuk $surat)
    {
        $this->surat = $surat;
        $this->nomor_surat = $surat->nomor_surat;
        $this->tanggal_surat = $surat->tanggal_surat->format('Y-m-d');
        $this->tanggal_diterima = $surat->tanggal_diterima->format('Y-m-d');
        $this->pengirim = $surat->pengirim;
        $this->perihal = $surat->perihal;
        $this->sifat_surat = $surat->sifat_surat;
        $this->existingFilePath = $surat->file_path;
    }

    protected function rules()
    {
        return [
            'nomor_surat'      => 'required|string|max:255',
            'tanggal_surat'    => 'required|date',
            'tanggal_diterima' => 'required|date|after_or_equal:tanggal_surat',
            'pengirim'         => 'required|string|max:255',
            'perihal'          => 'required|string',
            'sifat_surat'      => 'required|in:Biasa,Penting,Segera,Rahasia',
            'fileScan'         => 'nullable|file|mimes:pdf|max:2048', // Boleh kosong
        ];
    }

    public function update()
    {
        $this->validate();

        $filePath = $this->existingFilePath;

        // Jika ada file baru yang di-upload
        if ($this->fileScan) {
            // Hapus file lama
            Storage::disk('public')->delete($this->existingFilePath);
            // Simpan file baru
            $filePath = $this->fileScan->store('surat-files', 'public');
        }

        $this->surat->update([
            'nomor_surat'      => $this->nomor_surat,
            'tanggal_surat'    => $this->tanggal_surat,
            'tanggal_diterima' => $this->tanggal_diterima,
            'pengirim'         => $this->pengirim,
            'perihal'          => $this->perihal,
            'sifat_surat'      => $this->sifat_surat,
            'file_path'        => $filePath,
        ]);
        $this->dispatch('notify', message: 'Data surat berhasil diperbarui', type: 'success');
        return $this->redirect(route('surat.lihat', $this->surat), navigate: true);
    }


    public function render()
    {
        return view('livewire.edit-surat');
    }
}
