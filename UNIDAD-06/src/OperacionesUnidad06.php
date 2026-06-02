<?php

namespace Clases;

class OperacionesUnidad06 {

    /**
     * Dada una posición de un jugador devuelve un
     * array con el nombre y apellidos de los jugadores
     * que coincidan en esa posición
     * 
     * @soap
     * @param string $posicion Posición del jugador 
     *               (tiene que coincidir con los que están 
     *                en la base de datos)
     * @return array Array con los nombres y apellidos de los jugadores
     *               de esa posición
     */
    public function getPosicion(string $posicion): array {
        $jugadores = new Jugadores();
        $lista = $jugadores->recuperarJugadores();
        $listaFiltrada = [];
        foreach ($lista as $j) {
            if ($j->posicion == $posicion) {
                $listaFiltrada[] = [  
                    'nombre' => $j->nombre,
                    'apellidos' => $j->apellidos
                ];
            }
        }
        return $listaFiltrada;
    }
}