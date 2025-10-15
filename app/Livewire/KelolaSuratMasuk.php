<?php

namespace App\Livewire;

// Gunakan DB facade untuk transaction
use Illuminate\Support\Facades\DB;
use App\Models\KategoriDisposisi;
use App\Models\SuratMasuk;
use App\Models\User;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

class KelolaSuratMasuk extends Component
{
    use WithFileUploads, WithPagination;

    #[Layout('layouts.app')]

    // Properti untuk Modal & Form
    public bool $showModal = false;

    // Properti yang di-binding
    public $nomor_surat, $tanggal_surat, $tanggal_diterima, $pengirim, $perihal, $fileScan;
    public $sifat_surat = 'Biasa';
    public $klasifikasi = 'Biasa';
    public $derajat = 'Biasa';

    // Properti untuk Disposisi
    public $kirimDisposisi = false;
    public $tujuan_disposisi = [];
    public $tujuan_manual = ''; // Properti baru untuk input manual
    public $kategori_disposisi_id = [];
    public $instruksi_disposisi;

    // Properti untuk data pilihan
    public $daftarTujuan = [];
    public $daftarKategori = [];

    // Properti untuk search
    public string $search = '';


    // Method untuk membuka modal tambah data
    // Method untuk membuka modal tambah data
    public function create()
    {
        $this->reset();
        $this->resetValidation();
        $user = auth()->user();

        // Logika untuk menyiapkan daftar tujuan (berdasarkan jabatan & hierarki)
        // if ($user->jabatan && in_array($user->jabatan->nama, ['Direktur', 'Direktur Utama'])) {
        //     $this->daftarTujuan = User::where('id', '!=', $user->id)->select('id', 'name')->orderBy('name')->get();
        // } else {
        //     $this->daftarTujuan = $user->bawahan()->select('id', 'name')->orderBy('name')->get();
        // }
        if ($user->hasRole(['admin', 'direktur'])) {
            // Jika ya, tampilkan semua user lain sebagai tujuan.
            $this->daftarTujuan = User::where('id', '!=', $user->id)
                ->select('id', 'name')
                ->orderBy('name')
                ->get();
        } else {
            // Jika tidak, tampilkan hanya bawahan langsungnya.
            $this->daftarTujuan = $user->bawahan()
                ->select('id', 'name')
                ->orderBy('name')
                ->get();
        }

        // Logika untuk menyiapkan daftar instruksi (berdasarkan role)
        $userRole = $user->roles()->first();
        if ($userRole) {
            $this->daftarKategori = $userRole->kategoriDisposisi()->orderBy('nama')->get();
        } else {
            $this->daftarKategori = collect();
        }

        // Set nilai default
        $this->sifat_surat = 'Biasa';
        $this->klasifikasi = 'Biasa';
        $this->derajat = 'Biasa';
        $this->tanggal_diterima = now()->format('Y-m-d');
        // $this->pengirim = $user->name;
        $this->showModal = true;
    }





    // Method untuk menutup modal
    public function closeModal()
    {
        $this->showModal = false;
        $this->reset();
        $this->resetValidation();
    }
    protected function rules()
    {
        $rules = [
            'nomor_surat' => 'required|string|max:255|unique:surat_masuk,nomor_surat',
            'tanggal_surat' => 'required|date',
            'tanggal_diterima' => 'required|date|after_or_equal:tanggal_surat',
            'perihal' => 'required|string',
            'sifat_surat' => 'required|string',
            'klasifikasi' => 'required|string',
            'derajat' => 'required|string',
            'fileScan' => 'required|file|mimes:pdf,jpg,jpeg,png,webp|max:2048',
            'pengirim' => 'required|string|max:255',
        ];

        if ($this->kirimDisposisi) {
            $rules['tujuan_manual'] = 'nullable|string|max:255';
            $rules['kategori_disposisi_id'] = 'required|array|min:1';
            $rules['instruksi_disposisi'] = 'nullable|string|max:1000';
        }

        return $rules;
    }


    public function simpan()
    {
        // Validasi kondisional untuk tujuan
        if ($this->kirimDisposisi) {
            if (empty($this->tujuan_disposisi) && empty($this->tujuan_manual)) {
                // Gunakan addError untuk menampilkan pesan validasi di view
                $this->addError('tujuan_disposisi', 'Pilih minimal satu tujuan dari daftar, atau isi tujuan manual.');
                // Hentikan eksekusi jika tidak ada tujuan yang dipilih
                return;
            }
        }

        $validatedData = $this->validate();

        try {
            DB::transaction(function () use ($validatedData) {
                // 1. Simpan file dan data surat utama
                $filePath = $this->fileScan->store('surat-files', 'public');

                $surat = SuratMasuk::create([
                    'nomor_surat' => $validatedData['nomor_surat'],
                    'tanggal_surat' => $validatedData['tanggal_surat'],
                    'tanggal_diterima' => $validatedData['tanggal_diterima'],
                    'pengirim' => $this->pengirim,
                    'perihal' => $validatedData['perihal'],
                    'klasifikasi' => $validatedData['klasifikasi'],
                    'derajat' => $validatedData['derajat'],
                    'sifat_surat' => $validatedData['sifat_surat'],
                    'file_path' => $filePath,
                    'user_id' => auth()->id(),
                ]);

                // 2. Proses disposisi jika dicentang
                if ($this->kirimDisposisi) {
                    $disposisi = $surat->disposisi()->create([
                        'dari_user_id' => auth()->id(),
                        'catatan' => $this->instruksi_disposisi,
                    ]);

                    // 3. Simpan tujuan dari checkbox (jika ada)
                    if (!empty($this->tujuan_disposisi)) {
                        $disposisi->penerima()->attach($this->tujuan_disposisi);
                    }

                    // 4. Simpan tujuan dari input manual (jika ada)
                    if (!empty($this->tujuan_manual)) {
                        // Insert manual ke tabel pivot 'disposisi_penerima'
                        DB::table('disposisi_penerima')->insert([
                            'disposisi_id' => $disposisi->id,
                            'user_id' => null, // Dibuat null karena ini bukan user sistem
                            'tujuan_manual' => $this->tujuan_manual,
                            'status' => 'Terkirim',
                        ]);
                    }

                    // 5. Lampirkan instruksi (berlaku untuk semua tujuan)
                    $disposisi->instruksi()->attach($this->kategori_disposisi_id);
                }
            });

            // Jika semua berhasil
            $this->closeModal();
            $this->dispatch('notify', message: 'Surat masuk berhasil dicatat.', type: 'success');

        } catch (\Exception $e) {
            // Jika terjadi error
            $this->dispatch('notify', message: 'Gagal menyimpan: ' . $e->getMessage(), type: 'error');
        }
    }


    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function render()
    {
        $suratMasuk = SuratMasuk::query()
            ->when($this->search, function ($query) {
                $query->where('nomor_surat', 'like', "%{$this->search}%")
                    ->orWhere('perihal', 'like', "%{$this->search}%")
                    ->orWhere('pengirim', 'like', "%{$this->search}%");
            })
            ->latest('tanggal_diterima')
            ->paginate(10);

        return view('livewire.kelola-surat-masuk', [
            'suratMasuk' => $suratMasuk,
        ]);
    }
}
