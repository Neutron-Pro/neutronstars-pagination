# Pagination API for PHP

![Example Pagination 1](exemples/assets/img/pagination-1.jpg)
![Example Pagination 2](exemples/assets/img/pagination-2.jpg)

#Installation

```
composer require neutronstars/pagination
```
```json
{
  "require": {
    "neutronstars/pagination": ">=1.1.*"
  }
}
```

If you want use the css style:
```html
<link rel="stylesheet" href="https://neutron-pro.github.io/neutronstars-pagination/exemples/assets/css/style.css">
```

#Example

```php
<?php
  require_once __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'vendor'.DIRECTORY_SEPARATOR.'autoload.php';
  use NeutronStars\Pagination\Pagination;
  
  $currentPage = 1;
  $itemPerPage = 10;
  $totalItem = 200;
  echo new Pagination($currentPage, $itemPerPage, $totalItem);

```

#Options

```php
<?php
  require_once __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'vendor'.DIRECTORY_SEPARATOR.'autoload.php';
  use NeutronStars\Pagination\Pagination;

  $options = [
     'range'         => 3,
     'key'           => ':page',
     'url'           => '?page=:page',
     'build-empty'   => false,
     'previous-next' => [
       'active'           => false,
       'next-content'     => 'Next',
       'previous-content' => 'Previous',
       'hidden'           => true
     ],
     'first-last'    => [
       'active'        => false,
       'first-content' => '«',
       'last-content'  => '»',
       'hidden'        => true
     ],
     'css'           => [
        'parent-class'               => 'pagination',
        'child-class'                => 'pagination-item',
        'child-class-active'         => 'pagination-item-active',
        'separator-class'            => 'pagination-separator',
        'separator-content'          => '...',
        'previous-next-class'        => 'pagination-pn-item',
        'previous-next-class-active' => 'pagination-pn-item-active',
        'first-last-class'           => 'pagination-fl-item',
        'first-last-class-active'    => 'pagination-fl-item-active'
     ]
  ];

  $currentPage = 1;
  $itemPerPage = 10;
  $totalItem = 200;
  echo new Pagination($currentPage, $itemPerPage, $totalItem, $options);
```

#Callback

```php
<?php
  require_once __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'vendor'.DIRECTORY_SEPARATOR.'autoload.php';
  use NeutronStars\Pagination\Pagination;
  use NeutronStars\Pagination\PaginatorCallback;

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
```

#PaginatorCallback

```php
<?php
namespace Your\Namespace;

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
```

```php
<?php
  require_once __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'vendor'.DIRECTORY_SEPARATOR.'autoload.php';
  use NeutronStars\Pagination\Pagination;
  use Your\Namespace\ExamplePaginatorCallback;
  
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

  echo $pagination->toHTML(new ExamplePaginatorCallback($pagination));
```
