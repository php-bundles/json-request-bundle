<?php

namespace SymfonyBundles\JsonRequestBundle\Tests\DependencyInjection;

use Symfony\Component\Config\Definition\Processor;
use SymfonyBundles\JsonRequestBundle\Tests\TestCase;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use SymfonyBundles\JsonRequestBundle\DependencyInjection\Configuration;

class ConfigurationTest extends TestCase
{
    public function testConfiguration()
    {
        $processor = new Processor();
        $configuration = new Configuration();

        $this->assertInstanceOf(ConfigurationInterface::class, $configuration);

        $configs = $processor->processConfiguration($configuration, []);

        $this->assertArraySubset([], $configs);
    }
}
