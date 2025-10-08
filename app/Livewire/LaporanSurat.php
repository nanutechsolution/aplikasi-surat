<?php

namespace App\Livewire;

use App\Models\SuratKeluar;
use App\Models\SuratMasuk;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\Attributes\Layout;

class LaporanSurat extends Component
{
    #[Layout('layouts.app')]

    // Properti yang di-binding
    public $jenis_surat = 'masuk';
    public $tanggal_mulai;
    public $tanggal_selesai;

    public function mount()
    {
        // Set tanggal default untuk bulan ini
        $this->tanggal_mulai = Carbon::now()->startOfMonth()->format('Y-m-d');
        $this->tanggal_selesai = Carbon::now()->endOfMonth()->format('Y-m-d');
    }

    public function generatePdf()
    {
        $this->validate([
            'jenis_surat' => 'required|in:masuk,keluar',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
        ]);

        $data = [];
        $view = '';

        if ($this->jenis_surat === 'masuk') {
            $data['surat'] = SuratMasuk::whereBetween('tanggal_diterima', [$this->tanggal_mulai, $this->tanggal_selesai])->get();
            $view = 'pdf.laporan-surat-masuk';
        } else {
            $data['surat'] = SuratKeluar::whereBetween('tanggal_surat', [$this->tanggal_mulai, $this->tanggal_selesai])->get();
            $view = 'pdf.laporan-surat-keluar';
        }

        $data['tanggal_mulai'] = $this->tanggal_mulai;
        $data['tanggal_selesai'] = $this->tanggal_selesai;

        $pdf = Pdf::loadView($view, $data)->setPaper('a4', 'landscape');

        // Buat nama file yang dinamis
        $namaFile = 'Laporan Surat ' . ucfirst($this->jenis_surat) . ' ' . $this->tanggal_mulai . ' - ' . $this->tanggal_selesai . '.pdf';

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, $namaFile);
    }

    public function render()
    {
        return view('livewire.laporan-surat');
    }
}
