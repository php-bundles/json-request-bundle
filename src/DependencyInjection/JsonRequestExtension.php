<?php

declare(strict_types=1);

namespace SymfonyBundles\JsonRequestBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\HttpKernel\KernelEvents;
use SymfonyBundles\JsonRequestBundle\EventListener\RequestTransformerListener;

final class JsonRequestExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container): void
    {
        $processor = new Processor();
        $config = $processor->processConfiguration(new Configuration(), $configs);

        $container->register(RequestTransformerListener::class)
            ->addArgument($config['content_types'])
            ->addTag('kernel.event_listener', ['event' => KernelEvents::REQUEST, 'priority' => 100]);
    }
}
