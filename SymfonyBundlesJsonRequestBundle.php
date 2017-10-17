<?php

namespace SymfonyBundles\JsonRequestBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class SymfonyBundlesJsonRequestBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function getContainerExtension()
    {
        return new DependencyInjection\JsonRequestExtension();
    }
}
