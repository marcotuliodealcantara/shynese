<?php
include("../vendor/autoload.php");
use Google\Cloud\Translate\V2\TranslateClient;
$translate = new TranslateClient([

    'key' => ""

]);

$w2t = $_GET['s'];

$result = $translate->translate($w2t, [
    'target' => 'zh-Hant'
]);

echo $result['text'];

// tag para Separate Triple Result PARA SER USADA NO SPLIT
echo "!str?";


// TRIPLE PART FROM HERE

// PINTYIN 
use Overtrue\Pinyin\Pinyin;
$pinyin = new Pinyin();
echo implode(" ", $pinyin->convert($result['text'], PINYIN_TONE));

echo "!str?";

// PT / EN
$result = $translate->translate($w2t, [
    'target' => 'en'
]);

echo ucfirst($result['text']) . " (en) - ";

// PT / EN
$result = $translate->translate($w2t, [
    'target' => 'pt'
]);

echo ucfirst($result['text']) . " (pt)";

?>