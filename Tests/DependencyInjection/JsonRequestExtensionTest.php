<?php

namespace SymfonyBundles\JsonRequestBundle\Tests\DependencyInjection;

use SymfonyBundles\JsonRequestBundle\Tests\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use SymfonyBundles\JsonRequestBundle\DependencyInjection\JsonRequestExtension;

class JsonRequestExtensionTest extends TestCase
{

    public function testHasListener()
    {
        $container = new ContainerBuilder();
        $extension = new JsonRequestExtension();
        $listenerService = 'sb_json_request.request_transformer';

        $this->assertInstanceOf(Extension::class, $extension);

        $extension->load([], $container);

        $this->assertTrue($container->has($listenerService));
    }

    public function testAlias()
    {
        $extension = new JsonRequestExtension();

        $this->assertStringEndsWith('json_request', $extension->getAlias());
    }

}
