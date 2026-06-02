<?php

/**
 * Fichero: infoVentas.php
 * 
 * Este código permite mostrar una caja de texto
 * con la información de ventas del producto sin necesidad
 * de recargar la página usando la librería Jaxon 
 */

require_once '../vendor/autoload.php';


use Jaxon\Jaxon;
use function Jaxon\jaxon;

/**
 * Cuando se pulsa un producto se muestra sus ventas en
 * una caja de texto
 * 
 * Antes de mostrar las ventas del producto se oculta el resto
 *  
 * @param int $id Identificador del producto
 * @param int $numeroProductos Número de productos (Necesario para ocultar 
 *                             las ventas del resto de productos)
 */
function mostrarVentas(int $id, int $numeroProductos): void {
    require_once 'conexion.php';

    $respuesta = jaxon()->newResponse();

    for ($i=1;$i<=$numeroProductos;$i++) {
        $respuesta->style('ventas-' . $i, 'display', 'none');
    }

    $respuesta->style('ventas-' . $id, 'display', 'block');
}

$jaxon = jaxon();

$jaxon->register(JAXON::CALLABLE_FUNCTION, 'mostrarVentas');

if ($jaxon->canProcessRequest()) { $jaxon->processRequest(); }

