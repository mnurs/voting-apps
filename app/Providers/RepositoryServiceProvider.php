<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            'App\Interfaces\MemberRepositoryInterface',
            'App\Repositories\MemberRepository'
        );

        $this->app->bind(
            'App\Interfaces\CandidateRepositoryInterface',
            'App\Repositories\CandidateRepository'
        );

        $this->app->bind(
            'App\Interfaces\UserRepositoryInterface',
            'App\Repositories\UserRepository'
        );

        $this->app->bind(
            'App\Interfaces\PilketumRepositoryInterface',
            'App\Repositories\PilketumRepository'
        );

        $this->app->bind(
            'App\Interfaces\PilketumVoterRepositoryInterface',
            'App\Repositories\PilketumVoterRepository'
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
