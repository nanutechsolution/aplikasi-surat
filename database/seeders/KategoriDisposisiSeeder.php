<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriDisposisiSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['nama' => 'UDL', 'keterangan' => 'Untuk Ditindaklanjuti'],
            ['nama' => 'UDK', 'keterangan' => 'Untuk Diketahui'],
            ['nama' => 'Menghadap', 'keterangan' => 'Penerima disposisi diminta menghadap pimpinan atau pejabat terkait'],
            ['nama' => 'Wakili', 'keterangan' => 'Penerima disposisi mewakili atasan dalam pelaksanaan tugas'],
            ['nama' => 'Acc', 'keterangan' => 'Disetujui'],
            ['nama' => 'Pelajari/Teliti', 'keterangan' => 'Harap dipelajari atau diteliti lebih lanjut'],
            ['nama' => 'Catat', 'keterangan' => 'Catat untuk referensi atau tindak lanjut'],
            ['nama' => 'Balas', 'keterangan' => 'Buat surat balasan sesuai arahan'],
            ['nama' => 'Pedoman', 'keterangan' => 'Jadikan pedoman atau acuan'],
            ['nama' => 'Tindaklanjuti', 'keterangan' => 'Laksanakan tindak lanjut sesuai isi surat'],
            ['nama' => 'Selesaikan', 'keterangan' => 'Selesaikan sesuai prosedur'],
            ['nama' => 'Bahan Masukan', 'keterangan' => 'Gunakan sebagai bahan masukan atau pertimbangan'],
            ['nama' => 'Ingatkan', 'keterangan' => 'Berikan pengingat terkait surat ini'],
            ['nama' => 'Dukung', 'keterangan' => 'Berikan dukungan sesuai arahan'],
            ['nama' => 'Siapkan Bahan', 'keterangan' => 'Siapkan bahan terkait surat ini'],
            ['nama' => 'Siapkan Jawaban', 'keterangan' => 'Siapkan draft jawaban'],
            ['nama' => 'Koordinasikan', 'keterangan' => 'Koordinasikan dengan pihak terkait'],
            ['nama' => 'Jadwalkan', 'keterangan' => 'Buat jadwal kegiatan atau pertemuan'],
            ['nama' => 'Monitor', 'keterangan' => 'Lakukan pemantauan tindak lanjut'],
            ['nama' => 'Cek Kembali', 'keterangan' => 'Periksa ulang kelengkapan atau keakuratan'],
            ['nama' => 'Edarkan', 'keterangan' => 'Edarkan surat ke bagian terkait'],
            ['nama' => 'Laporkan Hasil', 'keterangan' => 'Laporkan hasil pelaksanaan disposisi'],
            ['nama' => 'Saran', 'keterangan' => 'Berikan saran terhadap isi surat'],
            ['nama' => 'Rencanakan', 'keterangan' => 'Rencanakan pelaksanaan kegiatan'],
            ['nama' => 'Dalami', 'keterangan' => 'Dalami isi surat lebih lanjut'],
            ['nama' => 'Arsip', 'keterangan' => 'Simpan sebagai arsip'],
            ['nama' => 'Sesuai Juk Pimpinan', 'keterangan' => 'Laksanakan sesuai petunjuk pimpinan'],
            ['nama' => 'Copy', 'keterangan' => 'Buat salinan untuk pihak terkait'],
        ];

        DB::table('kategori_disposisi')->insert($data);
    }
}
