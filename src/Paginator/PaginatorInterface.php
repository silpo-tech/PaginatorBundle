<?php

declare(strict_types=1);

namespace PaginatorBundle\Paginator;

/**
 * Interface PaginatorInterface.
 */
interface PaginatorInterface
{
    public function paginate(PaginatableInterface $collection): void;

    public function serialize(): array;
}
