<?php

namespace App\Livewire;

use App\Models\SuratMasuk;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;

#[Layout('layouts.app')]
class LihatSurat extends Component
{
    #[Layout('layouts.app')]

    public SuratMasuk $surat;
    public string $fileType;
    public string $dispositionFlowchart = '';

    public function mount(SuratMasuk $surat)
    {
        $this->surat = $surat->load('disposisi.pengirim', 'disposisi.penerima', 'disposisi.instruksi');
        $this->determineFileType();
        $this->generateFlowchart();
        $this->dispatch('rerender-mermaid');
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
        $flow = "graph TD\n";
        $flow .= "    A[Surat Diterima] --> B({$this->surat->user->name});\n";

        // PERUBAHAN: Logika flowchart disesuaikan dengan relasi HasMany
        $disposisiHistory = $this->surat->disposisi->sortBy('created_at');

        if ($disposisiHistory->isNotEmpty()) {
            $lastNode = 'B';
            foreach ($disposisiHistory as $index => $item) {
                // Gabungkan nama penerima
                $penerimaNames = $item->penerima->pluck('name')->implode(', ');
                $currentNode = 'N' . $index;
                // Gunakan 'catatan' sebagai label
                $label = $item->catatan ? "\"{$item->catatan}\"" : '';
                $flow .= "    {$lastNode} -- {$label} --> {$currentNode}({$penerimaNames});\n";
                $lastNode = $currentNode;
            }
        }

        $this->dispositionFlowchart = $flow;
    }

    public function delete()
    {
        Storage::disk('public')->delete($this->surat->file_path);
        $this->surat->delete();
        session()->flash('sukses', 'Surat berhasil dihapus.');
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
