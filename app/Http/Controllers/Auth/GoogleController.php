<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str; // ⚡ Ajouté
use Laravel\Socialite\Facades\Socialite;
class GoogleController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

   public function callback()
{
    $googleUser = Socialite::driver('google')->stateless()->user();

    $avatar = $googleUser->getAvatar() 
        ?? "https://ui-avatars.com/api/?name=" . urlencode($googleUser->getName());

           // dd($googleUser);

    $user = User::where('email', $googleUser->getEmail())->first();

    if (!$user) {
        $user = User::create([
            'name'     => $googleUser->getName(),
            'email'    => $googleUser->getEmail(),
            'password' => bcrypt(Str::random(16)),
            'avatar'   => $avatar,
        ]);
    } else {
        $user->update([
            'avatar' => $avatar,
        ]);
    }

    Auth::login($user);

    return redirect()->intended('/dashboard');
}

}
