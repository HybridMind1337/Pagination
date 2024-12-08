<?php
namespace HybridMind;

class Pagination
{
    private array $options = [
        'showFirstLast' => true,
        'dots' => true,
        'useIcons' => true,
        'tooltip' => true,
        'useAjax' => false,
        'containerId' => 'pagination-container',
    ];

    private array $labels = [
        'first' => '<<',
        'last' => '>>',
        'previous' => '<',
        'next' => '>',
    ];


    public function __construct(array $options = [])
    {
        $this->options = array_merge($this->options, $options);
        $this->setDefaultLabels();
    }

    private function setDefaultLabels(): void
    {
        if ($this->options['useIcons']) {
            $this->labels = [
                'first' => '<i class="fas fa-angle-double-left"></i>',
                'last' => '<i class="fas fa-angle-double-right"></i>',
                'previous' => '<i class="fas fa-angle-left"></i>',
                'next' => '<i class="fas fa-angle-right"></i>',
            ];
        }
    }

    public function setLabels(array $labels): void
    {
        $this->labels = array_merge($this->labels, $labels);
    }

    public function renderPagination(int $currentPage, int $totalPages, string $link, array $queryParams = []): string
    {
        if ($totalPages <= 1) {
            return '';
        }

        $isAjax = $this->options['useAjax'];
        $pagination = '<nav aria-label="Page navigation">';
        $pagination .= '<ul class="pagination justify-content-center">';

        $start = max(1, $currentPage - 2);
        $end = min($totalPages, $currentPage + 2);

        if ($this->options['showFirstLast'] && $currentPage > 2) {
            $pagination .= $this->createPageLink(1, $link, $this->labels['first'], 'page-item', $queryParams, $isAjax);
            if ($this->options['dots'] && $start > 2) {
                $pagination .= '<li class="page-item disabled"><span class="page-link">...</span></li>';
            }
        }

        if ($currentPage > 1) {
            $pagination .= $this->createPageLink($currentPage - 1, $link, $this->labels['previous'], 'page-item', $queryParams, $isAjax);
        }

        for ($i = $start; $i <= $end; $i++) {
            if ($i == $currentPage) {
                $pagination .= '<li class="page-item active"><span class="page-link">' . $i . '</span></li>';
            } else {
                $pagination .= $this->createPageLink($i, $link, (string)$i, 'page-item', $queryParams, $isAjax);
            }
        }

        if ($currentPage < $totalPages) {
            $pagination .= $this->createPageLink($currentPage + 1, $link, $this->labels['next'], 'page-item', $queryParams, $isAjax);
        }

        if ($this->options['showFirstLast'] && $end < $totalPages - 1) {
            if ($this->options['dots']) {
                $pagination .= '<li class="page-item disabled"><span class="page-link">...</span></li>';
            }
            $pagination .= $this->createPageLink($totalPages, $link, $this->labels['last'], 'page-item', $queryParams, $isAjax);
        }

        $pagination .= '</ul>';
        $pagination .= '</nav>';

        return $pagination;
    }

    private function createPageLink(int $page, string $link, string $label, string $class, array $queryParams, bool $isAjax): string
    {
        $queryString = http_build_query(array_merge(['page' => $page], $queryParams));

        $href = $isAjax ? 'javascript:void(0);' : $link . '?' . $queryString;
        $onclick = $isAjax ? "onclick=\"ajaxPagination('$link?$queryString', '{$this->options['containerId']}')\"" : '';

        $tooltip = $this->options['tooltip'] ? 'title="Страница ' . $page . '"' : '';
        return '<li class="' . $class . '"><a class="page-link" href="' . $href . '" ' . $tooltip . ' ' . $onclick . '>' . $label . '</a></li>';
    }
}
