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
     * @test
     * @dataProvider jsonContentTypes
     */
    public function it_transforms_requests_with_a_json_content_type($contentType)
    {
        $data = ['foo' => 'bar'];
        $request = $this->createRequest($contentType, json_encode($data));
        $event = $this->createGetResponseEventMock($request);

        $this->listener->onKernelRequest($event);

        $this->assertEquals($data, $event->getRequest()->request->all());
        $this->assertNull($event->getResponse());
    }

    /**
     * @test
     */
    public function it_returns_a_bad_request_response_if_json_is_invalid()
    {
        $request = $this->createRequest('application/json', '{meh}');
        $event = $this->createGetResponseEventMock($request);

        $this->listener->onKernelRequest($event);

        $this->assertEquals(400, $event->getResponse()->getStatusCode());
    }

    /**
     * @test
     * @dataProvider notJsonContentTypes
     */
    public function it_does_not_transform_other_content_types($contentType)
    {
        $request = $this->createRequest($contentType, 'some=body');
        $event = $this->createGetResponseEventMock($request);

        $this->listener->onKernelRequest($event);

        $this->assertEquals($request, $event->getRequest());
        $this->assertNull($event->getResponse());
    }

    /**
     * @test
     */
    public function it_does_not_replace_request_data_if_there_is_none()
    {
        $request = $this->createRequest('application/json', '');
        $event = $this->createGetResponseEventMock($request);

        $this->listener->onKernelRequest($event);

        $this->assertEquals($request, $event->getRequest());
        $this->assertNull($event->getResponse());
    }

    /**
     * @test
     */
    public function it_does_not_replace_request_data_if_content_is_json_null()
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

    private function createRequest($contentType, $body)
    {
        $request = new Request([], [], [], [], [], [], $body);
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
                ['text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8']
        ];
    }

}
