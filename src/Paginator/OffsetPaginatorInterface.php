<?php

declare(strict_types=1);

namespace PaginatorBundle\Paginator;

/**
 * Interface OffsetPaginatorInterface.
 */
interface OffsetPaginatorInterface extends PaginatorInterface
{
    public function getOffset(): int;

    public function getLimit(): int;
}
