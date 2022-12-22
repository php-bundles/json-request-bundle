<?php declare(strict_types=1);

namespace SymfonyBundles\JsonRequestBundle\Tests\Fixture\App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

final class ExampleController
{
    public function index(Request $request): JsonResponse
    {
        return new JsonResponse($request->request->all());
    }
}
