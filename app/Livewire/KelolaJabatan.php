<?php

namespace App\Livewire;

use App\Models\Jabatan;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class KelolaJabatan extends Component
{
    use WithPagination;

    // Properti untuk modal dan form
    public bool $showModal = false;
    public $jabatanId;
    public $nama;

    // Method untuk membuka modal tambah
    public function create()
    {
        $this->reset(['jabatanId', 'nama']);
        $this->resetValidation();
        $this->showModal = true;
    }

    // Method untuk membuka modal edit
    public function edit($id)
    {
        $jabatan = Jabatan::findOrFail($id);
        $this->jabatanId = $jabatan->id;
        $this->nama = $jabatan->nama;
        $this->resetValidation();
        $this->showModal = true;
    }

    // Method untuk menyimpan (menangani Create & Update)
    public function simpan()
    {
        // Validasi, dengan aturan 'unique' yang mengabaikan ID saat ini
        $validatedData = $this->validate([
            'nama' => 'required|string|min:3|max:255|unique:jabatan,nama,' . $this->jabatanId
        ]);

        Jabatan::updateOrCreate(['id' => $this->jabatanId], [
            'nama' => $validatedData['nama'],
        ]);

        $this->closeModal();
        $this->dispatch('notify', message: 'Jabatan berhasil disimpan.', type: 'success');
    }

    // Method untuk menghapus
    public function hapus($id)
    {
        // Anda bisa menambahkan pengecekan di sini, misalnya jangan hapus jabatan jika masih ada user
        Jabatan::findOrFail($id)->delete();
        $this->dispatch('notify', message: 'Jabatan berhasil dihapus.', type: 'success');
    }

    // Method untuk menutup modal
    public function closeModal()
    {
        $this->showModal = false;
    }

    public function render()
    {
        return view('livewire.kelola-jabatan', [
            'daftarJabatan' => Jabatan::latest()->paginate(10),
        ]);
    }
}
