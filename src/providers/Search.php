<?php

namespace Zinc\providers;


use Pimple\Container;
use Pimple\Tests\Fixtures\PimpleServiceProvider;

class Search extends PimpleServiceProvider
{
    public function register(Container $pimple)
    {
        $pimple['search'] = function ($app) {
            return new \Zinc\services\Search($app['client'], $app['auth']);
        };
    }

}
