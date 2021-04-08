<?php

declare(strict_types=1);


namespace App\Http\Service;


class Link
{
    public static function generateSortLink($data): array
    {
        $linkData ['phonenumber'] = $data['phonenumber'] ?? '';
        $linkData ['fio'] = $data['fio'] ?? '';
        $linkData ['organizationName'] = $data['organizationName'] ?? '';
        $linkData ['sort'] = 'number';
        $linkData ['order'] = (isset($data['sort']) && $data['sort'] == 'number' && $data['order'] == 'ASC') ? 'DESC' : 'ASC';
        $link['number'] = "?" . http_build_query($linkData);
        $linkData ['sort'] = 'name';
        $linkData ['order'] = (isset($data['sort']) && $data['sort'] == 'name' && $data['order'] == 'ASC') ? 'DESC' : 'ASC';
        $link['name'] = "?" . http_build_query($linkData);
        return $link;
    }

    public static function generateSortLinkM($data): array
    {
        $linkData ['phonenumber'] = $data['phonenumber'] ?? '';
        $linkData ['name'] = $data['name'] ?? '';
        $linkData ['sort'] = 'number';
        $linkData ['order'] = (isset($data['sort']) && $data['sort'] == 'number' && $data['order'] == 'ASC') ? 'DESC' : 'ASC';
        $link['number'] = "?" . http_build_query($linkData);
        $linkData ['sort'] = 'name';
        $linkData ['order'] = (isset($data['sort']) && $data['sort'] == 'name' && $data['order'] == 'ASC') ? 'DESC' : 'ASC';
        $link['name'] = "?" . http_build_query($linkData);
        return $link;
    }
}