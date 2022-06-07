<?php

namespace Zinc\providers;


use Pimple\Container;
use Pimple\Tests\Fixtures\PimpleServiceProvider;

class Index extends PimpleServiceProvider
{
    public function register(Container $pimple)
    {
        $pimple['index'] = function ($app) {
            return new \Zinc\services\Index($app['client'], $app['auth']);
        };
    }

}
