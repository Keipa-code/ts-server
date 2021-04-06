<?php

declare(strict_types=1);


namespace App\Http\Service;


class Link
{
    public static function generateSort($data): array
    {
        $linkData ['phonenumber'] = $data['phonenumber'] ?? '';
        $linkData ['fio'] = $data['fio'] ?? '';
        $linkData ['organizationName'] = $data['organizationName'] ?? '';
        $linkData ['sort'] = 'number';
        $linkData ['order'] = ($data['sort'] == 'number' && $data['order'] == 'ASC') ? 'DESC' : 'ASC';
        $link['number'] = "?" . http_build_query($linkData);
        $linkData ['sort'] = 'name';
        $linkData ['order'] = ($data['sort'] == 'name' && $data['order'] == 'ASC') ? 'DESC' : 'ASC';
        $link['name'] = "?" . http_build_query($linkData);
        return $link;
    }

    public static function pageCount($rows): int
    {
        $rowCount = count($rows);

        //$rowCount = (int)implode("",$rowCount);
        if ($rowCount > 50) {
            $pagesCount = (int)ceil($rowCount / 50);
        }else{
            $pagesCount = 1;
        }

        return $pagesCount;
    }
}