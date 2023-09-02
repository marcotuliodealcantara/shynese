<?php
include("../vendor/autoload.php");
use Google\Cloud\Translate\V2\TranslateClient;
$translate = new TranslateClient([

    'key' => "AIzaSyDlClu_-KwftXmgG4DYlvLXEHoNAEIJZRo"

    

]);

//'key' => "AIzaSyBFu2S4QDQ2VENsSzTGO5W_-KGMXSI-Ies"

$w2t = $_GET['s'];

$result = $translate->translate($w2t, [
    'target' => 'zh-Hant'
]);

//echo $result['text'];

use Overtrue\Pinyin\Pinyin;
$pinyin = new Pinyin();
echo implode(" ", $pinyin->convert($result['text'], PINYIN_TONE));
?>