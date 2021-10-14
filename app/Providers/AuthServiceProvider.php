<?php

namespace App\Providers;

use App\Models\User;
use App\Models\Yard;
use App\Policies\YardPolicy;
use Illuminate\Auth\GenericUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Boot the authentication services for the application.
     *
     * @return void
     */
    public function boot()
    {
        // Here you may define how you wish users to be authenticated for your Lumen
        // application. The callback which receives the incoming request instance
        // should return either a User instance or null. You're free to obtain
        // the User instance via an API token or any other method necessary.

        $this->app['auth']->viaRequest('api', function (Request $request) {
            if (env('APP_DEBUG')) {
                return new GenericUser([
                    'id_user' => 1,
                    'name' => 'toto',
                    'id_enterprise' => 2,
                ]);
            }

            $token = $request->cookie('token');

            if ($token != null && $token != '') {
                return User::query()
                    ->where('token', $token)
                    ->where('token_gentime', '>', DB::raw('NOW() - INTERVAL 24 HOUR'))
                    ->first();
            }

            return null;
        });

        $this->registerPolicies();
    }

    public function registerPolicies()
    {
        Gate::before(function () {
            return env('APP_DEBUG');
        });

        Gate::policy(Yard::class, YardPolicy::class);
    }
}
