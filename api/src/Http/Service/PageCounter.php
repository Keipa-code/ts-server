<?php

namespace App\Http\Service;

use App\PhoneList\Command\GetPageCount\Handler;
use App\PhoneList\Command\GetPageCount\Command;

class PageCounter
{
    private Handler $handler;

    public function __construct(Handler $handler)
    {
        $this->handler = $handler;
    }

    public function pageCountPrivate(): int
    {
        $rowCount = $this->handler->handlePrivate();
        return $this->rowToCount($rowCount);
    }

    public function pageCountJuridical(): int
    {
        $rowCount = $this->handler->handleJuridical();
        return $this->rowToCount($rowCount);
    }

    public function pageCountByFIO($fio): int
    {
        $rowCount = $this->handler->handleByFIO($fio);
        return $this->rowToCount($rowCount);
    }

    public function pageCountByOrgName($orgName): int
    {
        $rowCount = $this->handler->handleByOrgName($orgName);
        return $this->rowToCount($rowCount);
    }

    private function rowToCount($rowCount): int
    {
        if ($rowCount > 50) {
            $pagesCount = (int)ceil($rowCount / 50);
        } else {
            $pagesCount = 1;
        }

        return $pagesCount;
    }
}
