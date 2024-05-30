<?php

// ESTA ES NUESTRA API

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
header("Access-Control-Allow-Methods: GET, POST");
header("Content-Type: application/json; charset=UTF-8");

// Conectar a una base de datos

$servidor = "localhost";
$usuario = "root";
$contrasenia = "";
$nombreBaseDatos = "usuarios";

// Se establece la conexion con la base de datos
$conexionBD = new mysqli($servidor, $usuario, $contrasenia, $nombreBaseDatos);

// Verificar conexión
if ($conexionBD->connect_error) {
    die("Connection failed: " . $conexionBD->connect_error);
}

// Consultar registro en la BD
if (isset($_GET["consultar"])) {
    $sqlUsuarios = mysqli_query($conexionBD, "SELECT * FROM usuarios WHERE id = " . $_GET["consultar"]);
    if (mysqli_num_rows($sqlUsuarios) > 0) {
        $usuarios = mysqli_fetch_all($sqlUsuarios, MYSQLI_ASSOC);
        echo json_encode($usuarios);
    } else {
        echo json_encode(["success" => 0]);
    }
    exit();
}

// Eliminar un registro en la BD
if (isset($_GET["borrar"])) {
    $sqlUsuarios = mysqli_query($conexionBD, "DELETE FROM usuarios WHERE id = " . $_GET["borrar"]);
    if ($sqlUsuarios) {
        echo json_encode(["success" => 1]);
    } else {
        echo json_encode(["success" => 0]);
    }
    exit();
}

// Insertar registro en la BD
if (isset($_GET["insertar"])) {
    $data = json_decode(file_get_contents("php://input"), true);
    $nombre = $data['nombre'];
    $correo = $data['correo'];
    $cedula = $data['cedula'];
    $pais = $data['pais'];
    $edad = $data['edad'];

    if ($nombre != "" && $correo != "" && $cedula != "" && $pais != "" && $edad != null) {
        $sqlUsuarios = mysqli_query($conexionBD, "INSERT INTO usuarios (nombre, correo, cedula, edad, pais) VALUES('$nombre', '$correo', '$cedula', '$edad', '$pais')");
        if ($sqlUsuarios) {
            echo json_encode(["success" => 1]);
        } else {
            echo json_encode(["success" => 0, "error" => mysqli_error($conexionBD)]);
        }
    } else {
        echo json_encode(["success" => 0, "error" => "Datos incompletos"]);
    }
    exit();
}

// Actualizar registro en la BD
if (isset($_GET["actualizar"])) {
    $data = json_decode(file_get_contents("php://input"), true);
    $id = isset($data['id']) ? $data['id'] : $_GET["actualizar"];
    $nombre = $data['nombre'];
    $correo = $data['correo'];
    $cedula = $data['cedula'];
    $pais = $data['pais'];
    $edad = $data['edad'];

    if ($nombre != "" && $correo != "" && $cedula != "" && $pais != "" && $edad != null) {
        $sqlUsuarios = mysqli_query($conexionBD, "UPDATE usuarios SET nombre = '$nombre', edad = $edad, cedula = '$cedula', correo = '$correo', pais = '$pais' WHERE id = $id");
        if ($sqlUsuarios) {
            echo json_encode(["success" => 1]);
        } else {
            echo json_encode(["success" => 0, "error" => mysqli_error($conexionBD)]);
        }
    } else {
        echo json_encode(["success" => 0, "error" => "Datos incompletos"]);
    }
    exit();
}

// Listar usuarios
$sqlUsuarios = mysqli_query($conexionBD, "SELECT * FROM usuarios");
if (mysqli_num_rows($sqlUsuarios) > 0) {
    $usuarios = mysqli_fetch_all($sqlUsuarios, MYSQLI_ASSOC);
    echo json_encode($usuarios);
} else {
    echo json_encode(["success" => 0]);
}

?>
