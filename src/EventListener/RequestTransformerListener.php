<?php declare(strict_types=1);

namespace SymfonyBundles\JsonRequestBundle\EventListener;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\RequestEvent;

final class RequestTransformerListener
{
    private array $contentTypes;

    public function __construct(array $contentTypes)
    {
        $this->contentTypes = $contentTypes;
    }

    public function onKernelRequest(RequestEvent $event): void
    {
        $request = $event->getRequest();

        if (false === $this->supports($request)) {
            return;
        }

        try {
            $data = \json_decode((string) $request->getContent(), true, 512, \JSON_THROW_ON_ERROR);

            if (\is_array($data)) {
                $request->request->replace($data);
            }
        } catch (\JsonException $exception) {
            $event->setResponse(new JsonResponse(['message' => $exception->getMessage()], Response::HTTP_BAD_REQUEST));
        }
    }

    private function supports(Request $request): bool
    {
        return in_array(method_exists($request, 'getContentTypeFormat') ? $request->getContentTypeFormat() : $request->getContentType(), $this->contentTypes, true) && $request->getContent();
    }
}
