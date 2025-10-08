<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Spatie\Permission\Models\Role;

class KelolaPengguna extends Component
{
    use WithPagination;

    #[Layout('layouts.app')]

    // Properti untuk Modal & Form
    public bool $showModal = false;
    public bool $isEditMode = false;
    public ?User $user;

    // Properti yang di-binding
    public string $name = '';
    public string $email = '';
    public string $role = '';
    public string $password = '';
    public string $password_confirmation = '';

    public function create()
    {
        $this->resetValidation();
        $this->reset();
        $this->isEditMode = false;
        $this->showModal = true;
    }

    public function edit(User $user)
    {
        $this->resetValidation();
        $this->isEditMode = true;
        $this->user = $user;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->role = $user->roles->first()->name ?? '';
        $this->showModal = true;
    }

    public function save()
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . ($this->isEditMode ? $this->user->id : ''),
            'role' => 'required|exists:roles,name',
        ];

        if (!$this->isEditMode) {
            $rules['password'] = 'required|string|min:8|confirmed';
        }

        $this->validate($rules);

        if ($this->isEditMode) {
            // Update User
            $this->user->update([
                'name' => $this->name,
                'email' => $this->email,
            ]);
            $this->user->syncRoles($this->role);
            $this->dispatch('notify', message: 'Pengguna berhasil diperbarui.', type: 'success');
        } else {
            // Create User
            $newUser = User::create([
                'name' => $this->name,
                'email' => $this->email,
                'password' => Hash::make($this->password),
            ]);
            $newUser->assignRole($this->role);
            $this->dispatch('notify', message: 'Pengguna baru berhasil ditambahkan.', type: 'success');

        }

        $this->closeModal();
    }

    public function closeModal()
    {
        $this->reset();
        $this->resetValidation();
    }

    public function render()
    {
        return view('livewire.kelola-pengguna', [
            'users' => User::with('roles')->latest()->paginate(10),
            'roles' => Role::all(),
        ]);
    }
}
