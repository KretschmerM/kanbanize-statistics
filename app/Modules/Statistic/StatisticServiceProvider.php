<?php
namespace App\Modules\Statistic;
use App\Modules\Statistic\Contracts\StatisticResultRepositoryContract;
use App\Modules\Statistic\Repositories\StatisticResultRepository;
use Illuminate\Support\ServiceProvider;

class StatisticServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;
    public function boot()
    {
    }
    public function register()
    {
        $this->app->bind(StatisticResultRepositoryContract::class, StatisticResultRepository::class);
    }
    public function provides()
    {
        return [
            StatisticResultRepositoryContract::class,
        ];
    }
}
