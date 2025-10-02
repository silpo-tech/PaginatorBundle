<?php

declare(strict_types=1);

namespace App\Tests\ValueResolver;

use ArrayIterator;
use Exception;
use ExceptionHandlerBundle\Exception\ValidationException;
use PaginatorBundle\Paginator\OffsetPaginator;
use PaginatorBundle\Paginator\PagePaginator;
use PaginatorBundle\Request\ValueResolver\OffsetPaginatorValueResolver;
use PaginatorBundle\Request\ValueResolver\PagePaginatorValueResolver;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Throwable;

class PaginatorValueResolverTest extends TestCase
{
    #[DataProvider('paginatorDataProvider')]
    public function testPaginatorValueResolver(
        string $paginatorResolverClass,
        string $paginatorClass,
        int $defaultLimit,
        array $requestParams = [],
        int|null $expectedLimit = null,
        int|null $expectedOffset = null,
        int|null $expectedPage = null,
        bool $expectedEmpty = false,
        bool $expectedValidationException = false,
    ): void
    {
        if ($expectedValidationException) {
            $validator = $this->createMock(ValidatorInterface::class);
            $constraintViolationList = $this->createMock(ConstraintViolationList::class);
            $constraintViolationList->method('count')->willReturn(1);
            $constraintViolationList->method('getIterator')->willReturn(new ArrayIterator([]));

            $validator->method('validate')->willReturn($constraintViolationList);
        } else {
            $validator = null;
        }

        /** @var ValueResolverInterface $valueResolver */
        $valueResolver = new $paginatorResolverClass($defaultLimit, $validator);
        $request = new Request($requestParams, [], $requestParams);

        $argumentMetadata = $this->createMock(ArgumentMetadata::class);
        $argumentMetadata->method('getType')->willReturn($paginatorClass);

        if ($expectedValidationException) {
            $this->expectException(ValidationException::class);
        }

        $paginatorList = $valueResolver->resolve($request, $argumentMetadata);

        if ($expectedEmpty) {
            self::assertCount(0, $paginatorList);
        } else {
            self::assertCount(1, $paginatorList);

            $paginator = $paginatorList[0];
            self::assertEquals($expectedLimit, $paginator->getLimit());
            self::assertEquals($expectedOffset, $paginator->getOffset());

            if ($expectedPage) {
                self::assertEquals($expectedPage, $paginator->getPage());
            }
        }
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
                'offset' => 10
            ],
            'expectedLimit' => 20,
            'expectedOffset' => 10,
        ];

        yield 'incorrect offset paginator' => [
            'paginatorResolverClass' => OffsetPaginatorValueResolver::class,
            'paginatorClass' => 'OtherClass',
            'defaultLimit' => 50,
            'expectedEmpty' => true,
        ];

        yield 'offset paginator validation exception' => [
            'paginatorResolverClass' => OffsetPaginatorValueResolver::class,
            'paginatorClass' => OffsetPaginator::class,
            'defaultLimit' => 50,
            'requestParams' => [
                'limit' => 20,
                'offset' => 10
            ],
            'expectedValidationException' => true,
        ];

        yield 'page paginator with default options' => [
            'paginatorResolverClass' => PagePaginatorValueResolver::class,
            'paginatorClass' => PagePaginator::class,
            'defaultLimit' => 50,
            'requestParams' => [],
            'expectedLimit' => 50,
            'expectedOffset' => 0,
            'expectedPage' => 1,
        ];

        yield 'page paginator with custom options' => [
            'paginatorResolverClass' => PagePaginatorValueResolver::class,
            'paginatorClass' => PagePaginator::class,
            'defaultLimit' => 50,
            'requestParams' => [
                'limit' => 20,
                'offset' => 2
            ],
            'expectedLimit' => 20,
            'expectedOffset' => 20,
            'expectedPage' => 2,
        ];

        yield 'incorrect page paginator' => [
            'paginatorResolverClass' => PagePaginatorValueResolver::class,
            'paginatorClass' => 'OtherClass',
            'defaultLimit' => 50,
            'expectedEmpty' => true,
        ];

        yield 'page paginator validation exception' => [
            'paginatorResolverClass' => PagePaginatorValueResolver::class,
            'paginatorClass' => PagePaginator::class,
            'defaultLimit' => 50,
            'requestParams' => [
                'limit' => 20,
                'offset' => 10
            ],
            'expectedValidationException' => true,
        ];
    }
}
