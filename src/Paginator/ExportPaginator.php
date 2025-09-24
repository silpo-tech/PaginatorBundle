<?php

declare(strict_types=1);

namespace PaginatorBundle\Paginator;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class ExportPaginator
 */
class ExportPaginator extends OffsetPaginator
{
    /**
     * @var int
     */
    #[Assert\Range(min: 1, max: 10000)]
    private $limit;
}
