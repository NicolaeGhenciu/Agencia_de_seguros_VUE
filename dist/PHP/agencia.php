<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET,POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Conecta a la base de datos  con usuario, contraseña y nombre de la BD
$servidor = "localhost";
$usuario = "nicolaeadrian";
$contrasenia = 'Cnp70$f3';
$nombreBaseDatos = "nicolaeadrian";
$conexionBD = new mysqli($servidor, $usuario, $contrasenia, $nombreBaseDatos);

// Consulta datos y recepciona una clave para consultar dichos datos con dicha clave
if (isset($_GET["login"])) {
    $email = mysqli_real_escape_string($conexionBD, $_GET["login"]);
    $sqlUsuarios = mysqli_query($conexionBD, "SELECT * FROM usuarios WHERE email='$email'");
    if (mysqli_num_rows($sqlUsuarios) > 0) {
        $usuarios = mysqli_fetch_all($sqlUsuarios, MYSQLI_ASSOC);
        echo json_encode($usuarios);
        exit();
    } else {
        echo json_encode(["success" => 0]);
    }
}

//borramos un cliente cambiandole el estado a baja

if (isset($_GET["borrar"])) {
    $sqlClientes = mysqli_query($conexionBD, "UPDATE clientes SET estado='baja' WHERE id=" . $_GET["borrar"]);
    if ($sqlClientes) {
        echo json_encode(["success" => 1]);
        exit();
    } else {
        echo json_encode(["success" => 0]);
    }
}

//borramos una poliza cambiandole el estado a anulada

if (isset($_GET["borrar_poliza"])) {
    $sqlClientes = mysqli_query($conexionBD, "UPDATE polizas SET estado='anulada' WHERE id=" . $_GET["borrar_poliza"]);
    if ($sqlClientes) {
        echo json_encode(["success" => 1]);
        exit();
    } else {
        echo json_encode(["success" => 0]);
    }
}

//Inserta un nuevo cliente

if (isset($_GET["insertar"])) {
    $data = json_decode(file_get_contents("php://input"));
    $nombre = $data->nombre;
    $apellidos = $data->apellidos;
    $telefono = $data->telefono;
    $localidad = $data->localidad;
    $cp = $data->cp;
    $provincia = $data->provincia;
    $provincia_nombre = $data->provincia_nombre;
    $entidad = $data->entidad;
    $estado = $data->estado;
    if (($nombre != "") && ($apellidos != "") && ($telefono != "") && ($localidad != "") && ($cp != "") && ($provincia != "") && ($provincia_nombre != "") && ($entidad != "") && ($estado != "")) {
        $sqlClientes = mysqli_query($conexionBD, "INSERT INTO clientes(nombre,apellidos,telefono,localidad,cp,provincia,provincia_nombre,entidad,estado) VALUES('$nombre','$apellidos','$telefono','$localidad','$cp','$provincia','$provincia_nombre','$entidad','$estado') ");
        echo json_encode(["success" => 1]);
    }
    exit();
}

//inserta una nueva poliza
if (isset($_GET["insertar_poliza"])) {
    $data = json_decode(file_get_contents("php://input"));
    $id_cliente = $data->id_cliente;
    $numero_poliza = $data->numero_poliza;
    $importe_recibo = $data->importe_recibo;
    $fecha = $data->fecha;
    $estado = $data->estado;
    $observaciones = $data->observaciones;
    if (($id_cliente != "") && ($numero_poliza != "") && ($importe_recibo != "") && ($fecha != "") && ($estado != "") && ($observaciones != "")) {
        $sqlPoliza = mysqli_query($conexionBD, "INSERT INTO polizas(id_cliente,numero_poliza,importe_recibo,fecha,estado,observaciones) VALUES('$id_cliente','$numero_poliza','$importe_recibo','$fecha','$estado','$observaciones') ");
        echo json_encode(["success" => 1]);
    }
    exit();
}

// Actualiza los datos de un cliente

if (isset($_GET["actualizar_cliente"])) {

    $data = json_decode(file_get_contents("php://input"));

    $id = $data->id;
    $nombre = $data->nombre;
    $apellidos = $data->apellidos;
    $telefono = $data->telefono;
    $localidad = $data->localidad;
    $cp = $data->cp;
    $provincia = $data->provincia;
    $provincia_nombre = $data->provincia_nombre;
    $entidad = $data->entidad;

    $sqlClientes = mysqli_query($conexionBD, "UPDATE clientes SET nombre='$nombre',apellidos='$apellidos',telefono='$telefono',localidad='$localidad',cp='$cp',provincia='$provincia',provincia_nombre='$provincia_nombre',entidad='$entidad' WHERE id='$id'");
    echo json_encode(["success" => 1]);
    exit();
}

//actualiza la poliza

if (isset($_GET["actualizar_poliza"])) {

    $data = json_decode(file_get_contents("php://input"));

    $id = $data->id;
    $id_cliente = $data->id_cliente;
    $numero_poliza = $data->numero_poliza;
    $importe_recibo = $data->importe_recibo;
    $fecha = $data->fecha;
    $estado = $data->estado;
    $observaciones = $data->observaciones;

    $sqlClientes = mysqli_query($conexionBD, "UPDATE polizas SET id_cliente='$id_cliente',numero_poliza='$numero_poliza',importe_recibo='$importe_recibo',fecha='$fecha',estado='$estado',observaciones='$observaciones' WHERE id='$id'");
    echo json_encode(["success" => 1]);
    exit();
}

// if (isset($_GET["actualizar_cliente"])) {

//     $sqlClientes = mysqli_query($conexionBD, "UPDATE clientes SET nombre='NICO', apellidos='ADRIAN' WHERE id='2'");
//     echo json_encode(["success" => 1]);
//     exit();
// }

// Consulta todos los registros de la tabla clientes

if (isset($_GET["consultar_clientes"])) {

    $sqlClientes = mysqli_query($conexionBD, "SELECT * FROM clientes WHERE estado = 'alta'");
    if (mysqli_num_rows($sqlClientes) > 0) {
        $clientes = mysqli_fetch_all($sqlClientes, MYSQLI_ASSOC);
        echo json_encode($clientes);
    } else {
        echo json_encode([["success" => 0]]);
    }
}

// consulta los datos de todas las polizas donde los clientes esten dados de alta

if (isset($_GET["consultar_polizas"])) {

    $sqlClientes = mysqli_query($conexionBD, "SELECT p.*
    FROM polizas p
    JOIN clientes c
    ON p.id_cliente = c.id
    WHERE c.estado = 'alta'");

    if (mysqli_num_rows($sqlClientes) > 0) {
        $clientes = mysqli_fetch_all($sqlClientes, MYSQLI_ASSOC);
        echo json_encode($clientes);
    } else {
        echo json_encode([["success" => 0]]);
    }
}

// Consulta todos los registros de la tabla provincias

if (isset($_GET["consultar_provincias"])) {

    $sqlProvincias = mysqli_query($conexionBD, "SELECT * FROM provincias");
    if (mysqli_num_rows($sqlProvincias) > 0) {
        $provincias = mysqli_fetch_all($sqlProvincias, MYSQLI_ASSOC);
        echo json_encode($provincias);
    } else {
        echo json_encode([["success" => 0]]);
    }
}

// Consulta todos los registros de la tabla municipios

if (isset($_GET['consultar_municipios'])) {
    $provinciaId = (int) $_GET['consultar_municipios'];

    $sqlMunicipios = "SELECT * FROM municipios WHERE provincia_id = ?";
    $consultaMunicipios = $conexionBD->prepare($sqlMunicipios);
    $consultaMunicipios->bind_param('i', $provinciaId);
    $consultaMunicipios->execute();

    $municipios = $consultaMunicipios->get_result()->fetch_all(MYSQLI_ASSOC);

    if (!empty($municipios)) {
        echo json_encode($municipios);
    } else {
        echo json_encode([["success" => 0]]);
    }
}

// if (isset($_GET["consultar_municipios"])) {

//     $sqlProvincias = mysqli_query($conexionBD, "SELECT * FROM municipios WHERE provincia_id = " . $_GET['consultar_municipios']);
//     if (mysqli_num_rows($sqlProvincias) > 0) {
//         $provincias = mysqli_fetch_all($sqlProvincias, MYSQLI_ASSOC);
//         echo json_encode($provincias);
//     } else {
//         echo json_encode([["success" => 0]]);
//     }
// }

// Consulta todos los registros de la tabla polizas

if (isset($_GET["consultar_poliza"])) {

    $sqlProvincias = mysqli_query($conexionBD, "SELECT * FROM polizas WHERE id_cliente = " . $_GET['consultar_poliza']);
    if (mysqli_num_rows($sqlProvincias) > 0) {
        $provincias = mysqli_fetch_all($sqlProvincias, MYSQLI_ASSOC);
        echo json_encode($provincias);
    } else {
        echo json_encode([["success" => 0]]);
    }
}

//consulta los datos de una poliza

if (isset($_GET["consultar_poliza_unica"])) {

    $sqlProvincias = mysqli_query($conexionBD, "SELECT * FROM polizas WHERE id = " . $_GET['consultar_poliza_unica']);
    if (mysqli_num_rows($sqlProvincias) > 0) {
        $provincias = mysqli_fetch_all($sqlProvincias, MYSQLI_ASSOC);
        echo json_encode($provincias);
    } else {
        echo json_encode([["success" => 0]]);
    }
}


// Consulta los registros de un cliente

if (isset($_GET["consultar_cliente"])) {

    $sqlClientes = mysqli_query($conexionBD, "SELECT * FROM clientes WHERE estado = 'alta' AND id = " . $_GET["consultar_cliente"]);
    if (mysqli_num_rows($sqlClientes) > 0) {
        $clientes = mysqli_fetch_all($sqlClientes, MYSQLI_ASSOC);
        echo json_encode($clientes);
    } else {
        echo json_encode([["success" => 0]]);
    }
}
