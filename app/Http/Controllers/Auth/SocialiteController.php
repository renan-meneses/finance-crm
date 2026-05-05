<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        return $this->handleSocialCallback('google');
    }

    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function handleFacebookCallback()
    {
        return $this->handleSocialCallback('facebook');
    }

    protected function handleSocialCallback(string $provider)
    {
        try {
            $socialUser = Socialite::driver($provider)->user();
        } catch (\Exception $e) {
            return redirect(env('FRONTEND_URL', 'http://localhost:5173') . '/login?error=social_auth_failed');
        }

        $field = $provider . '_id';
        
        $user = User::where($field, $socialUser->getId())
            ->orWhere('email', $socialUser->getEmail())
            ->first();

        if (!$user) {
            $user = User::create([
                'name' => $socialUser->getName(),
                'email' => $socialUser->getEmail(),
                'password' => null,
                'role' => 'usuario',
                'theme' => 'light',
                $field => $socialUser->getId(),
                'avatar' => $socialUser->getAvatar(),
            ]);
        } else {
            if (empty($user->$field)) {
                $user->$field = $socialUser->getId();
                $user->avatar = $socialUser->getAvatar();
                $user->save();
            }
        }

        $token = $user->createToken('social_auth')->plainTextToken;

        $frontendUrl = env('FRONTEND_URL', 'http://localhost:5173');
        return redirect($frontendUrl . '/login?token=' . $token . '&user=' . base64_encode(json_encode([
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->role,
            'theme' => $user->theme,
        ])));
    }
}
