<?php

namespace SymfonyBundles\JsonRequestBundle\Tests;

abstract class TestCase extends \PHPUnit\Framework\TestCase
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
