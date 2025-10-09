<?php

namespace App\Exports;

use App\Models\SuratKeluar;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class SuratKeluarExport implements FromCollection, WithHeadings, WithMapping
{
    protected $tanggal_mulai;
    protected $tanggal_selesai;

    public function __construct(string $tanggal_mulai, string $tanggal_selesai)
    {
        $this->tanggal_mulai = $tanggal_mulai;
        $this->tanggal_selesai = $tanggal_selesai;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        // BENAR: Menggunakan 'tanggal_surat' dari tabel surat_keluar
        return SuratKeluar::whereBetween('tanggal_surat', [$this->tanggal_mulai, $this->tanggal_selesai])
            ->latest('tanggal_surat')
            ->get();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        // BENAR: Menyesuaikan judul kolom dengan data Surat Keluar
        return [
            'Nomor Surat',
            'Perihal',
            'Tujuan',
            'Tanggal Surat',
            'Dicatat Oleh',
        ];
    }

    /**
     * @param SuratKeluar $surat
     * @return array
     */
    public function map($surat): array
    {
        // BENAR: Memetakan data sesuai kolom Surat Keluar
        return [
            $surat->nomor_surat,
            $surat->perihal,
            $surat->tujuan, // Mengganti 'pengirim' dengan 'tujuan'
            $surat->tanggal_surat->format('d-m-Y'),
            $surat->user->name ?? 'N/A',
        ];
    }
}
