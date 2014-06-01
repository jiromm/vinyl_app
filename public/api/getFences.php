<?php

include("../../Config.php");

header('Content-Type: application/json');

//$categoryNames = ['', 'nightlife', 'animals', 'nature', 'food', 'city'];
//$result = [];
//
//for ($i = 1; $i < 6; $i++) {
//	$categoryName = $categoryNames[$i];
//	$category = [
//		'name' => 'Category ' . $i,
//		'fences' => [],
//	];
//
//	for ($j = 1; $j < 6; $j++) {
//		$width = mt_rand(220, 330);
//		$height = mt_rand(90, 200);
//
//		$category['fences'][$j] = [
//			'name' => "Some name $j",
//			'icon' => "http://lorempixel.com/60/40/$categoryName/$j",
//			'original' => "http://lorempixel.com/$width/$height/$categoryName/$j",
//			'width' => $width,
//			'height' => $height,
//		];
//	}
//
//	$result[$i] = $category;
//}

$result = [
	1 => [
		'name' => 'Perimeter 1',
		'fences' => [
			1 => [
				'name' => "Perimeter 1",
				'icon' => HOST . BASE_DIR . "archive/fences/perimeter/icon/perimeter1.png",
				'original' => HOST . BASE_DIR . "archive/fences/perimeter/perimeter1.png",
				'width' => 1096,
				'height' => 144,
			]
		],
	]
];

echo json_encode($result);
