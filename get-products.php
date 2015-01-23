<?php

header('Content-Type: application/json; charset=UTF-8');

$pdo = new PDO('sqlite:swissfood.sqlite');

$copyright = 'Swiss Food Composition Database (http://www.valeursnutritives.ch/)';

//$language = $_GET['language'];

$sort = isset($_GET['sort']) ? $_GET['sort'] : 'id';

$page = (int) $_GET['page'];

$sql = 'SELECT id, name_de, name_fr, name_it, name_en FROM product ORDER BY ' . $sort . ' LIMIT ' . ($page * 100) . ', 100';

$statement = $pdo->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));

$statement->execute();

$rows = $statement->fetchAll(PDO::FETCH_ASSOC);

$products = array();

foreach ($rows as $row)
	{
	$product = array
		(
		'id' => (int) $row['id'],

		'name' => array
			(
			'de' => $row['name_de'],
			'fr' => $row['name_fr'],
			'it' => $row['name_it'],
			'en' => $row['name_en']
			)
		);

	$products[] = $product;
	}

echo json_encode(array('copyright' => $copyright, 'sort' => $sort, 'products' => $products));

