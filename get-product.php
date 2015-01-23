<?php

header('Content-Type: application/json; charset=UTF-8');

$pdo = new PDO('sqlite:swissfood.sqlite');

$sql = 'SELECT * FROM product WHERE id = :id';

$statement = $pdo->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));

$statement->execute(array(':id' => $_GET['id']));

$row = $statement->fetch();

function element($name)
	{
	global $row;

	$unit = $row["{$name}_unit"];
	$matrixUnit = $row["{$name}_matrix_unit"];
	$valueType = $row["{$name}_value_type"];

	return array
		(
		'value' => (float) $row[$name],
		'unit' => ($unit === '') ? null : $unit,
		'matrix_unit' => ($matrixUnit === '') ? null : $matrixUnit,
		'type' => ($valueType === '') ? null : $valueType
		);
	}

$product = array
	(
	'id' => (int) $row['id'],

	'name' => array
		(
		'de' => $row['name_de'],
		'fr' => $row['name_fr'],
		'it' => $row['name_it'],
		'en' => $row['name_en']
		),

	'protein' => element('protein'),
	'charbohydrate_total' => element('charbohydrate_total'),
	'charbohydrate_available' => element('charbohydrate_available'),
	'fat_total' => element('fat_total'),
	'alcohol' => element('alcohol'),
	'energy_kj' => element('energy_kj'),
	'energy_kcal' => element('energy_kcal'),
	'water' => element('water'),
	'fatty_acids_total_saturated' => element('fatty_acids_total_saturated'),
	'fatty_acids_total_mono_unsaturated' => element('fatty_acids_total_mono_unsaturated'),
	'fatty_acids_total_poly_unsaturated' => element('fatty_acids_total_poly_unsaturated'),
	'cholesterol' => element('cholesterol'),
	'starch_total' => element('starch_total'),
	'sugar_total' => element('sugar_total'),
	'dietary_fibre_total' => element('dietary_fibre_total'),
	'sodium' => element('sodium'),
	'potassium' => element('potassium'),
	'chlorid' => element('chlorid'),
	'calcium' => element('calcium'),
	'magnesium' => element('magnesium'),
	'phosphor' => element('phosphor'),
	'iron_total' => element('iron_total'),
	'zinc' => element('zinc'),
	'iodide' => element('iodide'),
	'a' => element('a'),
	'all_trans_retinol_equivalents' => element('all_trans_retinol_equivalents'),
	'beta_carotene_equivalents' => element('beta_carotene_equivalents'),
	'beta_carotene' => element('beta_carotene'),
	'b1' => element('b1'),
	'b2' => element('b2'),
	'b6' => element('b6'),
	'b12' => element('b12'),
	'c' => element('c'),
	'd' => element('d'),
	'e' => element('e'),
	'niacine' => element('niacine'),
	'folate' => element('folate'),
	'pantothenic_acid' => element('pantothenic_acid'),

	'record_has_changed' => $row['record_has_changed']
	);

echo json_encode($product);

