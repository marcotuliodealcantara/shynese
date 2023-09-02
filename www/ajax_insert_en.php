<?php
include("../vendor/autoload.php");
use Google\Cloud\Translate\V2\TranslateClient;
$translate = new TranslateClient([

    'key' => "AIzaSyDlClu_-KwftXmgG4DYlvLXEHoNAEIJZRo"

]);

$w2t = $_GET['s'];

$result = $translate->translate($w2t, [
    'target' => 'en'
]);

echo $result['text'];

//use Overtrue\Pinyin\Pinyin;
//$pinyin = new Pinyin(); // 默认
//echo implode(" ", $pinyin->convert($result['text']));
?>