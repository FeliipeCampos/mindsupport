<?php
header("Access-Control-Allow-Origin: https://area-de-testepag1.websiteseguro.com");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Credentials: true"); // Permite credenciais (cookies e sessões)
header('Content-Type: application/json; charset=utf-8');

session_start();

if (!isset($_SESSION['logado']) || !$_SESSION['logado']) {
    echo json_encode(array("success" => false, "message" => "Não autorizado"));
    exit;
}

$servername = "deepsys_area.mysql.dbaas.com.br";
$username = "deepsys_area";
$password = "F3l!pe_";
$database = "deepsys_area";

// Criando a conexão
$conn = new mysqli($servername, $username, $password, $database);
$conn->set_charset("utf8"); // Configurar o charset para UTF-8

// Checando a conexão
if ($conn->connect_error) {
    die(json_encode(array("success" => false, "message" => "Conexão falhou: " . $conn->connect_error)));
}

$id_usuario = $_SESSION['usuario_id'];
$id_form = isset($_POST['id_form']) ? intval($_POST['id_form']) : 0;
$respostas = isset($_POST['respostas']) ? $conn->real_escape_string($_POST['respostas']) : '';
$horario = date('Y-m-d H:i:s');

if ($id_form > 0 && !empty($respostas)) {
    $sql = "INSERT INTO respostas (respostas, horario, id_form, id_usuario) VALUES ('$respostas', '$horario', $id_form, $id_usuario)";
    if ($conn->query($sql) === TRUE) {
        echo json_encode(array("success" => true, "message" => "Respostas salvas com sucesso"));
    } else {
        echo json_encode(array("success" => false, "message" => "Erro ao salvar respostas: " . $conn->error));
    }
} else {
    echo json_encode(array("success" => false, "message" => "Dados inválidos"));
}

$conn->close();
?>
