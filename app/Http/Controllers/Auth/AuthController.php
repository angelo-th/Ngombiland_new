<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User; // corrige le namespace
use App\Services\Auth\OTPService; // assure-toi que ce service existe
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Spatie\Permission\Models\Role; // pour assigner les rôles

class AuthController extends Controller
{
    protected $otpService;

    public function __construct(OTPService $otpService)
    {
        $this->otpService = $otpService;
    }

    // Formulaire d'inscription
    public function create()
    {
        return view('/Auth/register/register'); // ta vue register.blade.php
    }

    // Traitement de l'inscription
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|max:20|unique:users',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => 'required|in:property_owner,investor,both,client,admin,field_agent',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'account_status' => 'pending', // valeur par défaut
        ]);

        // Assignation des rôles
        $this->assignRoles($user, $request->role);

        // Création du portefeuille si relation wallet définie
        if (method_exists($user, 'wallet')) {
            $user->wallet()->create();
        }

        // Envoi OTP
        $otp = $this->otpService->sendOTP($user->phone);

        return response()->json([
            'message' => 'User registered successfully. Please verify your phone.',
            'user' => $user,
            'otp_reference' => $otp['reference'] ?? null
        ], 201);
    }

    // Connexion
    public function login(Request $request)
    {
        $request->validate([
            'login' => 'required|string', // email ou phone
            'password' => 'required|string',
            'device_name' => 'required|string',
        ]);

        $user = User::where('email', $request->login)
                   ->orWhere('phone', $request->login)
                   ->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        if ($user->account_status !== 'active') {
            return response()->json(['message' => 'Account not active'], 403);
        }

        // Mise à jour des infos de connexion
        $user->update([
            'last_login' => now(),
        ]);

        // Création du token
        $token = $user->createToken($request->device_name)->plainTextToken;

       return response()->json([
    'user' => $user,
    'token' => $token,
    'roles' => $user->roles->pluck('name'),
    'redirect' => route('dashboard'), // 🔥 Ajout pour renvoyer vers dashboard
        ]);
    }

    // Déconnexion
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Successfully logged out']);
    }

    // Vérification OTP
    public function verifyOTP(Request $request)
    {
        $request->validate([
            'phone' => 'required|string',
            'otp' => 'required|string',
            'reference' => 'required|string',
        ]);

        $verified = $this->otpService->verifyOTP($request->phone, $request->otp, $request->reference);

        if (!$verified) {
            return response()->json(['message' => 'Invalid OTP'], 400);
        }

        $user = User::where('phone', $request->phone)->firstOrFail();
        $user->update(['phone_verified_at' => now(), 'account_status' => 'active']);

        return response()->json(['message' => 'Phone verified successfully']);
    }

    // Assignation des rôles
    protected function assignRoles(User $user, string $roleType)
    {
        // Assurez-vous que ces rôles existent dans la table roles
        switch ($roleType) {
            case 'property_owner':
                $user->assignRole('property_owner');
                break;
            case 'investor':
                $user->assignRole('investor');
                break;
            case 'both':
                $user->assignRole(['property_owner', 'investor']);
                break;
             case 'admin':
                $user->assignRole('admin');
                break;
            case 'client':
                $user->assignRole('client');
                break;
            case 'field_agent':
                $user->assignRole('field_agent');
                break;
        }

        $user->assignRole('user'); // rôle de base
    }
}
