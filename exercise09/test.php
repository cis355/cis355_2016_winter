<?php
echo "Hello\n";

$var1 = 1;
$var2 = 2;
$var3 = 3;

$arr1 = array(1, 2, 3);
$arr2 = array($var1, $var2, $arr1);
$arr3 = array($arr1, $arr2);

echo "<br />";
echo "<pre><code>";
print_r ($arr1);
echo "</code></pre>";

$arr1['zippydee'] = 150;
$arr3 = array($arr1, $arr2);
echo "<pre><code>";
foreach($arr1 as $key=>$value){
    echo $key . "<br />";
}

echo "<br />";
echo "<pre><code>";
print_r ($arr2);
echo "</code></pre>";

echo "<br />";
echo "<pre><code>";
print_r ($arr3);
echo "</code></pre>";

echo "<pre><code>";
print_r ($_GET);
echo "</code></pre>";

$n=0;
foreach($_GET as $key=>$value) {
    $line = "Key" . $n . " is " . $key . " Value" . $n ;
    $line .= " is " . $value . " ccc <br />";
	echo $line;
	$n += 1;
}














?>
