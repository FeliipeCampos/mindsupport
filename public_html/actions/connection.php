<?php
header("Access-Control-Allow-Origin: https://area-de-testepag1.websiteseguro.com");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Credentials: true"); // Permite credenciais (cookies e sessões)

$servername = "deepsys_area.mysql.dbaas.com.br";
$username = "deepsys_area";
$password = "F3l!pe_";
$database = "deepsys_area";

// Criando a conexão
$conn = new mysqli($servername, $username, $password, $database);

// Checando a conexão
if ($conn->connect_error) {
    die(json_encode(array("success" => false, "message" => "Conexão falhou: " . $conn->connect_error)));
}
?>
