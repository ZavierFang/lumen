<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/11/1
 * Time: 14:07
 */

namespace App\Models;


class Sitemap
{
    function create_xml()
    {
        $content = '<?xml version="1.0" encoding="UTF-8"?>
<urlset
    xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
    xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
    xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9
       http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">
';
        $data_array = array(
            array(
                'loc' => 'http://www.phpernote.com/',
                'priority' => '1.0',
                'lastmod' => '2012-06-03T04:20:32-08:00',
                'changefreq' => 'always'
            ),
            array(
                'loc' => 'http://www.phpernote.com/php/',
                'priority' => '0.5',
                'lastmod' => '2012-06-03T04:20:32-08:00',
                'changefreq' => 'daily'
            ),
            array(
                'loc' => 'http://www.phpernote.com/php/',
                'priority' => '0.5',
                'lastmod' => '2012-06-03T04:20:32-08:00',
                'changefreq' => 'daily'
            )
        );
        foreach ($data_array as $data) {
            $content .= $this->create_item($data);
        }
        $content .= '</urlset>';
        //return $content;
        $fp = fopen('sitemap.xml', 'w+');
        fwrite($fp, $content);
        fclose($fp);
    }

    function create_item($data)
    {
        $item = "<url>\n";
        $item .= "<loc>" . $data['loc'] . "</loc>\n";
        $item .= "<priority>" . $data['priority'] . "</priority>\n";
        $item .= "<lastmod>" . $data['lastmod'] . "</lastmod>\n";
        $item .= "<changefreq>" . $data['changefreq'] . "</changefreq>\n";
        $item .= "</url>\n";
        return $item;
    }

    /**
     * ָ��λ�ò����ַ���
     * @param $str  ԭ�ַ���
     * @param $i    ����λ��
     * @param $substr �����ַ���
     * @return string �������ַ���
     */
    function insertToStr($str, $i, $substr)
    {
        //ָ������λ��ǰ���ַ���
        $startstr = "";
        for ($j = 0; $j < $i; $j++) {
            $startstr .= $str[$j];
        }

        //ָ������λ�ú���ַ���
        $laststr = "";
        for ($j = $i; $j < strlen($str); $j++) {
            $laststr .= $str[$j];
        }

        //������λ��ǰ��Ҫ����ģ�����λ�ú������ַ���ƴ������
        $str = $startstr . $substr . $laststr;

        //���ؽ��
        return $str;
    }
}