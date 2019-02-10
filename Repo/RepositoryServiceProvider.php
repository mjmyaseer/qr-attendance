<?php

namespace Repo;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(
            \Repo\Contracts\CategoryInterface::class,
            \Repo\Mysql\CategoryRepo::class
        );

        $this->app->bind(
            \Repo\Contracts\CustomerInterface::class,
            \Repo\Mysql\CustomerRepo::class
        );

        $this->app->bind(
            \Repo\Contracts\BranchInterface::class,
            \Repo\Mysql\BranchRepo::class
        );

        $this->app->bind(
            \Repo\Contracts\CityInterface::class,
            \Repo\Mysql\CityRepo::class
        );

        $this->app->bind(
            \Repo\Contracts\OTPInterface::class,
            \Repo\Mysql\OTPRepo::class
        );

        $this->app->bind(
            \Repo\Contracts\EventInterface::class,
            \Repo\Mysql\EventRepo::class
        );

    }
}