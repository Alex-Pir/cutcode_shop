<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Domain\Auth\Models\User;
use DomainException;
use Illuminate\Http\RedirectResponse;
use Laravel\Socialite\Facades\Socialite;
use Symfony\Component\HttpFoundation\RedirectResponse as FoundationResponse;
use Throwable;

class SocialAuthController extends Controller
{
    public function redirect(string $driver): FoundationResponse|RedirectResponse
    {
        try {
            return Socialite::driver($driver)->redirect();
        } catch (Throwable) {
            throw new DomainException('Произошла ошибка или драйвер не поддерживается');
        }
    }

    public function callback(string $driver): RedirectResponse
    {
        if ($driver !== 'github') {
            throw new DomainException('Драйвер не поддерживается');
        }

        $socialUser = Socialite::driver($driver)->user();

        // TODO 3rd lesson move to custom table
        $user = User::query()->updateOrCreate([
            $driver . '_id' => $socialUser->getId(),
        ], [
            'name' => $socialUser->getName() ?? $socialUser->getEmail(),
            'email' => $socialUser->getEmail(),
            'password' => bcrypt(str()->random(20))
        ]);

        auth()->login($user);

        return redirect()->intended(route('home'));
    }
}
