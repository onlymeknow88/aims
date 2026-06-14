<?php

namespace App\Imports;

use App\Models\User;
use App\Models\Department;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class UsersImport implements WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            'import' => new UsersSheetImport(),
        ];
    }
}

class UsersSheetImport implements ToModel, WithHeadingRow, WithValidation
{
    public function model(array $row)
    {
        // Error messages array
        static $errors = [];

        // Cek email sudah ada
        if (User::where('email', $row['email'])->exists()) {
            $errors[] = 'Email "' . $row['email'] . '" sudah digunakan.';
            \Log::warning('Import error: Email "' . $row['email'] . '" sudah digunakan.');
            return null;
        }

        // Cek name sudah ada (opsional, jika ingin unique name)
        if (User::where('name', $row['name'])->exists()) {
            $errors[] = 'Nama "' . $row['name'] . '" sudah digunakan.';
            \Log::warning('Import error: Nama "' . $row['name'] . '" sudah digunakan.');
            return null;
        }

        // Cek department
        $departmentId = null;
        if (!empty($row['department'])) {
            $department = Department::where('name', $row['department'])->first();
            if (!$department) {
                $errors[] = 'Department "' . $row['department'] . '" tidak ditemukan.';
                \Log::warning('Import error: Department "' . $row['department'] . '" tidak ditemukan.');
                return null;
            }
            $departmentId = $department->id;
        }

        $user = User::create([
            'name' => $row['name'],
            'email' => $row['email'],
            'password' => Hash::make($row['password']),
            'department_id' => $departmentId,
        ]);

        // Attach department jika many-to-many
        if ($departmentId && method_exists($user, 'departments')) {
            $user->departments()->attach($departmentId);
        }

        // Assign roles
        if (!empty($row['roles'])) {
            $roles = array_map('trim', explode(',', $row['roles']));
            foreach ($roles as $role) {
                if (!empty($role)) {
                    $roleModel = \Spatie\Permission\Models\Role::where('name', $role)->first();
                    if ($roleModel) {
                        $user->assignRole($roleModel);
                    } else {
                        $errors[] = 'Role "' . $role . '" tidak ditemukan.';
                        \Log::warning('Import error: Role "' . $role . '" tidak ditemukan.');
                    }
                }
            }
        }



        // Jika ada error, bisa juga lempar exception atau tampilkan notifikasi
        if (!empty($errors)) {
            // Simpan ke log, atau bisa juga dilempar sebagai ValidationException
            // throw new \Maatwebsite\Excel\Validators\ValidationException(...)
        }

        return $user;
    }

    public function rules(): array
    {
        return [
            '*.email' => ['required', 'email', 'unique:users,email'],
            '*.name' => ['required'],
            '*.password' => ['required', 'min:6'],
            // '*.department' => ['nullable', 'exists:departments,name'],
        ];
    }

    public function customValidationMessages(): array
    {
        return [
            'email.unique' => 'Email :input sudah terdaftar.',
            'name.required' => 'Nama harus diisi.',
            'password.required' => 'Password harus diisi.',
            'password.min' => 'Password minimal 6 karakter.',
        ];
    }
}
