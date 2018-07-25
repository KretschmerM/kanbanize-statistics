<?php
namespace App\Modules\Statistic;

use Illuminate\Routing\Router;
use App\Providers\RouteServiceProvider;

class StatisticRouteServiceProvider extends RouteServiceProvider
{

    public function map(Router $router)
    {
        $router->group(['namespace' => '\App\Modules\Statistic\Controllers', 'middleware' => 'web'],
            function(Router $router)
            {
                $router->get('/statistic/generate', 'StatisticResultController@loadDataOnButtonClick');
            }
        );

    }

}
