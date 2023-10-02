<?php

namespace App\Http\Livewire\Employee;

use App\Models\User;

use Livewire\{
    Component,
    WithPagination
};

class Index extends Component
{
    public function render()
    {
        $employees = User::where('role', 'employee')->orWhere('role', 'admin')->orWhere('role', 'operator')->get();
        return view('livewire.employee.index',['employees' => $employees]);
    }
}
