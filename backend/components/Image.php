<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace frontend\components;

use Yii;
use yii\base\Component;
use yii\web\Application;
use yii\base\InvalidConfigException;

class Convert extends Component {

    public function string($str) {
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

    public function redirect($str) {
        $str = str_replace("/", "%2F", $str);
        $str = str_replace(":", "%3A", $str);
        return $str;
    }

    public function url($str) {
        $str = str_replace("%2F", "/", $str);
        $str = str_replace("%3A", ":", $str);
        return $str;
    }

}
