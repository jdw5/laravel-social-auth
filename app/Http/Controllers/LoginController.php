<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{

    public function __construct()
    {
        $this->middleware(['social', 'guest']);
    }
    
    public function redirect($service, Request $request)
    {
        // $service = 'github';
        return Socialite::driver($service)->redirect();
    }

    public function callback($service, Request $request)
    {
        // $service = 'github';
        $serviceUser = Socialite::driver($service)->stateless()->user();
        $user = $this->getExistingUser($serviceUser, $service);
        
        if (!$user) {
            $user = User::create([
                'name' => $serviceUser->getName(),
                'email' => $serviceUser->getEmail(),

            ]);
        }

        if ($this->noSocial($user, $service)) {
            $user->social()->create([
                'social_id' => $serviceUser->getId(),
                'service' => $service,
            ]);
        }

        Auth::login($user, false);
        return redirect()->intended();
    }

    protected function getExistingUser($user, $service)
    {
        // dd($user);
        return User::where('email', $user->getEmail())
            ->orWhereHas('social', function ($q) use ($user, $service) {
                $q->where('social_id', $user->getId())->where('service', $service);
            })->first();
    }

    protected function noSocial($user, $service) 
    {
        return !$user->hasSocialLinked($service);
    }
}
