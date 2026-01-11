<?php

namespace App\Http\Controllers;
namespace App\Models\Socialite;
use Illuminate\Http\Request;

class SocialiteController extends Controller
{
 public function authProviderRedirect($provider){
     if($provider){
        return Socialite::driver($provider)->redirect();
     }
     abort(404);
 }

 public function socialAuthentication($provider){
    try{
           $googleUser = Socialite::driver('google')->stateless()->user();


            
            $user = user::where('google_id' , $googleUser->id)->first();

            if($user){
                Auth::login($user);
                return redirect()->route('dashboard');

            }
            else{
                $userData = user::create([
                    'name' => $googleUser->name,
                    'email' => $googleUser->email,
                    'password' => Hash::make('password@1234'),
                    'google_id' => $googleUser->id,

                ]);

            if($userData){
                Auth::login($userData);
                return redirect()->route('dashboard');
            }
            }
        }
        catch(Exception $e){
            dd($e);
        }
    }










}
