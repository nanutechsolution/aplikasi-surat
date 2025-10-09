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
    public string $fileType;
    // Method mount dipanggil saat komponen dibuat
    // Laravel akan otomatis meng-inject model SuratMasuk berkat Route Model Binding

    public string $dispositionFlowchart = '';
    public function mount(SuratMasuk $surat)
    {
        $this->surat = $surat;
        $this->determineFileType();
        $this->generateFlowchart();
    }
    private function determineFileType()
    {
        $extension = strtolower(pathinfo($this->surat->file_path, PATHINFO_EXTENSION));
        if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
            $this->fileType = 'image';
        } elseif ($extension === 'pdf') {
            $this->fileType = 'pdf';
        } else {
            $this->fileType = 'other';
        }
    }

    private function generateFlowchart()
    {
        $flow = "graph TD\n"; // Mulai diagram (Top to Down)
        $flow .= "    A[Surat Diterima] --> B({$this->surat->user->name});\n";

        // Urutkan disposisi dari yang paling lama ke paling baru
        $disposisiHistory = $this->surat->disposisi->sortBy('created_at');

        if ($disposisiHistory->isNotEmpty()) {
            $lastNode = 'B';
            foreach ($disposisiHistory as $index => $item) {
                $currentNode = 'N' . $index;
                $flow .= "    {$lastNode} -- \"{$item->isi_disposisi}\" --> {$currentNode}({$item->penerima->name});\n";

                // Tambahkan style berdasarkan status
                if ($item->status === 'Selesai') {
                    $flow .= "    style {$currentNode} fill:#d1fae5,stroke:#065f46,stroke-width:2px\n";
                }

                $lastNode = $currentNode;
            }
        }

        $this->dispositionFlowchart = $flow;
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
        $this->surat->refresh();
        $this->generateFlowchart();

        $this->dispatch('rerender-mermaid');
    }
    public function render()
    {
        return view('livewire.lihat-surat');
    }
}
