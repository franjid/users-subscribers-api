<?php

namespace Project\Application\Dto;

class ResponseCollection
{
    final public const FIELD_TOTAL = 'total';
    final public const FIELD_PAGE = 'page';
    final public const FIELD_PAGES = 'pages';
    final public const FIELD_RESULTS = 'results';

    public function __construct(
        private readonly int $total,
        private readonly int $page,
        private readonly int $pages,
        private readonly array $results
    ) {
    }

    public function getTotal(): int
    {
        return $this->total;
    }

    public function getPage(): int
    {
        return $this->page;
    }

    public function getPages(): int
    {
        return $this->pages;
    }

    public function getResults(): array
    {
        return $this->results;
    }

    public function toArray(): array
    {
        return [
            self::FIELD_TOTAL => $this->getTotal(),
            self::FIELD_PAGE => $this->getPage(),
            self::FIELD_PAGES => $this->getPages(),
            self::FIELD_RESULTS => $this->getResults(),
        ];
    }
}
