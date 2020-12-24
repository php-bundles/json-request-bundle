<?php declare(strict_types=1);

namespace SymfonyBundles\JsonRequestBundle\DependencyInjection;

use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use SymfonyBundles\JsonRequestBundle\EventListener\RequestTransformerListener;

final class JsonRequestExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container): void
    {
        $listener = new Definition(RequestTransformerListener::class);
        $listener->addTag('kernel.event_listener', ['event' => KernelEvents::REQUEST]);

        $container->setDefinition(RequestTransformerListener::class, $listener);
    }
}
