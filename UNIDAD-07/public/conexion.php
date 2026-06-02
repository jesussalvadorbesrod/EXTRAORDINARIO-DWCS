<?php
$host = "localhost";
$db = "examen2";
$user = "gestor";
$pass = "secreto";
$dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";
try {
    $conProyecto = new PDO($dsn, $user, $pass);
    $conProyecto->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $ex) {
    die("Error en la conexión: mensaje: " . $ex->getMessage());
}
function consultarProducto($id)
{
    global $conProyecto;
    $consulta = "select * from productos where id=:i";
    $stmt1 = $conProyecto->prepare($consulta);
    try {
        $stmt1->execute([':i' => $id]);
    } catch (PDOException $ex) {
        die("Error al recuperar Productos: " . $ex->getMessage());
    }
    //esta consulta solo devuelve una fila es innecesario el while para recorrerla
    $producto = $stmt1->fetch(PDO::FETCH_OBJ);
    $stmt1 = null;
    return $producto;

}
function cerrar(&$con){
    $con = null;
}
function cerrarTodo(&$con, &$st){
    $st = null;
    $con = null;
}

/**
 * Función que obtiene de la base de datos el nombre del empleado y 
 * el nombre y apellidos del cliente de las ventas de un producto y los 
 * devuelve en forma de array
 * 
 * @param string $id Identificador del producto que vamos a obtener las ventas
 * @return array Array con los datos del empleado y del cliente
 */
function obtenerVentas(string $id): array {
    global $conProyecto;
    $consulta = 'select e.usuario as empleado, c.nombre as cliente_nombre, c.apellido1 as cliente_apellido1, c.apellido2 as cliente_apellido2 from empleados as e JOIN ventas as v on e.id=v.id_empleado JOIN clientes as c on c.id=v.id_cliente where id_producto=:id';
    $stmt = $conProyecto->prepare($consulta);
    try {
        $stmt->execute([':id' => $id]);
    } catch(PDOException $ex) {
        die ('No se pudo recuperar las ventas. Error: ' . $ex->getMessage());
    }
    $ventas = [];
    while ($r=$stmt->fetch(PDO::FETCH_OBJ)) {
        $ventas[] = [
            'empleado' => $r->empleado,
            'cliente' => $r->cliente_nombre . ' ' . $r->cliente_apellido1 . ' ' . $r->cliente_apellido2
        ];
    }

    return $ventas;
}