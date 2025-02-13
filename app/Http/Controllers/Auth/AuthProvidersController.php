<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class AuthProvidersController
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

                DB::beginTransaction();

                $user = User::create([
                    'first_name' => $googleUser->user['given_name'],
                    'last_name' => $googleUser->user['family_name'] ?? null,
                    'email' => $googleUser->user['email'],
                    'google_id' => $googleUser->user['id'],
                    'email_verified_at' => now(),
                    'password' => Hash::make(Str::random(16)),
                    'role' => 'customer',
                ]);

                DB::commit();
            }

            if (!$user->google_id) {
                $user->update([
                    'google_id' => $googleUser->user['id'],
                    'email_verified_at' => now(),
                ]);

                DB::commit();
            }

            Auth::login($user, 'on');

            return redirect('dashboard');
        }  catch (ClientException $e) {
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
