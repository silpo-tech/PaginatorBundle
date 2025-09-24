<?php

declare(strict_types=1);

namespace PaginatorBundle\Paginator;

/**
 * Interface PaginatorInterface
 */
interface PaginatorInterface
{
    /**
     * @param PaginatableInterface $collection
     */
    public function paginate(PaginatableInterface $collection): void;

    /**
     * @return array
     */
    public function serialize(): array;
}
