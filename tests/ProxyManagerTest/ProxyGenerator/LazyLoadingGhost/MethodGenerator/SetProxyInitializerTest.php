<?php

declare(strict_types=1);

namespace ProxyManagerTest\ProxyGenerator\LazyLoadingGhost\MethodGenerator;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use ProxyManager\ProxyGenerator\LazyLoadingGhost\MethodGenerator\SetProxyInitializer;
use Zend\Code\Generator\ParameterGenerator;
use Zend\Code\Generator\PropertyGenerator;
use Zend\Code\Generator\TypeGenerator;
use function array_shift;

/**
 * Tests for {@see \ProxyManager\ProxyGenerator\LazyLoadingGhost\MethodGenerator\SetProxyInitializer}
 *
 * @group Coverage
 */
final class SetProxyInitializerTest extends TestCase
{
    /**
     * @covers \ProxyManager\ProxyGenerator\LazyLoadingGhost\MethodGenerator\SetProxyInitializer::__construct
     */
    public function testBodyStructure() : void
    {
        /** @var PropertyGenerator&MockObject $initializer */
        $initializer = $this->createMock(PropertyGenerator::class);

        $initializer->method('getName')->willReturn('foo');

        $setter     = new SetProxyInitializer($initializer);
        $parameters = $setter->getParameters();

        self::assertSame('setProxyInitializer', $setter->getName());
        self::assertCount(1, $parameters);

        $initializer = array_shift($parameters);

        self::assertSame('initializer', $initializer->getName());
        self::assertSame('$this->foo = $initializer;', $setter->getBody());
        self::assertEquals(TypeGenerator::fromTypeString('void'), $setter->getReturnType());
    }
}
