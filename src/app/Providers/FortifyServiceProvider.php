<?php

namespace App\Providers;

use Illuminate\Support\Facades\Session;
use App\Actions\Fortify\CreateNewUser;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Fortify;
use App\Models\User;
use Laravel\Fortify\Http\Requests\LoginRequest as FortifyLoginRequest;
use Laravel\Fortify\Http\Requests\RegisterRequest as FortifyRegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\Auth;


class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Fortify::createUsersUsing(CreateNewUser::class);

        Fortify::registerView(function () {
            return view('auth.register');
        });

        Fortify::loginView(function () {
            return view('auth.login');
        });


        RateLimiter::for('login', function (Request $request) {
            $email = (string) $request->email;

            return Limit::perMinute(10)->by($email . $request->ip());
        });

        $this->app->bind(FortifyLoginRequest::class, LoginRequest::class);
        $this->app->bind(FortifyRegisterRequest::class, RegisterRequest::class);



        Fortify::authenticateUsing(function (Request $request) {
            $user = User::where('email', $request->email)->first();


            if ($user && \Hash::check($request->password, $user->password)) {

                Session::put('first_login', true);
                return $user;
            }

                return null;
        });

        Fortify::redirects('login', function () {
                $redirectUrl = Session::pull('first_login', false);

                return $firstLogin ? '/mypage/profile' : RouteServiceProvider::HOME;
        });
    }

}
