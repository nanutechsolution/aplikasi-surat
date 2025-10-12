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
    public $chartData = [];
    public function mount()
    {
        $this->totalSurat = SuratMasuk::count();
        $this->suratBulanIni = SuratMasuk::whereMonth('tanggal_diterima', now()->month)->count();
        $this->suratHariIni = SuratMasuk::whereDate('tanggal_diterima', now()->today())->count();
        $this->chartData = $this->getChartData();
    }

    public function getChartData()
    {
        $labels = [];
        $data = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $labels[] = $date->format('d M');
            $data[] = SuratMasuk::whereDate('tanggal_diterima', $date)->count();
        }

        return [
            'labels' => $labels,
            'data' => $data
        ];
    }


    public function render()
    {
        return view('livewire.dashboard-statistik');
    }
}
