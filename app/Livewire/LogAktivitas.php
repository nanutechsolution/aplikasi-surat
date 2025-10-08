<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Spatie\Activitylog\Models\Activity;

class LogAktivitas extends Component
{
    use WithPagination;

    #[Layout('layouts.app')]

    public function render()
    {
        // Ambil data log, urutkan dari yang terbaru, dan paginasi
        $activities = Activity::with('causer') // Ambil juga data user yang menyebabkan log
            ->latest()
            ->paginate(15);

        return view('livewire.log-aktivitas', [
            'activities' => $activities,
        ]);
    }
}
