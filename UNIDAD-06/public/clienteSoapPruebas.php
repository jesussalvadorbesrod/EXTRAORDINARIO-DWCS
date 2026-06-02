<?php

/**
 * Fichero: Cliente SOAP
 * 
 * Se obtienen los jugadores de una posición determinada 
 * y se listan
 */

$posicion = 'Delantero';

$cliente = new SoapClient('http://localhost/EXTRAORDINARIO-DWCS/UNIDAD-06/servidorSoap/servicio.wsdl');

$lista = $cliente->getPosicion($posicion);

if (count ($lista) > 0) {
    echo 'Jugadores con la posición ' . $posicion . PHP_EOL . PHP_EOL;

    foreach ($lista as $j) {
    echo $j['nombre'] . ' ' . $j['apellidos'] . PHP_EOL; 
    }
} else {
    echo 'No existen jugadores con la posición ' . $posicion;
}

