<?php

namespace App\Livewire;

use App\Models\Jabatan;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use App\Models\Role; // Pastikan menggunakan model Role custom Anda

#[Layout('layouts.app')]
class KelolaPengguna extends Component
{
    use WithPagination;

    // Properti untuk Modal & Form
    public bool $showModal = false;
    public $userId;
    public $name, $email, $password, $password_confirmation;
    public $jabatanId, $roleName, $managerId;

    // Properti untuk data dropdown
    public $daftarJabatan = [];
    public  $allRoles;
    public $daftarManajer = [];

    // Properti untuk search
    public string $search = '';

    // Method ini dijalankan saat komponen pertama kali dimuat
    public function mount()
    {
        $this->daftarJabatan = Jabatan::orderBy('nama')->get();
        $this->allRoles = Role::pluck('name');
        // Daftar manajer adalah semua user, kecuali user yang sedang diedit (jika ada)
        $this->daftarManajer = User::where('id', '!=', $this->userId)->orderBy('name')->get();
    }

    // Method untuk membuka modal tambah
    public function create()
    {
        $this->reset();
        $this->mount(); // Muat ulang data dropdown
        $this->resetValidation();
        $this->showModal = true;
    }

    // Method untuk membuka modal edit
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $this->userId = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->jabatanId = $user->jabatan_id;
        $this->managerId = $user->manager_id;
        // Ambil nama role pertama yang dimiliki user
        $this->roleName = $user->roles()->first()?->name;

        $this->mount(); // Muat ulang data dropdown
        $this->resetValidation();
        $this->showModal = true;
    }

    // Method untuk menyimpan (Create & Update)
    public function simpan()
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $this->userId,
            'jabatanId' => 'required|exists:jabatan,id',
            'roleName' => 'required|exists:roles,name',
            'managerId' => 'nullable|exists:users,id',
        ];

        // Tambahkan validasi password hanya saat membuat user baru
        if (!$this->userId) {
            $rules['password'] = 'required|string|min:8|confirmed';
        }

        $validatedData = $this->validate($rules);

        // Siapkan data user
        $userData = [
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'jabatan_id' => $validatedData['jabatanId'],
            'manager_id' => $validatedData['managerId'],
        ];
        // Tambahkan password hanya jika diisi (untuk update)
        if (!empty($this->password)) {
            $this->validate(['password' => 'string|min:8|confirmed']);
            $userData['password'] = Hash::make($this->password);
        }

        $user = User::updateOrCreate(['id' => $this->userId], $userData);

        // Gunakan syncRoles untuk mensinkronkan role (aman untuk create & update)
        $user->syncRoles($validatedData['roleName']);

        $this->closeModal();
        $this->dispatch('notify', message: 'Pengguna berhasil disimpan.', type: 'success');
    }

    // Method untuk menghapus
    public function hapus($id)
    {
        // Pencegahan agar tidak bisa menghapus diri sendiri
        if ($id == auth()->id()) {
            $this->dispatch('notify', message: 'Anda tidak bisa menghapus akun Anda sendiri.', type: 'error');
            return;
        }

        User::findOrFail($id)->delete();
        $this->dispatch('notify', message: 'Pengguna berhasil dihapus.', type: 'success');
    }

    // Method untuk menutup modal
    public function closeModal()
    {
        $this->showModal = false;
        $this->reset();
    }

    // Reset halaman jika ada pencarian
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $users = User::with(['jabatan', 'roles'])
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%');
            })
            ->latest()
            ->paginate(10);

        return view('livewire.kelola-pengguna', [
            'users' => $users,
        ]);
    }
}
