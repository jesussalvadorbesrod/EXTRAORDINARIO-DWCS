<?php

require_once '../vendor/autoload.php';

use Clases\OperacionesUnidad06;

$op = new OperacionesUnidad06();
$resultado = $op->getPosicion('Portero');

var_dump($resultado);