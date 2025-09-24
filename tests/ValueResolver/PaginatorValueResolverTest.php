<?php

declare(strict_types=1);

namespace App\Tests\ValueResolver;

use PaginatorBundle\Paginator\OffsetPaginator;
use PaginatorBundle\Request\ValueResolver\OffsetPaginatorValueResolver;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

class PaginatorValueResolverTest extends TestCase
{
    #[DataProvider('paginatorDataProvider')]
    public function testPaginatorValueResolver(
        string $paginatorResolverClass,
        string $paginatorClass,
        int $defaultLimit,
        array $requestParams,
        int $expectedLimit,
        int $expectedOffset,
    ): void {
        /** @var ValueResolverInterface $valueResolver */
        $valueResolver = new $paginatorResolverClass($defaultLimit);
        $request = new Request($requestParams, [], $requestParams);

        $argumentMetadata = $this->createMock(ArgumentMetadata::class);
        $argumentMetadata->method('getType')->willReturn($paginatorClass);

        $paginatorList = $valueResolver->resolve($request, $argumentMetadata);
        self::assertCount(1, $paginatorList);

        $paginator = $paginatorList[0];
        self::assertEquals($expectedLimit, $paginator->getLimit());
        self::assertEquals($expectedOffset, $paginator->getOffset());
    }

    public static function paginatorDataProvider(): iterable
    {
        yield 'offset paginator with default options' => [
            'paginatorResolverClass' => OffsetPaginatorValueResolver::class,
            'paginatorClass' => OffsetPaginator::class,
            'defaultLimit' => 50,
            'requestParams' => [],
            'expectedLimit' => 50,
            'expectedOffset' => 0,
        ];

        yield 'offset paginator with custom options' => [
            'paginatorResolverClass' => OffsetPaginatorValueResolver::class,
            'paginatorClass' => OffsetPaginator::class,
            'defaultLimit' => 50,
            'requestParams' => [
                'limit' => 20,
                'offset' => 10,
            ],
            'expectedLimit' => 20,
            'expectedOffset' => 10,
        ];
    }
}
