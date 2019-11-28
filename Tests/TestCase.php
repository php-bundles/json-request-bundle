<?php

namespace SymfonyBundles\JsonRequestBundle\Tests;

abstract class TestCase extends \PHPUnit\Framework\TestCase
{
    /**
     * @var \Symfony\Component\DependencyInjection\ContainerInterface
     */
    protected $container;

    public function setUp(): void
    {
        $this->container = Kernel::make()->getContainer();
    }
}
