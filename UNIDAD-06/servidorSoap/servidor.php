<?php

/**
 * Fichero: servidor.php
 * 
 * Servidor SOAP que permite a un cliente
 * consultar los métodos de la clase OperacionesUnidad06
 */

require '../vendor/autoload.php';

try {
    $servidor = new SoapServer('servicio.wsdl');
    $servidor->setClass(Clases\OperacionesUnidad06::class);
    $servidor->handle();
} catch (SoapFault $sfe) {
    echo 'No se pudo crear el servidor SOAP. Error: ' . $sfe->getMessage();
}