<?php

namespace Zinc\providers;


use Pimple\Container;
use Pimple\Tests\Fixtures\PimpleServiceProvider;

class Document extends PimpleServiceProvider
{
    public function register(Container $pimple)
    {
        $pimple['document'] = function ($app) {
            return new \Zinc\services\Document($app['client'], $app['auth']);
        };
    }
}
