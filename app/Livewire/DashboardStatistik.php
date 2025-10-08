<?php

namespace App\Livewire;

use App\Models\SuratMasuk;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\Attributes\Layout;

class DashboardStatistik extends Component
{
    #[Layout('layouts.app')]

    public $totalSurat;
    public $suratBulanIni;
    public $suratHariIni;
    public $chartData;

    public function mount()
    {
        $this->totalSurat = SuratMasuk::count();
        $this->suratBulanIni = SuratMasuk::whereMonth('tanggal_diterima', now()->month)->count();
        $this->suratHariIni = SuratMasuk::whereDate('tanggal_diterima', now()->today())->count();
        $this->loadChartData();
    }

    public function loadChartData()
    {
        $labels = [];
        $data = [];
        // Ambil data untuk 7 hari terakhir, dari 6 hari lalu sampai hari ini
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $labels[] = $date->format('d M'); // Format label (misal: 09 Oct)

            $count = SuratMasuk::whereDate('tanggal_diterima', $date)->count();
            $data[] = $count;
        }

        $this->chartData = [
            'labels' => $labels,
            'data' => $data,
        ];

        // Kirim data ke browser untuk di-render oleh Alpine.js
        $this->dispatch('updateChart', data: $this->chartData);
    }

    public function render()
    {
        return view('livewire.dashboard-statistik');
    }
}
