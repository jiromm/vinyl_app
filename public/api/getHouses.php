<?php

header('Content-Type: application/json');

$result = [];

for ($i = 1; $i < 10; $i++) {
	$result[$i] = [
		'icon' => "http://lorempixel.com/100/100/sports/$i",
		'original' => "http://lorempixel.com/500/300/sports/$i",
	];
}

echo json_encode($result);
