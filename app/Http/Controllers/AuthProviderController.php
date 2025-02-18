<?php

namespace App\Http\Controllers;

use App\Models\User;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class AuthProviderController extends Controller
{
    public function googleAuth()
    {
        if (Auth::check()) {
            return redirect('dashboard');
        }

        return Socialite::driver('google')->redirect();
    }

    public function googleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();

            $user = User::where('email', $googleUser->user['email'])->first();

            if(!$user){
                return redirect()->route('login')->withErrors(['error' => 'Você não possui conta com esse email.']);
            }

            if (!$user->google_id) {
                $user->update([
                    'google_id' => $googleUser->user['id'],
                    'email_verified_at' => now(),
                ]);
            }

            Auth::login($user, 'on');

            return redirect('dashboard');
        } catch (ClientException $e) {
            DB::rollBack();
            \Log::error($e);
            return redirect()->route('login')->withErrors(['google' => 'Erro ao autenticar com Google. Por favor, tente novamente.']);
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error($e);
            return redirect()->route('login')->withErrors(['error' => 'Ocorreu um erro inesperado. Tente novamente.']);
        }
    }
}
