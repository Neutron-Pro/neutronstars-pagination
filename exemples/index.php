<?php
    require_once __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'vendor'.DIRECTORY_SEPARATOR.'autoload.php';
    use NeutronStars\Pagination\Pagination;


    include __DIR__.DIRECTORY_SEPARATOR.'includes/header.php';

    //Default initialization Pagination:
    echo new Pagination(7, 10, 700);

    echo '<hr>';

    //Change range count:
    echo new Pagination(59, 15, 900, ['range' => 5 ]);

    echo '<hr>';

    //Change url target:
    echo new Pagination(10, 2, 100, ['url' => '/articles/pages/:page' ]);

    echo '<hr>';

    //Change url target with key parser:
    echo new Pagination(25, 3, 278, ['url' => '/articles/pages/{num}', 'key' => '{num}' ]);

    echo '<hr>';

    //Add previous and next button:
    echo new Pagination(1, 2, 700, [
        'previous-next' => [
            'active' => true
        ]
    ]);

    echo '<hr>';

    //Show previous and next same if current page is first or last:
    echo new Pagination(350, 2, 700, [
        'previous-next' => [
            'active' => true,
            'hidden' => false
        ]
    ]);


    echo '<hr>';

    //Add first and last page button:
    echo new Pagination(1, 2, 700, [
        'first-last' => [
            'active' => true
        ]
    ]);


    echo '<hr>';

    //Show first and last page button same if current page is first or last:
    echo new Pagination(1, 2, 700, [
        'first-last' => [
            'active' => true,
            'hidden' => false
        ]
    ]);

    echo '<hr>';

    //Possibility active the first, last, previous and next button.
    echo new Pagination(350, 2, 700, [
        'previous-next' => [
            'active'    => true,
            'hidden'    => false
        ],
        'first-last'    => [
            'active'    => true,
            'hidden'    => false
        ]
    ]);

    echo '<hr>';

    //Possibility active the first, last, previous and next button.
    echo new Pagination(125, 2, 700, [
        'previous-next' => [
            'active'    => true,
            'hidden'    => false
        ],
        'first-last'    => [
            'active'    => true,
            'hidden'    => false
        ]
    ]);

    echo '<hr>';

    echo '<div style="display: flex; justify-content: center">';
    //Change CSS class for the pagination:
    echo new Pagination(59, 15, 900, [
        'css' => [
            'parent-class'       => 'pagination-two',
            'child-class'        => 'pagination-child',
            'child-class-active' => 'active',
            'separator-class'    => 'pagination-split',
            'separator-content'  => '-'
        ]
    ]);

    //Change CSS class for the pagination with previous, next, first and last button.
    echo new Pagination(1, 15, 900, [
        'css' => [
            'parent-class'               => 'pagination-two',
            'child-class'                => 'pagination-child',
            'child-class-active'         => 'active',
            'separator-class'            => 'pagination-split',
            'separator-content'          => '-',
            'previous-next-class'        => 'pagination-pn',
            'previous-next-class-active' => 'pagination-pn-active',
            'first-last-class'           => 'pagination-fl',
            'first-last-class-active'    => 'pagination-fl-active'
        ],
        'previous-next' => [
            'active'    => true,
            'hidden'    => false
        ],
        'first-last'    => [
            'active'    => true,
            'first-content' => '↟',
            'last-content' => '↡',
            'hidden'    => false
        ]
    ]);

    //Change CSS class for the pagination with previous, next, first and last button.
    echo new Pagination(60, 15, 900, [
        'css' => [
            'parent-class'               => 'pagination-two',
            'child-class'                => 'pagination-child',
            'child-class-active'         => 'active',
            'separator-class'            => 'pagination-split',
            'separator-content'          => '-',
            'previous-next-class'        => 'pagination-pn',
            'previous-next-class-active' => 'pagination-pn-active',
            'first-last-class'           => 'pagination-fl',
            'first-last-class-active'    => 'pagination-fl-active'
        ],
        'previous-next' => [
            'active'    => true,
            'hidden'    => false
        ],
        'first-last'    => [
            'active'    => true,
            'first-content' => '↟',
            'last-content' => '↡',
            'hidden'    => false
        ]
    ]);

    //Change CSS class for the pagination with previous, next, first and last button.
    echo new Pagination(30, 15, 900, [
        'css' => [
            'parent-class'               => 'pagination-two',
            'child-class'                => 'pagination-child',
            'child-class-active'         => 'active',
            'separator-class'            => 'pagination-split',
            'separator-content'          => '-',
            'previous-next-class'        => 'pagination-pn',
            'previous-next-class-active' => 'pagination-pn-active',
            'first-last-class'           => 'pagination-fl',
            'first-last-class-active'    => 'pagination-fl-active'
        ],
        'previous-next' => [
            'active'    => true,
            'hidden'    => false
        ]
    ]);
    echo '</div>';
    include __DIR__.DIRECTORY_SEPARATOR.'includes/footer.php';
