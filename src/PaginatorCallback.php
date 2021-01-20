<?php


namespace NeutronStars\Pagination;

/**
 * Interface PaginatorCallback
 * @package NeutronStars\Pagination
 */
interface PaginatorCallback
{
    const FIRST_PAGE_TYPE = 0;
    const PREVIOUS_PAGE_TYPE = 1;
    const CURRENT_PAGE_TYPE = 2;
    const PAGE_TYPE = 3;
    const NEXT_PAGE_TYPE = 4;
    const LAST_PAGE_TYPE = 5;
    const SEPARATOR_TYPE = 6;

    /**
     * @param int $type
     * @param int $page
     * @return string
     */
    public function __invoke(int $type, int $page): string;
}
