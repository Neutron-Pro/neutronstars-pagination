<?php

namespace NeutronStars\Pagination;

/**
 * Class Pagination
 * @package NeutronStars\Pagination
 */
class Pagination
{
    private int $currentPage;
    private int $maxPage;
    private array $options;

    /**
     * Pagination constructor.
     *
     * <pre><code>
     *   $options = [
     *     'range'         => 3,
     *     'key'           => ':page',
     *     'url'           => '?page=:page',
     *     'build-empty'   => false,
     *     'previous-next' => [
     *       'active'           => false,
     *       'next-content'     => 'Next',
     *       'previous-content' => 'Previous',
     *       'hidden'           => true
     *     ],
     *     'first-last'    => [
     *       'active'        => false,
     *       'first-content' => '«',
     *       'last-content'  => '»',
     *       'hidden'        => true
     *     ],
     *     'css'           => [
     *        'parent-class'               => 'pagination',
     *        'child-class'                => 'pagination-item',
     *        'child-class-active'         => 'pagination-item-active',
     *        'separator-class'            => 'pagination-separator',
     *        'separator-content'          => '...',
     *        'previous-next-class'        => 'pagination-pn-item',
     *        'previous-next-class-active' => 'pagination-pn-item-active',
     *        'first-last-class'           => 'pagination-fl-item',
     *        'first-last-class-active'    => 'pagination-fl-item-active'
     *     ]
     *   ];
     * </code></pre>
     *
     * @param int $currentPage
     * @param int $itemPerPage
     * @param int $count
     * @param array $options
     */
    public function __construct(int $currentPage, int $itemPerPage, int $count, array $options = [])
    {
        $this->currentPage = $currentPage;
        $this->maxPage = ceil($count/$itemPerPage);
        $this->options = $this->fillDefaultOptions($options);
    }

    private function fillDefaultOptions($options): array
    {
        if(!isset($options['range'])) { $options['range'] = 3; }
        if($options['range']%2 == 0) { $options['range']++; }
        if(!isset($options['key'])) { $options['key'] = ':page'; }
        if(!isset($options['url'])) { $options['url'] = '?page=:page'; }
        if(!isset($options['build-empty'])) { $options['build-empty'] = false; }

        if(!isset($options['previous-next'])) { $options['previous-next'] = []; }
        if(!isset($options['previous-next']['active'])) { $options['previous-next']['active'] = false; }
        if(!isset($options['previous-next']['next-content'])) { $options['previous-next']['next-content'] = 'Next'; }
        if(!isset($options['previous-next']['previous-content'])) { $options['previous-next']['previous-content'] = 'Previous'; }
        if(!isset($options['previous-next']['hidden'])) { $options['previous-next']['hidden'] = true; }

        if(!isset($options['first-last'])) { $options['first-last'] = []; }
        if(!isset($options['first-last']['active'])) { $options['first-last']['active'] = false; }
        if(!isset($options['first-last']['first-content'])) { $options['first-last']['first-content'] = '↞'; }
        if(!isset($options['first-last']['last-content'])) { $options['first-last']['last-content'] = '↠'; }
        if(!isset($options['first-last']['hidden'])) { $options['first-last']['hidden'] = true; }

        if(!isset($options['css'])) { $options['css'] = []; }
        if(!isset($options['css']['parent-class'])) { $options['css']['parent-class'] = 'pagination'; }
        if(!isset($options['css']['child-class'])) { $options['css']['child-class'] = 'pagination-item'; }
        if(!isset($options['css']['child-class-active'])) { $options['css']['child-class-active'] = 'pagination-item-active'; }
        if(!isset($options['css']['separator-class'])) { $options['css']['separator-class'] = 'pagination-separator'; }
        if(!isset($options['css']['separator-content'])) { $options['css']['separator-content'] = '...'; }

        if(!isset($options['css']['previous-next-class'])) { $options['css']['previous-next-class'] = 'pagination-pn-item'; }
        if(!isset($options['css']['previous-next-class-active'])) { $options['css']['previous-next-class-active'] = 'pagination-pn-item-active'; }

        if(!isset($options['css']['first-last-class'])) { $options['css']['first-last-class'] = 'pagination-fl-item'; }
        if(!isset($options['css']['first-last-class-active'])) { $options['css']['first-last-class-active'] = 'pagination-fl-item-active'; }

        return $options;
    }

    public function toHTML(): string
    {
        if($this->maxPage < 2 && !$this->options['build-empty']) { return ''; }
        $html = '<div class="'.$this->options['css']['parent-class'].'">';

        if($this->options['first-last']['active'] && ($this->currentPage > 1 || !$this->options['first-last']['hidden']))
        {
            $html .= '<a href="'.$this->buildUrl(1).'" class="'.$this->options['css']['first-last-class'].($this->currentPage == 1 ? ' '.$this->options['css']['first-last-class-active'] : '').'">'.$this->options['first-last']['first-content'].'</a>';
        }

        if($this->options['previous-next']['active'] && ($this->currentPage > 1 || !$this->options['previous-next']['hidden']))
        {
            $html .= '<a href="'.$this->buildUrl(1).'" class="'.$this->options['css']['previous-next-class'].($this->currentPage == 1 ? ' '.$this->options['css']['previous-next-class-active'] : '').'">'.$this->options['previous-next']['previous-content'].'</a>';
        }

        for ($i = 1; ($this->maxPage > ($this->options['range']*2) && $i <= $this->options['range']) || ($this->maxPage <= ($this->options['range']*2) && $i <= $this->maxPage); $i++)
        {
            $html .= $this->buildButtonPage($i, $i == $this->currentPage);
        }
        if($this->maxPage > $this->options['range'])
        {
            if($this->currentPage >= ($this->options['range']*2))
            {
                $html .= $this->buildSeparatorPage();
            }
            for($i = $this->maxPage-($this->options['range']-1); $i < $this->currentPage-(($this->options['range']-1)/2); $i++)
            {
                $html .= $this->buildButtonPage($i, false);
            }
            for($i = $this->currentPage - (($this->options['range']-1)/2); $i <= $this->currentPage+(($this->options['range']-1)/2); $i++)
            {
                if($i > $this->options['range'] && $i <= $this->maxPage)
                {
                    $html .= $this->buildButtonPage($i, $i == $this->currentPage);
                }
            }
            if($this->maxPage-($this->options['range']-1) > $this->currentPage+((($this->options['range']-1)/2)+1))
            {
                $html .= $this->buildSeparatorPage();
            }
            for($i = $this->maxPage-($this->options['range']-1); $i <= $this->maxPage; $i++)
            {
                if($i > $this->currentPage+(($this->options['range']-1)/2))
                {
                    $html .= $this->buildButtonPage($i, $i == $this->currentPage);
                }
            }
        }

        if($this->options['previous-next']['active'] && ($this->currentPage < $this->maxPage || !$this->options['previous-next']['hidden']))
        {
            $html .= '<a href="'.$this->buildUrl($this->maxPage).'" class="'.$this->options['css']['previous-next-class'].($this->currentPage == $this->maxPage ? ' '.$this->options['css']['previous-next-class-active'] : '').'">'.$this->options['previous-next']['next-content'].'</a>';
        }

        if($this->options['first-last']['active'] && ($this->currentPage < $this->maxPage || !$this->options['first-last']['hidden']))
        {
            $html .= '<a href="'.$this->buildUrl($this->maxPage).'" class="'.$this->options['css']['first-last-class'].($this->currentPage == $this->maxPage ? ' '.$this->options['css']['first-last-class-active'] : '').'">'.$this->options['first-last']['last-content'].'</a>';
        }
        return $html.'</div>';
    }

    private function buildButtonPage($page, $selected): string
    {
        return '<a href="'.$this->buildUrl($page).'" class="'.$this->options['css']['child-class'].($selected ? ' '.$this->options['css']['child-class-active'] : '').'">'.$page.'</a>';
    }

    private function buildUrl(int $page): string
    {
        return str_replace($this->options['key'], $page, $this->options['url']);
    }

    private function buildSeparatorPage(): string
    {
        return '<span class="'.$this->options['css']['separator-class'].'">'.$this->options['css']['separator-content'].'</span>';
    }

    public function __toString(): string
    {
        return $this->toHTML();
    }
}
