<?php


namespace NeutronStars\Exemples;

use NeutronStars\Pagination\Pagination;
use NeutronStars\Pagination\PaginatorCallback;

class ExamplePaginatorCallback implements PaginatorCallback
{
    private Pagination $pagination;

    public function __construct(Pagination $pagination)
    {
        $this->pagination = $pagination;
    }

    public function __invoke(int $type, int $page): string
    {
        switch ($type)
        {
            case self::SEPARATOR_TYPE:
                return '<span class="pagination-separator">...</span>';
            case self::FIRST_PAGE_TYPE:
                return '<a href="?page=1" class="pagination-fl-item'
                    .($page == 1 ? ' pagination-fl-item-active' : '').'">↞</a>';
            case self::PREVIOUS_PAGE_TYPE:
                return '<a href="?page='.(max($page-1, 1))
                    .'" class="pagination-pn-item'.($page == 1 ? ' pagination-pn-item-active': '').'">Previous</a>';
            case self::PAGE_TYPE:
                return '<a href="?page='.$page.'" class="pagination-item">'.$page.'</a>';
            case self::CURRENT_PAGE_TYPE:
                return '<a href="?page='.$page.'" class="pagination-item pagination-item-active">'.$page.'</a>';
            case self::NEXT_PAGE_TYPE:
                return '<a href="?page='.min($page+1, $this->pagination->getMaxPage())
                    .'" class="pagination-pn-item'.($page == $this->pagination->getMaxPage() ? ' pagination-pn-item-active' : '').'">Next</a>';
            case self::LAST_PAGE_TYPE:
                return '<a href="?page='.$this->pagination->getMaxPage().'" class="pagination-fl-item'
                    .($page == $this->pagination->getMaxPage() ? ' pagination-fl-item-active' : '').'">↠</a>';
        }
        return '';
    }
}
