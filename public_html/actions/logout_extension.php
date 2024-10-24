<?php
header("Access-Control-Allow-Origin: https://area-de-testepag1.websiteseguro.com");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Credentials: true"); // Permite credenciais (cookies e sessões)
header('Content-Type: application/json; charset=utf-8');

session_start();
session_destroy();  // Destroi a sessão do usuário

echo json_encode(array("success" => true, "message" => "Sessão encerrada com sucesso"));
?>
