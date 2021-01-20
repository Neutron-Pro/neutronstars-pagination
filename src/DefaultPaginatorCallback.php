<?php


namespace NeutronStars\Pagination;

class DefaultPaginatorCallback implements PaginatorCallback
{
    private Pagination $pagination;

    public function __construct(Pagination $pagination)
    {
        $this->pagination = $pagination;
    }

    public function __invoke(int $type, int $page): string
    {
        if($type == self::SEPARATOR_TYPE){
            return '<span class="'.$this->pagination->getOption('css','separator-class').'">'
                .$this->pagination->getOption('css','separator-content').'</span>';
        }

        $link = $this->pagination->buildUrl($page);
        $content = $page;
        $classes = [];
        switch ($type)
        {
            case self::CURRENT_PAGE_TYPE:
                $classes[1] = $this->pagination->getOption('css','child-class-active');
            case self::PAGE_TYPE:
                $classes[0] = $this->pagination->getOption('css','child-class');
                break;

            case self::PREVIOUS_PAGE_TYPE:
                $content = $this->pagination->getOption('previous-next','previous-content');
                $classes[] = $this->pagination->getOption('css','previous-next-class');
                if($page == 1) {
                    $classes[] = $this->pagination->getOption('css','previous-next-class-active');
                }else {
                    $link = $this->pagination->buildUrl($page-1);
                }
                break;
            case self::NEXT_PAGE_TYPE:
                $content = $this->pagination->getOption('previous-next','next-content');
                $classes[] = $this->pagination->getOption('css','previous-next-class');
                if($page == $this->pagination->getMaxPage()) {
                    $classes[] = $this->pagination->getOption('css','previous-next-class-active');
                }else {
                    $link = $this->pagination->buildUrl($page+1);
                }
                break;

            case self::FIRST_PAGE_TYPE:
                $content = $this->pagination->getOption('first-last','first-content');
                $classes[] = $this->pagination->getOption('css','first-last-class');
                if($page == 1) {
                    $classes[] = $this->pagination->getOption('css','first-last-class-active');
                }else {
                    $link = $this->pagination->buildUrl(1);
                }
                break;
            case self::LAST_PAGE_TYPE:
                $content = $this->pagination->getOption('first-last','last-content');
                $classes[] = $this->pagination->getOption('css','first-last-class');
                if($page == $this->pagination->getMaxPage()) {
                    $classes[] = $this->pagination->getOption('css','first-last-class-active');
                }else {
                    $link = $this->pagination->buildUrl($this->pagination->getMaxPage());
                }
                break;
        }
        return $this->buildLink($link, $content, $classes);
    }

    private function buildLink(string $link, string $content, array $classes): string
    {
        return '<a href="'.$link.'" class="'.implode(' ', $classes).'">'.$content.'</a>';
    }
}
