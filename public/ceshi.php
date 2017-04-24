<?php
//取得指定位址的內容，并储存至 $text   
$text=file_get_contents('http://b.tiayo.com/Home/article?aid=122'); 
$text = preg_replace('/\s*/', '', $text);
$text = str_replace(array("　"), "", $text);
$start = '<div class="neirongkaishi">';
$start = preg_replace('/\s*/', '', $start);
$start_num = strpos($text, $start)+strlen($start);
$end = '</div><p class="newsediter">';
$end = preg_replace('/\s*/', '', $end);
$end_num = strpos($text, $end);
$jiequ = $end_num-$start_num;
// echo $end_num;
echo substr($text,$start_num,$jiequ);
?>