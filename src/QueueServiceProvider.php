<?php

namespace MorningMedley\Queue;

use Illuminate\Bus\BusServiceProvider;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Queue\Console\TableCommand;
use Illuminate\Queue\Console\WorkCommand;
use Illuminate\Queue\Console\WorkCommand as QueueWorkCommand;
use Illuminate\Support\Facades\Artisan;
use MorningMedley\Queue\Console\JobMakeCommand;

class QueueServiceProvider extends \Illuminate\Queue\QueueServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . "/config/config.php", 'queue');

        parent::register();

        $this->app->alias('queue', \Illuminate\Queue\QueueManager::class);
        $this->app->alias('queue', \Illuminate\Contracts\Queue\Factory::class);
        $this->app->alias('queue', \Illuminate\Contracts\Queue\Monitor::class);
        $this->app->alias('queue.connection', \Illuminate\Contracts\Queue\Queue::class);
        $this->app->alias('queue.failer', \Illuminate\Queue\Failed\FailedJobProviderInterface::class);

        $this->registerQueueTableCommand();
        $this->registerJobMakeCommand();
        $this->registerQueueWorkCommand();
    }

    public function boot()
    {

        $this->commands([
            TableCommand::class,
            JobMakeCommand::class,
            WorkCommand::class,
        ]);
    }

    protected function registerQueueTableCommand()
    {
        $this->app->singleton(TableCommand::class, function ($app) {
            return new TableCommand($app['files']);
        });
    }

    protected function registerJobMakeCommand()
    {
        $this->app->singleton(JobMakeCommand::class, function ($app) {
            return new JobMakeCommand($app['files']);
        });
    }

    protected function registerQueueWorkCommand()
    {
        $this->app->singleton(QueueWorkCommand::class, function ($app) {
            return new QueueWorkCommand($app['queue.worker'], $app['cache.store']);
        });
    }

    public function provides()
    {
        return [
            'queue',
            'queue.connection',
            'queue.failer',
            \Illuminate\Contracts\Queue\Factory::class,
            \Illuminate\Contracts\Queue\Monitor::class,
            \Illuminate\Contracts\Queue\Queue::class,
            \Illuminate\Queue\Failed\FailedJobProviderInterface::class,
        ];
    }
}
