<?php

namespace Ciastek92\RepositoryMaker;

use Ciastek92\RepositoryMaker\Commands\MakeRepositoryCommand;
use Illuminate\Support\ServiceProvider;

class RepositoryMakerServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                MakeRepositoryCommand::class,
            ]);
        }
    }

}