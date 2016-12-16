<?php

namespace SymfonyBundles\JsonRequestBundle\Tests\EventListener;

use Symfony\Component\HttpFoundation\Request;
use SymfonyBundles\JsonRequestBundle\Tests\TestCase;
use SymfonyBundles\JsonRequestBundle\EventListener\RequestTransformerListener;

class RequestTransformerListenerTest extends TestCase
{

    /**
     * @var RequestTransformerListener
     */
    private $listener;

    public function setUp()
    {
        $this->listener = new RequestTransformerListener();
    }

    /**
     * @dataProvider jsonContentTypes
     */
    public function testTransformRequest($contentType)
    {
        $data = ['foo' => 'bar'];
        $request = $this->createRequest($contentType, json_encode($data));
        $event = $this->createGetResponseEventMock($request);

        $this->listener->onKernelRequest($event);

        $this->assertEquals($data, $event->getRequest()->request->all());
        $this->assertNull($event->getResponse());
    }

    public function testBadRequestResponse()
    {
        $request = $this->createRequest('application/json', '{maaan}');
        $event = $this->createGetResponseEventMock($request);

        $this->listener->onKernelRequest($event);

        $this->assertEquals(400, $event->getResponse()->getStatusCode());
    }

    /**
     * @dataProvider notJsonContentTypes
     */
    public function testNotTransformOtherContentType($contentType)
    {
        $request = $this->createRequest($contentType, 'some=body');
        $event = $this->createGetResponseEventMock($request);

        $this->listener->onKernelRequest($event);

        $this->assertEquals($request, $event->getRequest());
        $this->assertNull($event->getResponse());
    }

    public function testNotReplaceRequestData()
    {
        $request = $this->createRequest('application/json', '');
        $event = $this->createGetResponseEventMock($request);

        $this->listener->onKernelRequest($event);

        $this->assertEquals($request, $event->getRequest());
        $this->assertNull($event->getResponse());
    }

    public function testNotReplaceRequestDataIfNullContent()
    {
        $request = $this->createRequest('application/json', 'null');
        $event = $this->createGetResponseEventMock($request);

        $this->listener->onKernelRequest($event);

        $this->assertEquals($request, $event->getRequest());
        $this->assertNull($event->getResponse());
    }

    private function createGetResponseEventMock(Request $request)
    {
        $event = $this->getMockBuilder('Symfony\Component\HttpKernel\Event\GetResponseEvent')
            ->disableOriginalConstructor()
            ->setMethods(['getRequest'])
            ->getMock();

        $event->expects($this->any())
            ->method('getRequest')
            ->will($this->returnValue($request));

        return $event;
    }

    private function createRequest($contentType, $content)
    {
        $request = new Request([], [], [], [], [], [], $content);
        $request->headers->set('CONTENT_TYPE', $contentType);

        return $request;
    }

    public function jsonContentTypes()
    {
        return [
                ['application/json'],
                ['application/x-json']
        ];
    }

    public function notJsonContentTypes()
    {
        return [
                ['application/x-www-form-urlencoded'],
                ['text/html'],
                ['text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8']
        ];
    }

}
