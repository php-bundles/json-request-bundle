<?php declare(strict_types=1);

namespace SymfonyBundles\JsonRequestBundle\Tests\Fixture\App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

final class ExampleController
{
    /**
     * @Route("/")
     */
    public function index(Request $request): JsonResponse
    {
        return new JsonResponse($request->request->all());
    }
}
