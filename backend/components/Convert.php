<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace backend\components;

use Yii;
use yii\base\Component;
use yii\web\Application;
use yii\base\InvalidConfigException;

class Convert extends Component
{

    public function string($str)
    {
        $str = trim($str);
        $strFind = array(
            '- ',
            ' ',
            'đ', 'Đ',
            'á', 'à', 'ạ', 'ả', 'ã', 'Á', 'À', 'Ạ', 'Ả', 'Ã', 'ă', 'ắ', 'ằ', 'ặ', 'ẳ', 'ẵ', 'Ă', 'Ắ', 'Ằ', 'Ặ', 'Ẳ', 'Ẵ', 'â', 'ấ', 'ầ', 'ậ', 'ẩ', 'ẫ', 'Â', 'Ấ', 'Ầ', 'Ậ', 'Ẩ', 'Ẫ',
            'ó', 'ò', 'ọ', 'ỏ', 'õ', 'Ó', 'Ò', 'Ọ', 'Ỏ', 'Õ', 'ô', 'ố', 'ồ', 'ộ', 'ổ', 'ỗ', 'Ô', 'Ố', 'Ồ', 'Ộ', 'Ổ', 'Ỗ', 'ơ', 'ớ', 'ờ', 'ợ', 'ở', 'ỡ', 'Ơ', 'Ớ', 'Ờ', 'Ợ', 'Ở', 'Ỡ',
            'é', 'è', 'ẹ', 'ẻ', 'ẽ', 'É', 'È', 'Ẹ', 'Ẻ', 'Ẽ', 'ê', 'ế', 'ề', 'ệ', 'ể', 'ễ', 'Ê', 'Ế', 'Ề', 'Ệ', 'Ể', 'Ễ',
            'ú', 'ù', 'ụ', 'ủ', 'ũ', 'Ú', 'Ù', 'Ụ', 'Ủ', 'Ũ', 'ư', 'ứ', 'ừ', 'ự', 'ử', 'ữ', 'Ư', 'Ứ', 'Ừ', 'Ự', 'Ử', 'Ữ',
            'í', 'ì', 'ị', 'ỉ', 'ĩ', 'Í', 'Ì', 'Ị', 'Ỉ', 'Ĩ',
            'ý', 'ỳ', 'ỵ', 'ỷ', 'ỹ', 'Ý', 'Ỳ', 'Ỵ', 'Ỷ', 'Ỹ'
        );
        $strReplace = array(
            '',
            '-',
            'd', 'd',
            'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a',
            'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o',
            'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e',
            'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u',
            'i', 'i', 'i', 'i', 'i', 'i', 'i', 'i', 'i', 'i',
            'y', 'y', 'y', 'y', 'y', 'y', 'y', 'y', 'y', 'y'
        );

        return strtolower(preg_replace('/[^a-z0-9\-]+/i', '', str_replace($strFind, $strReplace, $str)));
    }

    public function unsigned($str)
    {
        $str = trim($str);
        $strFind = array(
            'đ', 'Đ',
            'á', 'à', 'ạ', 'ả', 'ã', 'Á', 'À', 'Ạ', 'Ả', 'Ã', 'ă', 'ắ', 'ằ', 'ặ', 'ẳ', 'ẵ', 'Ă', 'Ắ', 'Ằ', 'Ặ', 'Ẳ', 'Ẵ', 'â', 'ấ', 'ầ', 'ậ', 'ẩ', 'ẫ', 'Â', 'Ấ', 'Ầ', 'Ậ', 'Ẩ', 'Ẫ',
            'ó', 'ò', 'ọ', 'ỏ', 'õ', 'Ó', 'Ò', 'Ọ', 'Ỏ', 'Õ', 'ô', 'ố', 'ồ', 'ộ', 'ổ', 'ỗ', 'Ô', 'Ố', 'Ồ', 'Ộ', 'Ổ', 'Ỗ', 'ơ', 'ớ', 'ờ', 'ợ', 'ở', 'ỡ', 'Ơ', 'Ớ', 'Ờ', 'Ợ', 'Ở', 'Ỡ',
            'é', 'è', 'ẹ', 'ẻ', 'ẽ', 'É', 'È', 'Ẹ', 'Ẻ', 'Ẽ', 'ê', 'ế', 'ề', 'ệ', 'ể', 'ễ', 'Ê', 'Ế', 'Ề', 'Ệ', 'Ể', 'Ễ',
            'ú', 'ù', 'ụ', 'ủ', 'ũ', 'Ú', 'Ù', 'Ụ', 'Ủ', 'Ũ', 'ư', 'ứ', 'ừ', 'ự', 'ử', 'ữ', 'Ư', 'Ứ', 'Ừ', 'Ự', 'Ử', 'Ữ',
            'í', 'ì', 'ị', 'ỉ', 'ĩ', 'Í', 'Ì', 'Ị', 'Ỉ', 'Ĩ',
            'ý', 'ỳ', 'ỵ', 'ỷ', 'ỹ', 'Ý', 'Ỳ', 'Ỵ', 'Ỷ', 'Ỹ'
        );
        $strReplace = array(
            'd', 'd',
            'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a',
            'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o',
            'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e',
            'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u',
            'i', 'i', 'i', 'i', 'i', 'i', 'i', 'i', 'i', 'i',
            'y', 'y', 'y', 'y', 'y', 'y', 'y', 'y', 'y', 'y'
        );

        return strtolower(str_replace($strFind, $strReplace, $str));
    }

    public function redirect($str)
    {
        $str = str_replace("/", "%2F", $str);
        $str = str_replace(":", "%3A", $str);
        return $str;
    }

    public function url($str)
    {
        $str = str_replace("%2F", "/", $str);
        $str = str_replace("%3A", ":", $str);
        return $str;
    }

    public static function time($date)
    {
        $time = date('Y-m-d H:i:s', $date);
        $ago = strtotime(date('Y-m-d H:i:s', time())) - strtotime($time);
        if ($ago >= 86400)
        {
            $diff = floor($ago / 86400) . ' ngày';
        }
        elseif ($ago >= 3600)
        {
            $diff = floor($ago / 3600) . ' giờ';
        }
        elseif ($ago >= 60)
        {
            $diff = floor($ago / 60) . ' phút';
        }
        else
        {
            $diff = $ago . ' giây';
        }
        return $diff;
    }

    public function get_date($time)
    {
        $str_search = ["Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"];
        $str_replace = ["Thứ hai", "Thứ ba", "Thứ tư", "Thứ năm", "Thứ sáu", "Thứ bảy", "Chủ nhật"];
        $timenow = gmdate("D", $time + 7 * 3600);
        $timenow = str_replace($str_search, $str_replace, $timenow);
        return $timenow . ', ngày ' . date('d', $time) . ' tháng ' . date('m', $time) . ' năm ' . date('Y', $time);
    }

    public function date($date)
    {
        $array = explode('/', $date);
        $time = strtotime(date_format(new \DateTime($array[2] . '-' . $array[1] . '-' . $array[0]), 'Y-m-d 24:00:00'));
        return $time;
    }

    public function date2($date)
    {
        $array = explode('/', $date);
        $time = strtotime(date_format(new \DateTime($array[2] . '-' . $array[1] . '-' . $array[0]), 'Y-m-d 00:00:00'));
        return $time;
    }

    public function excerpt($str, $length, $chr = '...')
    {
        $str = strip_tags($str, '');
        if (strlen($str) < $length)
            return $str;
        else
        {
            $str = strip_tags($str);
            $str = substr($str, 0, $length);
            $end = strrpos($str, ' ');
            $str = substr($str, 0, $end) . ' ' . $chr;
            return $str;
        }
    }

    public function plaintext($string, $keep_image = false, $keep_link = false)
    {
        // Get image tags
        if ($keep_image)
        {
            if (preg_match_all("/\<img[^\>]*src=\"([^\"]*)\"[^\>]*\>/is", $string, $match))
            {
                foreach ($match[0] as $key => $_m)
                {
                    $textimg = '';
                    if (strpos($match[1][$key], 'data:image/png;base64') === false)
                    {
                        $textimg = " " . $match[1][$key];
                    }
                    if (preg_match_all("/\<img[^\>]*alt=\"([^\"]+)\"[^\>]*\>/is", $_m, $m_alt))
                    {
                        $textimg .= " " . $m_alt[1][0];
                    }
                    $string = str_replace($_m, $textimg, $string);
                }
            }
        }

        // Get link tags
        if ($keep_link)
        {
            if (preg_match_all("/\<a[^\>]*href=\"([^\"]+)\"[^\>]*\>(.*)\<\/a\>/isU", $string, $match))
            {
                foreach ($match[0] as $key => $_m)
                {
                    $string = str_replace($_m, $match[1][$key] . " " . $match[2][$key], $string);
                }
            }
        }

        $string = str_replace(' ', ' ', strip_tags($string));
        return preg_replace('/[ ]+/', ' ', $string);
    }

}
