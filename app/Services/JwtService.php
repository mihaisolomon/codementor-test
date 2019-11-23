<?php


namespace App\Services;

use App\Services\Users\UserServiceInterface;
use App\User;
use Firebase\JWT\JWT;
use Firebase\JWT\ExpiredException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class JwtService implements JwtServiceInterface
{
    protected $userService;

    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }

    public function createUser(Request $request)
    {
        $user = $this->userService->store([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
            'avatar' => Gravatar::avatar($request->get('email'))
        ]);

        $token = $this->jwt($user);

        return $token;
    }

    protected function jwt(User $user)
    {
        $payload = [
            'iss' => env('APP_NAME'), // Issuer of the token
            'sub' => $user->id, // Subject of the token
            'iat' => time(), // Time when JWT was issued.
            'exp' => time() + 60 * 60 // Expiration time
        ];

        return JWT::encode($payload, env('JWT_SECRET'));
    }

    public function decode(Request $request)
    {
        $token = $request->header(env('LOOK_FOR_KEY'));

        if (!$token) {
            return [
                'message' => 'Token not provided.',
                'code' => 401
            ];
        }

        try {
            $credentials = JWT::decode($token, env('JWT_SECRET'), ['HS256']);
        } catch (ExpiredException $e) {
            return [
                'message' => 'Provided token is expired.',
                'code' => 400];
        } catch (\Exception $e) {
            return [
                'message' => 'An error while decoding token.',
                'code' => 400];
        }

        return [
            'user' => $this->userService->show($credentials->sub)
        ];
    }
}
