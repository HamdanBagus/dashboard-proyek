<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Menampilkan Halaman Manajemen User
     */
    public function index()
    {
        //  Hanya Admin yang boleh masuk
        if (!Auth::check() || Auth::user()?->role !== 'admin') {
            abort(403, 'ANDA TIDAK MEMILIKI AKSES KE HALAMAN INI.');
        }
        $users = User::with('employee')->latest()->get();

        // Ambil karyawan yang BELUM punya akun login saja untuk ditampilkan di Dropdown
        $employeesWithoutAccount = Employee::doesntHave('user')->orderBy('name', 'asc')->get();

        return view('management.users.index', compact('users', 'employeesWithoutAccount'));
    }

    /**
     * Menyimpan Akun User Baru
     */
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

        // Cari data karyawan berdasarkan ID yang dipilih Admin
        $employee = Employee::findOrFail($request->employee_id);

        // Buat akun baru dari data karyawan 
        User::create([
            'name' => $employee->name, 
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'employee_id' => $request->employee_id,
        ]);

        return back()->with('success', 'Akun berhasil dibuat dan dihubungkan dengan Karyawan!');
    }

    /**
     * Menghapus Akun User
     */
    public function destroy(User $user)
    {
        if (!Auth::check() || Auth::user()?->role !== 'admin') {
            abort(403, 'ANDA TIDAK MEMILIKI AKSES.');
        }

        // Mencegah admin menghapus akunnya sendiri s
        if ($user->id === Auth::id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri yang sedang digunakan!');
        }

        $user->delete();

        return back()->with('success', 'Akun pengguna berhasil dihapus. Data Karyawan fisik tetap aman.');
    }
}