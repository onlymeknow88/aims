<?php

namespace Modules\KO\Http\Controllers\Api;

use App\Models\User;
use Hash;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|string',
            'device_name' => 'required',
        ]);

        $user = User::whereEmail($request->input('email'))->first();

        if (!Hash::check($request->input('password'), $user->password)) {
            throw ValidationException::withMessages([
                'password' => ['Password yang Anda masukan tidak sesuai.'],
            ]);
        }

        $token = $user->createToken($request->input('device_name'))->plainTextToken;

        return $token;
        return ([
            'data' => [
                'id' => $user->employee->id,
                'company_name' => $user->department->company->company_name ?? null,
                'department_name' => $user->department->name ?? null,
                'name' => $user->employee->name,
                'number' => $user->employee->number,
                'id_number' => $user->employee->id_number,
                'date_of_birth' => $user->employee->date_of_birth,
                'gender' => $user->employee->gender,
                'blood_type' => $user->employee->blood_type,
                'marital_status' => $user->employee->marital_status,
                'employee_status' => $user->employee->employee_status,
                'company' => $user->department_id ? $user->department->company_id : '-',
                'department' => $user->department_id ? $user->department_id : '-',
                'position' => $user->employee->position,
            ],
            'message' => 'Successfully logged in',
            'token' => $token,
        ]);
    }
}
