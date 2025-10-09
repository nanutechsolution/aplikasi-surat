<?php

namespace App\Exports;

use App\Models\SuratMasuk;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class SuratMasukExport implements FromCollection, WithHeadings, WithMapping
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
        // Ubah query untuk menggunakan whereBetween berdasarkan tanggal
        return SuratMasuk::whereBetween('tanggal_diterima', [$this->tanggal_mulai, $this->tanggal_selesai])
            ->latest('tanggal_diterima')
            ->get();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        // Mendefinisikan judul kolom di file Excel
        return [
            'Nomor Surat',
            'Perihal',
            'Pengirim',
            'Sifat Surat',
            'Tanggal Surat',
            'Tanggal Diterima',
            'Dicatat Oleh',
        ];
    }

    /**
     * @param SuratMasuk $surat
     * @return array
     */
    public function map($surat): array
    {
        // Memetakan setiap baris data ke kolom yang sesuai
        return [
            $surat->nomor_surat,
            $surat->perihal,
            $surat->pengirim,
            $surat->sifat_surat,
            $surat->tanggal_surat->format('d-m-Y'),
            $surat->tanggal_diterima->format('d-m-Y'),
            $surat->user->name ?? 'N/A',
        ];
    }
}
