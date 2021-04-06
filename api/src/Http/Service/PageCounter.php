<?php


namespace App\Http\Service;

use App\PhoneList\Command\GetAllNumberCount\Handler;

class PageCounter
{
    private Handler $handler;

    public function __construct(Handler $handler)
    {
        $this->handler = $handler;
    }

    public function pageCount($rows, $queryData): int
    {
        if (
            !$queryData['phonenumber'] &&
            !$queryData['organizationName'] &&
            !$queryData['fio']
        ) {
            return $this->handler->handle();
        }

        $rowCount = count($rows);

        if ($rowCount > 50) {
            $pagesCount = (int)ceil($rowCount / 50);
        }else{
            $pagesCount = 1;
        }

        return $pagesCount;
    }
}