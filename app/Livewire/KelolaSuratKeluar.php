<?php

namespace App\Livewire;

use App\Models\SuratKeluar;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;

class KelolaSuratKeluar extends Component
{
    use WithPagination, WithFileUploads;

    #[Layout('layouts.app')]

    // Properti untuk Modal & Form
    public bool $showModal = false;
    public bool $isEditMode = false;
    public ?SuratKeluar $surat;

    // Properti yang di-binding
    public $nomor_surat, $tanggal_surat, $tujuan, $perihal, $fileScan, $existingFilePath;

    public function create()
    {
        $this->resetValidation();
        $this->reset();
        $this->isEditMode = false;
        $this->showModal = true;
    }

    public function edit(SuratKeluar $surat)
    {
        $this->resetValidation();
        $this->isEditMode = true;
        $this->surat = $surat;
        $this->nomor_surat = $surat->nomor_surat;
        $this->tanggal_surat = $surat->tanggal_surat->format('Y-m-d');
        $this->tujuan = $surat->tujuan;
        $this->perihal = $surat->perihal;
        $this->existingFilePath = $surat->file_path;
        $this->showModal = true;
    }

    public function save()
    {
        $rules = [
            'nomor_surat'   => 'required|string|max:255|unique:surat_keluar,nomor_surat,' . ($this->isEditMode ? $this->surat->id : ''),
            'tanggal_surat' => 'required|date',
            'tujuan'        => 'required|string|max:255',
            'perihal'       => 'required|string',
            'fileScan'      => $this->isEditMode ? 'nullable|file|mimes:pdf|max:2048' : 'required|file|mimes:pdf|max:2048',
        ];

        $validatedData = $this->validate($rules);

        if ($this->isEditMode) {
            $filePath = $this->existingFilePath;
            if ($this->fileScan) {
                Storage::disk('public')->delete($this->existingFilePath);
                $filePath = $this->fileScan->store('surat-keluar-files', 'public');
            }
            $this->surat->update(array_merge($validatedData, ['file_path' => $filePath]));
            session()->flash('sukses', 'Surat keluar berhasil diperbarui.');
        } else {
            $filePath = $this->fileScan->store('surat-keluar-files', 'public');
            SuratKeluar::create(array_merge($validatedData, [
                'file_path' => $filePath,
                'user_id' => auth()->id()
            ]));
            session()->flash('sukses', 'Surat keluar berhasil ditambahkan.');
        }
        $this->closeModal();
    }

    public function closeModal()
    {
        $this->reset();
        $this->resetValidation();
    }

    public function render()
    {
        return view('livewire.kelola-surat-keluar', [
            'suratKeluarList' => SuratKeluar::latest()->paginate(10),
        ]);
    }
}
