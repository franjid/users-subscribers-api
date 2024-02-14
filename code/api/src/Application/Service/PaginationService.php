<?php

namespace Project\Application\Service;

class PaginationService
{
    public function getOffset(int $page, int $numResults): int
    {
        return ($page - 1) * $numResults;
    }

    public function getTotalPages(int $totalEntries, int $numResults): int
    {
        return ceil($totalEntries / $numResults);
    }
}
