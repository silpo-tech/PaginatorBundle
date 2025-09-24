<?php

declare(strict_types=1);

namespace PaginatorBundle\Paginator;

/**
 * Interface PaginatableInterface.
 */
interface PaginatableInterface
{
    public function setLimit(int $limit): void;

    public function setOffset(int $offset): void;
}
