<?php

declare(strict_types=1);

namespace PaginatorBundle\Paginator;

use Symfony\Component\Validator\Constraints as Assert;

class PagePaginator extends OffsetPaginator
{
    private int $offset;
    private int $limit;

    #[Assert\Range(min: 1, max: 4294967295)]
    private int $page;

    public function __construct(int $page, int $limit)
    {
        $this->page = $page;
        $this->limit = $limit;

        $this->offset = abs($this->page * $this->limit) - $this->limit;

        parent::__construct($this->offset, $this->limit);
    }

    public function getPage(): int
    {
        return $this->page;
    }
}
