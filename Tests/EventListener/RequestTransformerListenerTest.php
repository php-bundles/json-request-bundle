<?php

namespace SymfonyBundles\JsonRequestBundle\Tests\EventListener;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use SymfonyBundles\JsonRequestBundle\Tests\TestCase;
use SymfonyBundles\JsonRequestBundle\EventListener\RequestTransformerListener;

class RequestTransformerListenerTest extends TestCase
{
    /**
     * @var RequestTransformerListener
     */
    private $listener;

    public function setUp(): void
    {
        $this->listener = new RequestTransformerListener();
    }

    /**
     * @param string $contentType
     *
     * @dataProvider jsonContentTypes
     */
    public function testTransformRequest(string $contentType): void
    {
        $data = ['foo' => 'bar'];
        $request = $this->createRequest($contentType, \json_encode($data));
        $event = $this->createGetResponseEventMock($request);

        $this->listener->onKernelRequest($event);

        $this->assertEquals($data, $event->getRequest()->request->all());
        $this->assertNull($event->getResponse());
    }

    /**
     * @param string $contentType
     *
     * @dataProvider jsonContentTypes
     */
    public function testDoNotTransformRequestContainingScalarJsonValue(string $contentType): void
    {
        $content = \json_encode('foo');
        $request = $this->createRequest($contentType, $content);
        $event = $this->createGetResponseEventMock($request);

        $this->listener->onKernelRequest($event);

        $this->assertEquals([], $event->getRequest()->request->all());
        $this->assertEquals($content, $event->getRequest()->getContent());
    }

    public function testBadRequestResponse(): void
    {
        $request = $this->createRequest('application/json', '{maaan}');
        $event = $this->createGetResponseEventMock($request);

        $this->listener->onKernelRequest($event);

        $this->assertEquals(400, $event->getResponse()->getStatusCode());
    }

    /**
     * @param string $contentType
     *
     * @dataProvider notJsonContentTypes
     */
    public function testNotTransformOtherContentType(string $contentType): void
    {
        $request = $this->createRequest($contentType, 'some=body');
        $event = $this->createGetResponseEventMock($request);

        $this->listener->onKernelRequest($event);

        $this->assertEquals($request, $event->getRequest());
        $this->assertNull($event->getResponse());
    }

    public function testNotReplaceRequestData(): void
    {
        $request = $this->createRequest('application/json', '');
        $event = $this->createGetResponseEventMock($request);

        $this->listener->onKernelRequest($event);

        $this->assertEquals($request, $event->getRequest());
        $this->assertNull($event->getResponse());
    }

    public function testNotReplaceRequestDataIfNullContent(): void
    {
        $request = $this->createRequest('application/json', 'null');
        $event = $this->createGetResponseEventMock($request);

        $this->listener->onKernelRequest($event);

        $this->assertEquals($request, $event->getRequest());
        $this->assertNull($event->getResponse());
    }

    private function createGetResponseEventMock(Request $request): RequestEvent
    {
        $event = $this
            ->getMockBuilder(RequestEvent::class)
            ->disableOriginalConstructor()
            ->setMethods(['getRequest'])
            ->getMock();

        $event->expects($this->any())->method('getRequest')->will($this->returnValue($request));

        return $event;
    }

    private function createRequest(string $contentType, string $content): Request
    {
        $request = new Request([], [], [], [], [], [], $content);
        $request->headers->set('CONTENT_TYPE', $contentType);

        return $request;
    }

    public function jsonContentTypes(): array
    {
        return [
            ['application/json'],
            ['application/x-json'],
        ];
    }

    public function notJsonContentTypes(): array
    {
        return [
            ['application/x-www-form-urlencoded'],
            ['text/html'],
            ['text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8'],
        ];
    }
}
