<?php

namespace App\Livewire\Backend\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AdminManager extends Component
{
    use WithPagination;

    // --- Table Properties ---
    public $search = '';
    public $sortField = 'name';
    public $sortDirection = 'asc';
    public $perPage = 10;

    // --- Form Properties ---
    public $showModal = false;
    public $adminId;
    public $name;
    public $email;
    public $password;
    public $password_confirmation;

    public $isEditing = false;

    protected $paginationTheme = 'bootstrap';

    protected $queryString = [
        'search' => ['except' => ''],
        'sortField' => ['except' => 'name'],
        'sortDirection' => ['except' => 'asc'],
        'page' => ['except' => 1],
    ];

    // RENAME THIS METHOD TO AVOID CONFLICTS
    protected function getValidationRules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('admins')->ignore($this->adminId),
            ],
            // Password required only on create, optional on edit
            'password' => $this->isEditing ? 'nullable|min:8|confirmed' : 'required|min:8|confirmed',
        ];
    }

    // --- Table Methods ---

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }
        $this->sortField = $field;
    }

    // --- Form Methods ---

    public function openModal()
    {
        $this->resetValidation();
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetForm();
    }

    public function createAdmin()
    {
        $this->isEditing = false;
        $this->resetForm();
        $this->openModal();
    }

    public function editAdmin(Admin $admin)
    {
        $this->isEditing = true;
        $this->adminId = $admin->id;
        $this->name = $admin->name;
        $this->email = $admin->email;
        $this->password = ''; // Keep password empty for security
        $this->openModal();
    }

    public function saveAdmin()
    {
        // CALL THE RENAMED METHOD HERE
        $this->validate($this->getValidationRules());

        $data = [
            'name' => $this->name,
            'email' => $this->email,
        ];

        // Only update password if provided
        if (!empty($this->password)) {
            $data['password'] = Hash::make($this->password);
        }

        if ($this->isEditing) {
            Admin::find($this->adminId)->update($data);
            session()->flash('message', 'Admin updated successfully!');
        } else {
            Admin::create($data);
            session()->flash('message', 'Admin created successfully!');
        }

        $this->closeModal();
    }

    public function deleteAdmin($id)
    {
        // Prevent admin from deleting themselves (if using auth()->guard('admin'))
        if (auth()->guard('admin')->check() && auth()->guard('admin')->id() == $id) {
            session()->flash('error', 'You cannot delete your own account.');
            return;
        }

        Admin::findOrFail($id)->delete();
        session()->flash('message', 'Admin deleted successfully!');
    }

    private function resetForm()
    {
        $this->adminId = null;
        $this->name = '';
        $this->email = '';
        $this->password = '';
        $this->password_confirmation = '';
        $this->isEditing = false;
    }

    public function render()
    {
        $admins = Admin::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%');
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        return view('livewire.backend.admin.admin-manager', [
            'admins' => $admins,
        ]);
    }
}
