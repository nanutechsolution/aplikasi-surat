<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Spatie\Permission\Models\Permission;
use App\Models\Role; // Pastikan menggunakan model Role custom Anda

#[Layout('layouts.app')]
class KelolaRoles extends Component
{
    // Properti untuk data
    public $roles;
    public $permissions;
    public $selectedRoleId;
    public $selectedPermissions = [];

    // Method ini dijalankan saat komponen pertama kali dimuat
    public function mount()
    {
        $this->roles = Role::all();
        $this->permissions = Permission::all();
    }

    // Lifecycle hook: dijalankan setiap kali $selectedRoleId berubah
    public function updatedSelectedRoleId($roleId)
    {
        if ($roleId) {
            $role = Role::findById($roleId);
            // Ambil semua nama permission yang dimiliki role ini dan masukkan ke array
            $this->selectedPermissions = $role->permissions->pluck('name')->toArray();
        } else {
            $this->selectedPermissions = [];
        }
    }

    // Method untuk menyimpan perubahan
    public function simpan()
    {
        $this->validate([
            'selectedRoleId' => 'required|exists:roles,id'
        ]);

        $role = Role::findById($this->selectedRoleId);
        // SyncPermissions adalah method dari Spatie yang sangat berguna
        // Ia akan otomatis menambah dan menghapus izin sesuai array yang kita berikan
        $role->syncPermissions($this->selectedPermissions);

        $this->dispatch('notify', message: "Hak akses untuk role '{$role->name}' berhasil diperbarui.", type: 'success');
    }

    public function render()
    {
        return view('livewire.kelola-roles');
    }
}
