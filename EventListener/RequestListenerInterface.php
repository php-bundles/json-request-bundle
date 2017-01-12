<?php

namespace SymfonyBundles\JsonRequestBundle\EventListener;

use Symfony\Component\HttpKernel\Event\GetResponseEvent;

interface RequestListenerInterface
{

    /**
     * @param GetResponseEvent $event
     */
    public function onKernelRequest(GetResponseEvent $event);
}
