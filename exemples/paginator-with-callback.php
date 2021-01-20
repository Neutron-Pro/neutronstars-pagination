<?php
    require_once __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'vendor'.DIRECTORY_SEPARATOR.'autoload.php';
    use NeutronStars\Pagination\Pagination;
    use NeutronStars\Pagination\PaginatorCallback;
    use NeutronStars\Exemples\ExamplePaginatorCallback;

    include __DIR__.DIRECTORY_SEPARATOR.'includes/header.php';

    $pagination = new Pagination(25, 10, 459, [
        'first-last'    => [
            'active' => true,
            'hidden' => false
        ],
        'previous-next' => [
            'active' => true,
            'hidden' => false
        ]
    ]);

    echo $pagination->toHTML(function ($type, $page) use ($pagination) {
            switch ($type)
            {
                case PaginatorCallback::SEPARATOR_TYPE:
                    return '<span class="pagination-separator">...</span>';
                case PaginatorCallback::FIRST_PAGE_TYPE:
                    return '<a href="?page=1" class="pagination-fl-item'
                        .($page == 1 ? ' pagination-fl-item-active' : '').'">↞</a>';
                case PaginatorCallback::PREVIOUS_PAGE_TYPE:
                    return '<a href="?page='.(max($page-1, 1))
                        .'" class="pagination-pn-item'.($page == 1 ? ' pagination-pn-item-active': '').'">Previous</a>';
                case PaginatorCallback::PAGE_TYPE:
                    return '<a href="?page='.$page.'" class="pagination-item">'.$page.'</a>';
                case PaginatorCallback::CURRENT_PAGE_TYPE:
                    return '<a href="?page='.$page.'" class="pagination-item pagination-item-active">'.$page.'</a>';
                case PaginatorCallback::NEXT_PAGE_TYPE:
                    return '<a href="?page='.min($page+1, $pagination->getMaxPage())
                        .'" class="pagination-pn-item'.($page == $pagination->getMaxPage() ? ' pagination-pn-item-active' : '').'">Next</a>';
                case PaginatorCallback::LAST_PAGE_TYPE:
                    return '<a href="?page='.$pagination->getMaxPage().'" class="pagination-fl-item'
                        .($page == $pagination->getMaxPage() ? ' pagination-fl-item-active' : '').'">↠</a>';
            }
            return '';
        });

    echo '<hr>';

    echo $pagination->toHTML(new ExamplePaginatorCallback($pagination));

    include __DIR__.DIRECTORY_SEPARATOR.'includes/footer.php';
