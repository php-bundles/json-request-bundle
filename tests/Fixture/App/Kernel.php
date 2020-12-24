<?php declare(strict_types=1);

namespace SymfonyBundles\JsonRequestBundle\Tests\Fixture\App;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

final class Kernel extends BaseKernel
{
    use MicroKernelTrait;

    public function registerBundles(): iterable
    {
        return [
            new \Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new \SymfonyBundles\JsonRequestBundle\JsonRequestBundle(),
        ];
    }

    public function shutdown(): void
    {
        parent::shutdown();

        (new Filesystem())->remove($this->getCacheDir());
    }

    protected function configureContainer(ContainerConfigurator $container): void
    {
        $container->import('../config/config.yml');
    }

    protected function configureRoutes(RoutingConfigurator $routes): void
    {
        $routes->import('../config/routes.yml');
    }
}
