<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        //  admin-only access control
        if (!Auth::check() || Auth::user()?->role !== 'admin') {
            abort(403, 'ANDA TIDAK MEMILIKI AKSES KE HALAMAN INI.');
        }
        $users = User::with('employee')->latest()->get();

        // Ambil karyawan yang BELUM punya akun login saja untuk ditampilkan di Dropdown
        $employeesWithoutAccount = Employee::doesntHave('user')->orderBy('name', 'asc')->get();

        return view('management.users.index', compact('users', 'employeesWithoutAccount'));
    }

    // save new user
    public function store(Request $request)
    {
        if (!Auth::check() || Auth::user()?->role !== 'admin') {
            abort(403, 'ANDA TIDAK MEMILIKI AKSES.');
        }

        $request->validate([
            'employee_id' => 'required|exists:employees,id|unique:users,employee_id',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'role' => 'required|in:admin,staff'
        ], [
            'employee_id.unique' => 'Karyawan ini sudah memiliki akun login!',
            'email.unique' => 'Email ini sudah digunakan oleh akun lain!'
        ]);
        $employee = Employee::findOrFail($request->employee_id);

        // create user account and link to employee
        User::create([
            'name' => $employee->name, 
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'employee_id' => $request->employee_id,
        ]);

        return back()->with('success', 'Akun berhasil dibuat dan dihubungkan dengan Karyawan!');
    }

    // delete user
    public function destroy(User $user)
    {
        if (!Auth::check() || Auth::user()?->role !== 'admin') {
            abort(403, 'ANDA TIDAK MEMILIKI AKSES.');
        }

        // prevent admin from deleting their own account while logged in
        if ($user->id === Auth::id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri yang sedang digunakan!');
        }

        $user->delete();

        return back()->with('success', 'Akun pengguna berhasil dihapus. Data Karyawan fisik tetap aman.');
    }
}