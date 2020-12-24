<?php declare(strict_types=1);

namespace SymfonyBundles\JsonRequestBundle\Tests\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class ExampleControllerTest extends WebTestCase
{
    public function testTransformRequest(): void
    {
        $body = \json_encode(['foo' => 'baz']);

        $response = $this->sendRequest($body);

        $this->assertSame($body, $response->getContent());
    }

    public function testInvalidBody(): void
    {
        $response = $this->sendRequest('{$body}');

        $this->assertSame('{"message":"Syntax error"}', $response->getContent());
        $this->assertSame(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
    }


    public function testInvalidContentType(): void
    {
        $body = \json_encode(['foo' => 'baz']);

        $response = $this->sendRequest($body, 'application/javascript');

        $this->assertSame('[]', $response->getContent());
    }

    /**
     * @param mixed  $body
     * @param string $contentType
     *
     * @return Response
     */
    private function sendRequest($body, string $contentType = 'application/json'): Response
    {
        $client = self::createClient();

        $client->request(Request::METHOD_POST, '/', [], [], ['CONTENT_TYPE' => $contentType], $body);

        return $client->getResponse();
    }
}
