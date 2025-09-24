<?php

declare(strict_types=1);

namespace PaginatorBundle\Paginator;

/**
 * Interface OffsetPaginatorInterface
 */
interface OffsetPaginatorInterface extends PaginatorInterface
{
    /**
     * @return int
     */
    public function getOffset(): int;

    /**
     * @return int
     */
    public function getLimit(): int;
}
