<?php
header("Access-Control-Allow-Origin: https://area-de-testepag1.websiteseguro.com");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Credentials: true"); // Permite credenciais (cookies e sessões)
header('Content-Type: application/json; charset=utf-8');

session_start();

$response = array("success" => true, "loggedIn" => false);

if (isset($_SESSION['logado']) && $_SESSION['logado'] === true) {
    $response['loggedIn'] = true;
}

echo json_encode($response);
?>
