<?php

/**
 * Fichero: generadorWDSL
 * 
 * Genera el fichero wdsl necesario para el servidor SOAP
 * a partir de una clase
 */

require_once '../vendor/autoload.php';

use PHP2WSDL\PHPClass2WSDL;


$clase = 'Clases\OperacionesUnidad06';
$uri = 'http://localhost/EXTRAORDINARIO-DWCS/UNIDAD-06/servidorSoap/servidor.php';
$generador = new PHPClass2WSDL($clase, $uri);
$generador->generateWSDL(true);
$generador->save('../servidorSoap/servicio.wsdl');