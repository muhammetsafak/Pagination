<?php
/**
 * Pagination.php
 *
 * This file is part of PHPPagination.
 *
 * @author     Muhammet ŞAFAK <info@muhammetsafak.com.tr>
 * @copyright  Copyright © 2022 PHPPagination
 * @license    https://github.com/muhammetsafak/PHPPagination/blob/main/LICENSE  MIT
 * @version    0.1
 * @link       https://www.muhammetsafak.com.tr
 */

declare(strict_types=1);

namespace MuhammetSafak\Pagination;

class Pagination
{

    protected int $page = 1;
    protected int $perPageLimit = 10;
    protected int $totalPage = 0;
    protected int $totalRow = 0;
    protected int $howDisplayedPage = 8;
    protected string $linkTemplate = '';

    /**
     * @param int $page Geçerli sayfa
     * @param int $totalRow Sayfalamaya tabi olan toplam satır sayısı
     * @param int $perPageLimit Her sayfada gösterilen satır sayısı
     * @param string $linkTemplate Sayfa URL'inin şablonu
     */
    public function __construct(int $page, int $totalRow, int $perPageLimit = 10, string $linkTemplate = '?page={page}')
    {
        $this->page = $page;
        $this->totalRow = $totalRow;
        $this->perPageLimit = $perPageLimit;

        $totalPage = \ceil(($this->totalRow / $this->perPageLimit));
        if(\is_int($totalPage)){
            $this->totalPage = $totalPage;
        }
        $this->linkTemplate = $linkTemplate;
    }

    /**
     * Geçerli sayfayı döndürür.
     *
     * @return int
     */
    public function getPage(): int
    {
        return $this->page;
    }

    /**
     * Geçerli sayfa başına gösterilen limiti döndürür.
     *
     * @return int
     */
    public function getLimit(): int
    {
        return $this->perPageLimit;
    }

    /**
     * Geçerli sayfa ile sayfa başına limiti çarparak döndürür.
     *
     * @return int
     */
    public function getOffset(): int
    {
        return $this->page * $this->perPageLimit;
    }

    /**
     * Sayfaların URL şablonunu tanımlar.
     *
     * @param string $template
     * @return $this
     */
    public function linkTemplate(string $template): self
    {
        $this->linkTemplate = $template;
        return $this;
    }

    /**
     * Sayfa başına gösterilen satır sayısını tanımlar.
     *
     * @param int $perPageLimit
     * @return $this
     */
    public function setPerPageLimit(int $perPageLimit = 10): self
    {
        $this->perPageLimit = $perPageLimit;
        return $this;
    }

    /**
     * Sayfalamaya dahil olan toplam satır sayısını tanımlar.
     *
     * @param int $totalRow
     * @return $this
     */
    public function setTotalRow(int $totalRow = 0): self
    {
        $this->totalRow = $totalRow;
        return $this;
    }

    /**
     * Sayfalamada gösterilecek sayfa sayısını tanımlar.
     *
     * @param int $howDisplayedPage Çift bir tam sayı. Bir tek sayı belirtilirse 1 arttırılır.
     * @return $this
     */
    public function setHowDisplayedPage(int $howDisplayedPage = 8): self
    {
        if($howDisplayedPage % 2 !== 0){
            $howDisplayedPage++;
        }
        $this->howDisplayedPage = $howDisplayedPage;
        return $this;
    }

    /**
     * Sayfalama için kullanılabilir bir dizi oluşturur ve döndürür.
     *
     * Döndürdüğü dizi aşağıdakine benzer.
     *
     * [
     *      [
     *          'url' => 'http://example.com/page/1',
     *          'page => 1,
     *          'active' => false
     *      ],
     *      [
     *          'url' => 'http://example.com/page/2',
     *          'page => 2,
     *          'active' => true
     *      ],
     *      [
     *          'url' => 'http://example.com/page/3',
     *          'page => 3,
     *          'active' => false
     *      ],
     * ]
     *
     * @return array
     */
    public function getPagination(): array
    {
        $pages = [];
        $beforeAfter = $this->howDisplayedPage / 2;

        if($beforeAfter > $this->page){
            $beforeLimit = ($beforeAfter - ($beforeAfter - $this->page));
        }else{
            $beforeLimit = $beforeAfter;
        }
        $afterLimit = $this->howDisplayedPage - $beforeLimit;

        for($i = ($this->page - 1); $i >= ($this->page - $beforeLimit); $i--){
            $pages[] = [
                'url'   => $this->linkTemplateProcess(['{page}' => $i]),
                'page'  => $i,
                'active' => false,
            ];
        }
        $pages = \array_reverse($pages, false);

        $pages[] = [
            'url'       => $this->linkTemplateProcess(['{page}' => $this->page]),
            'page'      => $this->page,
            'active'    => true,
        ];

        for($i = ($this->page + 1); $i <= ($this->page + $afterLimit); $i++){
            $pages[] = [
                'url'   => $this->linkTemplateProcess(['{page}' => $i]),
                'page' => $i,
                'active' => false
            ];
        }


        return $pages;
    }

    /**
     * Varsa sonraki sayfa için bir dizi döndürür. Yoksa null döndürür.
     *
     * Döndürdüğü dizi aşağıdakine benzer.
     *
     * ['url' => 'http://example.com/page/3', 'page' => 3]
     *
     * @return array|null
     */
    public function nextPage(): ?array
    {
        if($this->page < $this->totalPage && $this->totalPage > 1){
            $page = $this->page + 1;
            return [
                'url'   => $this->linkTemplateProcess(['{page}' => $page]),
                'page'  => $page,
            ];
        }
        return null;
    }

    /**
     * Varsa önceki sayfa için bir dizi döndürür. Yoksa null döndürür.
     *
     * Döndürdüğü dizi aşağıdakine benzer.
     *
     * ['url' => 'http://example.com/page/1', 'page' => 1]
     *
     * @return array|null
     */
    public function prevPage(): ?array
    {
        if($this->page > 1){
            $page = $this->page - 1;
            return [
                'url'   => $this->linkTemplateProcess(['{page}' => $page]),
                'page'  => $page
            ];
        }
        return null;
    }

    /**
     * Bootstrap 5 için uyumlu bir pagination oluşturur ve döndürür.
     *
     * @param array $configs
     * @return string
     */
    public function showPagination(array $configs = []): string
    {
        $html = '<nav>';
        $html .= '<ul class="pagination' . (isset($configs['ul_class']) ? " " . $configs['ul_class'] : null) . '">';
        if(!isset($configs['prev_display']) || $configs['prev_display'] !== FALSE){
            $prev = $this->prevPage();
            $prevLiClass = isset($configs['prev_li_class']) ? ' ' . $configs['prev_li_class'] : '';
            if($prev === null){
                $prevLiClass = ' disabled';
                $prevHref = '';
            }else{
                $prevHref = ' href="' . $prev['url'] . '"';
            }
            $html .= '<li class="page-item' . $prevLiClass . '"><a class="page-link"' . $prevHref . '>' . ($configs['prev_text'] ?? 'Previous') . '</a></li>';
        }
        foreach($this->getPagination() as $item){
            if($item['active'] === FALSE){
                $html .= '<li class="page-item' . (isset($configs['li_class']) ? " " . $configs['li_class'] : '') . '"><a class="page-link" href="' . $item['url'] .' ">' . $item['page'] . '</a></li>';
            }else{
                $html .= '<li class="page-item active' . (isset($configs['li_class']) ? " " . $configs['li_class'] : '') . '" aria-current="page"><a class="page-link" href="' . $item['url'] .' ">' . $item['page'] . '</a></li>';
            }
        }
        if(!isset($configs['next_display']) || $configs['next_display'] !== FALSE){
            $next = $this->nextPage();
            $nextLiClass = isset($configs['next_li_class']) ? ' ' . $configs['next_li_class'] : '';
            if($next === null){
                $nextLiClass = ' disabled';
                $nextHref = '';
            }else{
                $nextHref = ' href="' . $next['url'] . '"';
            }
            $html .= '<li class="page-item' . $nextLiClass . '"><a class="page-link"' . $nextHref . '>' . ($configs['next_text'] ?? 'Next') . '</a></li>';
        }
        $html .= '</ul>';
        $html .= '</nav>';
        return $html;
    }

    protected function linkTemplateProcess(array $params = []): string
    {
        $link = $this->linkTemplate;
        foreach($params as $var => $value){
            $link = \str_replace($var, (string)$value, $link);
        }
        return $link;
    }

}
