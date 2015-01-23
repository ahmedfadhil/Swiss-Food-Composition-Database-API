<?php

error_reporting(E_ALL);
ini_set('display_errors', 'stderr');


//sleep(3);


header('Content-Type: application/json; charset=UTF-8');

$pdo = new PDO('sqlite:swissfood.sqlite');

$source = 'Swiss Food Composition Database (http://www.valeursnutritives.ch/)';

//$language = $_GET['language'];

//$sort = isset($_GET['sort']) ? $_GET['sort'] : 'id';

//$page = (int) $_GET['page'];

// TODO Erreur si pas de nom à chercher
// TODO URL decode
// TODO PHP filter var
$q = isset($_GET['q']) ? $_GET['q'] : 'error';

//echo urldecode($q);
//exit();

// Pourquoi cette solution a étée downvotée sur SO ???
$q = $pdo->quote("%{$q}%");

//echo $q;
//exit();

// Pas dispo!!!
//echo sqlite_escape_string($q);

$sql = 'SELECT id, name_de, name_fr, name_it, name_en FROM product WHERE name_fr LIKE ' . $q . ' ORDER BY name_fr LIMIT 100';

//echo $sql;
//exit();

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

echo json_encode(array('source' => $source, 'products' => $products));

