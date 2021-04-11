<?php

declare(strict_types=1);

namespace App\Http\Service;

class Link
{
    public static function generateSortLink($data): array
    {
        if (isset($data['phonenumber'])) {
            $linkData ['phonenumber'] = $data['phonenumber'];
        }
        if (isset($data['fio'])) {
            $linkData ['fio'] = $data['fio'];
        }
        if (isset($data['organizationName'])) {
            $linkData ['organizationName'] = $data['organizationName'];
        }
        if (isset($data['name'])) {
            $linkData ['name'] = $data['name'];
        }
        $linkData ['sort'] = 'number';
        $linkData ['order'] = (isset($data['sort']) && $data['sort'] == 'number' && $data['order'] == 'ASC') ? 'DESC' : 'ASC';
        $link['number'] = "?" . http_build_query($linkData);
        $linkData ['sort'] = 'name';
        $linkData ['order'] = (isset($data['sort']) && $data['sort'] == 'name' && $data['order'] == 'ASC') ? 'DESC' : 'ASC';
        $link['name'] = "?" . http_build_query($linkData);
        return $link;
    }
}
