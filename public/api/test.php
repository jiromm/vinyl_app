<?php

include("WideImage/WideImage.php");

$imgSrc = 'testimages/2014-04-26 11.32.39.jpg';
//$imgSrc = 'testimages/603692_520762668052832_7617635364464980469_n.jpg';

list($curWidth, $curHeight) = getimagesize($imgSrc);

// 5/3

$image = WideImage::load($imgSrc);

if ($curWidth / $curHeight > 5 / 3) {
	$image = $image->resize(500, 300, 'inside', 'down');
} else {
	$image = $image->resize(500, 300, 'outside', 'down');
}



$image->crop('center', 'center', 500, 300)->output('jpg', 90);
