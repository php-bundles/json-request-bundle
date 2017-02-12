<?php

namespace SymfonyBundles\JsonRequestBundle\Tests;

abstract class TestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Symfony\Component\DependencyInjection\ContainerInterface
     */
    protected $container;

    public function setUp()
    {
        $this->container = Kernel::make()->getContainer();
    }
}
