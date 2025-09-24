<?php

declare(strict_types=1);

namespace PaginatorBundle\Paginator;

/**
 * Interface PaginatableInterface
 */
interface PaginatableInterface
{
    /**
     * @param int $limit
     */
    public function setLimit(int $limit): void;

    /**
     * @param int $offset
     */
    public function setOffset(int $offset): void;
}
