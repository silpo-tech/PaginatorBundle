<?php

declare(strict_types=1);

namespace App\Tests\Paginator;

use PaginatorBundle\Paginator\OffsetPaginator;
use PaginatorBundle\Paginator\PagePaginator;
use PHPUnit\Framework\TestCase;

class PaginatorTest extends TestCase
{
    public function testOffsetPaginator(): void
    {
        $paginator = new OffsetPaginator(0, 100);

        self::assertEquals([
            'limit' => 100,
            'offset' => 0,
        ], $paginator->serialize());
    }

    public function testPagePaginator(): void
    {
        $paginator = new PagePaginator(5, 20);
        self::assertEquals(5, $paginator->getPage());
        self::assertEquals([
            'limit' => 20,
            'offset' => 80,
        ], $paginator->serialize());
    }
}
