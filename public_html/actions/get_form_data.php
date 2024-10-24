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

$id = isset($_GET['id']) ? intval($_GET['id']) : 1; // ID dinâmico ou padrão para 1

// Verificar a quantidade total de formulários
$totalFormsResult = $conn->query("SELECT COUNT(*) as total FROM formulario_texto");
$totalFormsRow = $totalFormsResult->fetch_assoc();
$totalForms = $totalFormsRow['total'];

$sql = "SELECT titulo, perguntas FROM formulario_texto WHERE id = $id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $titulo = $row['titulo'];
    $perguntas = explode(", ", $row['perguntas']); 
    echo json_encode(array("success" => true, "titulo" => $titulo, "perguntas" => $perguntas, "totalForms" => $totalForms));
} else {
    echo json_encode(array("success" => false, "message" => "Nenhum dado encontrado", "totalForms" => $totalForms));
}

$conn->close();
?>
