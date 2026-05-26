<?php
$host = "localhost";
$user = "root";
$pass = ""; // En WAMP por defecto es vacio
$db = "tienda_delivery";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
?>
