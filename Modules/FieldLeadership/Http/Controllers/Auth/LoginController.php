<?php

namespace Modules\FieldLeadership\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Hash;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;
use Modules\FieldLeadership\Transformers\General\EmployeeResource;

class LoginController extends Controller
{
    public function login(Request $request): EmployeeResource
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|string',
            'device_name' => 'required'
        ]);

        $user = User::whereEmail($request->input('email'))->first();

        if (!Hash::check($request->input('password'), $user->password)) {
            throw ValidationException::withMessages([
                'password' => ['Password yang Anda masukan tidak sesuai.']
            ]);
        }

        $token = $user->createToken($request->input('device_name'))->plainTextToken;

        return (new EmployeeResource($user->employee))
            ->additional([
                'message' => 'Successfully logged in',
                'token' => $token
            ]);
    }
}
