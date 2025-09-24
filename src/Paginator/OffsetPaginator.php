<?php

declare(strict_types=1);

namespace PaginatorBundle\Paginator;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class OffsetPaginator
 */
class OffsetPaginator implements OffsetPaginatorInterface
{
    /**
     * @var int
     */
    #[Assert\Range(min: 0, max: 4294967295)]
    private $offset;

    /**
     * @var int
     */
    #[Assert\Range(min: 1, max: 100)]
    private $limit;

    /**
     * OffsetPaginator constructor.
     *
     * @param int $offset
     * @param int $limit
     */
    public function __construct(int $offset, int $limit)
    {
        $this->offset = $offset;
        $this->limit = $limit;
    }

    /**
     * @return int
     */
    public function getOffset(): int
    {
        return $this->offset;
    }

    /**
     * @return int
     */
    public function getLimit(): int
    {
        return $this->limit;
    }

    /**
     * @param PaginatableInterface $collection
     */
    public function paginate(PaginatableInterface $collection): void
    {
        $collection->setOffset($this->getOffset());
        $collection->setLimit($this->getLimit());
    }

    /**
     * @return array
     */
    public function serialize(): array
    {
        return [
            'limit' => $this->getLimit(),
            'offset' => $this->getOffset(),
        ];
    }
}
