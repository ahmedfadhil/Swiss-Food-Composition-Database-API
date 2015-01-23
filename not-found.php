<?php

header('Content-Type: application/json; charset=UTF-8', true, 404);

echo json_encode(array('error' => array('code' => 404, 'message' => 'Not Found')));

