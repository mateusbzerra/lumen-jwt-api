<?php
namespace App\Http\Controllers;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Firebase\JWT\ExpiredException;
use Illuminate\Support\Facades\Hash;
use App\Http\Models\User;

class AuthController extends Controller{
    private $request;
    protected function jwt(User $user) {
    $payload = [
        'iss' => "lumen-jwt", // Issuer of the token
        'sub' => $user->id, // Subject of the token
        'iat' => time(), // Time when JWT was issued.
        'exp' => time() + 60*60 // Expiration time
    ];
    return JWT::encode($payload, env('JWT_SECRET'));
    }

    public function authenticate(Request $request) {
        $this->validate($request, [
            'email'     => 'required|email',
            'password'  => 'required'
        ]);

        $user = User::where('email', $request->input('email'))->first();

        if (!$user) {
            return response()->json(['error' => 'Email does not exist.'], 400);
        }

        if (Hash::check($request->input('password'), $user->password)) {
            return response()->json(['token' => $this->jwt($user)], 200);
        }
        return response()->json(['error' => 'Email or password is wrong.'], 400);
    }
}
