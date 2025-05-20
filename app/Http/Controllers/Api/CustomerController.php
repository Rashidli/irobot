<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CustomerResource;
use App\Mail\PasswordResetMail;
use App\Mail\VerificationCodeMail;
use App\Models\Customer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CustomerController extends Controller
{

    public function register(Request $request) : JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'phone' => 'required|string',
            'email' => 'required|string|email|unique:customers,email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->all()
            ], 422);
        }

        $customer = Customer::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json(new CustomerResource($customer), 201);
    }

    public function update(Request $request): JsonResponse
    {
        try {
            $customer = Customer::query()->findOrFail(auth()->user()->id);

            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'phone' => 'required|max:20',
                'email' => 'required|string|email|max:255|unique:customers,email,' . $customer->id,
                'password' => 'nullable|string',
                'new_password' => 'nullable|string|min:4|confirmed',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'errors' => $validator->errors()->all()
                ], 422);
            }

            if ($request->filled('new_password')) {
                if (!Hash::check($request->password, $customer->password)) {
                    return response()->json([
                        'errors' => ['password' => ['The current password is incorrect.']]
                    ], 422);
                }
            }

            $data = [
                'name' => $request->name,
                'phone' => $request->phone,
                'email' => $request->email,
            ];

            if ($request->filled('new_password')) {
                $data['password'] = Hash::make($request->new_password);
            }

            $customer->update($data);

            return response()->json(new CustomerResource($customer), 200);
        }catch (\Exception $exception){
            \Log::error('Password Reset Email Error: ' . $exception->getMessage());
            return response()->json(new CustomerResource($customer), 200);
        }

    }

    public function login(Request $request) : JsonResponse
    {

        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->all()
            ], 422);
        }

        $customer = Customer::query()->where('email', $request->email)->first();

        if (!$customer || !Hash::check($request->password, $customer->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $token = $customer->createToken('admin_token')->plainTextToken;

        return response()->json(['token' => $token, 'customer' => new CustomerResource($customer)]);

    }

    public function logout(Request $request) : JsonResponse
    {

        $customer = $request->user();

        if ($customer) {
            $customer->tokens()->delete();
            return response()->json(['message' => 'Logged out successfully']);
        }

        return response()->json(['message' => 'No authenticated user found'], 401);

    }

    public function requestEmailChange(Request $request) : JsonResponse
    {

        try {
            $validator = Validator::make($request->all(), [
                'new_email' => 'required|string|email|unique:customers,email',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'error' => $validator->errors()->all()
                ], 422);
            }

            $customer = auth()->user();
            $verificationCode = rand(100000, 999999);

            $customer->update(['email_verification_code' => $verificationCode]);

            Mail::to($request->new_email)->send(new VerificationCodeMail($verificationCode));
        }catch (\Exception $exception){
            return response()->json($exception->getMessage());
        }

        return response()->json(['message' => 'Verification code sent to the new email']);

    }

    public function verifyEmailChange(Request $request) : JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'new_email' => 'required|string|email|unique:customers,email',
            'verification_code' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->all()
            ], 422);
        }

        $customer = auth()->user();

        if ($customer->email_verification_code != $request->verification_code) {
            return response()->json(['message' => 'Invalid verification code'], 400);
        }

        $customer->update([
            'email' => $request->new_email,
            'email_verification_code' => null,
        ]);

        return response()->json(['message' => 'Email updated successfully']);
    }

    public function requestPasswordReset(Request $request) : JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|exists:customers,email',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->all()
            ], 422);
        }

        $customer = Customer::query()->where('email', $request->email)->first();
        $resetToken = Str::random(60);

        $customer->update([
            'password_reset_token' => $resetToken,
            'password_reset_token_expiry' => now()->addHours(1),
        ]);

        $resetUrl = url('/password-reset/' . $resetToken);

        Mail::to($customer->email)->send(new PasswordResetMail($resetUrl));

        return response()->json(['message' => 'Password reset link sent to your email']);

    }

    public function resetPassword(Request $request) : JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|exists:customers,email',
            'reset_token' => 'required',
            'new_password' => 'required|string|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->all()
            ], 422);
        }

        $customer = Customer::where('email', $request->email)->first();

        if ($customer->password_reset_token != $request->reset_token) {
            return response()->json(['message' => 'Invalid reset token'], 400);
        }

        $customer->update([
            'password' => Hash::make($request->new_password),
            'password_reset_token' => null,
        ]);

        return response()->json(['message' => 'Password updated successfully']);
    }

}
