<?php

//conexão com banco de dados

//$sql = new mysqli('localhost', 'root', '', 'tcc');
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
$test = file_get_contents('php://input');
$test1 = json_decode($test);

//pegando nome:

//$test1->nome;

?>