<?php
session_start();
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $conn->real_escape_string($_POST['username']);
    $password = md5($_POST['password']); // Usamos MD5 por simplicidad según los datos de prueba

    $sql = "SELECT idTrabajador, nombre, puesto FROM trabajador WHERE username = '$username' AND password = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $_SESSION['user_id'] = $row['idTrabajador'];
        $_SESSION['nombre'] = $row['nombre'];
        $_SESSION['puesto'] = $row['puesto'];

        if ($row['puesto'] == 'Motorizado') {
            header("Location: rider.php");
        } else {
            header("Location: admin.php");
        }
    } else {
        header("Location: index.php?error=Usuario o contraseña incorrectos");
    }
}
?>
