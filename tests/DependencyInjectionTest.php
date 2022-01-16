<?php declare(strict_types=1);

namespace SymfonyBundles\JsonRequestBundle\Tests;

use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use SymfonyBundles\JsonRequestBundle\DependencyInjection\JsonRequestExtension;
use SymfonyBundles\JsonRequestBundle\EventListener\RequestTransformerListener;

class DependencyInjectionTest extends TestCase
{
    protected ContainerBuilder $containerBuilder;

    protected function setUp(): void
    {
        parent::setUp();

        $this->containerBuilder = new ContainerBuilder();
    }

    public function testContentTypesNotSet(): void
    {
        $extension = new JsonRequestExtension();
        $config = [];

        $extension->load([$config], $this->containerBuilder);

        $this->assertContentTypes(['json', 'jsonld']);
    }

    public function testContentTypesIsNull(): void
    {
        $extension = new JsonRequestExtension();
        $config = [
            'content_types' => null,
        ];

        $extension->load([$config], $this->containerBuilder);

        $this->assertContentTypes(['json', 'jsonld']);
    }

    public function testContentTypesAnotherArray(): void
    {
        $extension = new JsonRequestExtension();
        $config = [
            'content_types' => ['json', 'someother'],
        ];

        $extension->load([$config], $this->containerBuilder);

        $this->assertContentTypes(['json', 'someother']);
    }

    public function testContentTypesAnotherInteger(): void
    {
        $extension = new JsonRequestExtension();
        $config = [
            'content_types' => [42],
        ];

        $extension->load([$config], $this->containerBuilder);

        $this->assertContentTypes([42]);
    }

    public function testContentTypesShouldHaveAtLeastOneElement(): void
    {
        $this->expectExceptionMessage('should have at least 1 element(s) defined.');

        $extension = new JsonRequestExtension();
        $config = [
            'content_types' => [],
        ];

        $extension->load([$config], $this->containerBuilder);
    }

    public function testContentTypesExpectedScalarStdClassGiven(): void
    {
        $this->expectExceptionMessage('Expected "scalar", but got "stdClass".');

        $extension = new JsonRequestExtension();
        $config = [
            'content_types' => [new \stdClass()],
        ];

        $extension->load([$config], $this->containerBuilder);
    }

    public function testContentTypesExpectedScalarArrayGiven(): void
    {
        $this->expectExceptionMessage('Expected "scalar", but got "array"');

        $extension = new JsonRequestExtension();
        $config = [
            'content_types' => ['json', ['array']],
        ];

        $extension->load([$config], $this->containerBuilder);
    }

    private function assertContentTypes(array $expected)
    {
        $listenerDefinition = $this->containerBuilder->findDefinition(RequestTransformerListener::class);
        $this->assertEquals($expected, $listenerDefinition->getArgument(0));
    }
}
