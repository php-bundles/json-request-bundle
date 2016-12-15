<?php

namespace SymfonyBundles\JsonRequestBundle\Tests;

class Kernel
{

    /**
     * @var Fixtures\app\AppKernel
     */
    private static $instance;

    /**
     * @return Fixtures\app\AppKernel
     */
    public static function make()
    {
        if (null === static::$instance) {
            static::$instance = new Fixtures\app\AppKernel('test', true);

            static::$instance->boot();
        }

        return static::$instance;
    }

}
