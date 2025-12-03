<?php
header("Content-Type: application/json");
include "conexion.php";

$data = json_decode(file_get_contents("php://input"), true);

$username = $data["username"] ?? "";
$password = $data["password"] ?? "";

// Consulta usuario
$sql = $conn->prepare("SELECT password FROM usuarios WHERE username = ?");
$sql->bind_param("s", $username);
$sql->execute();
$result = $sql->get_result();

if ($result->num_rows === 0) {
    echo json_encode(["success" => false]);
    exit;
}

$row = $result->fetch_assoc();

// Comparar contraseña
if ($password === $row["password"]) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false]);
}