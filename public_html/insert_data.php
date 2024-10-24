<?php
// Ativar relatório de erros
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Configurações de conexão com o banco de dados
$host = "deepsys_area.mysql.dbaas.com.br";
$dbname = "deepsys_area";
$user = "deepsys_area";
$password = "F3l!pe_";

// Tentativa de conexão ao banco de dados usando PDO
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
} catch (PDOException $e) {
    die(json_encode(['error' => "Erro de conexão: " . $e->getMessage()]));
}

// Verifica se os dados foram enviados via POST como JSON
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Captura o conteúdo do POST e converte de JSON para uma string
    $jsonData = file_get_contents('php://input');
    $currentTime = date('Y-m-d H:i:s');  // Captura a data e hora atual

    // Prepara a inserção dos dados no banco
    $sql = "INSERT INTO dados (dados, hora) VALUES (:dados, :hora)";
    $stmt = $pdo->prepare($sql);

    // Tenta inserir os dados, captura erros
    try {
        $stmt->execute([':dados' => $jsonData, ':hora' => $currentTime]);
        
        // Chama o arquivo após a inserção bem-sucedida
        include 'dados_distribution.php'; // Inclui o arquivo, agora com acesso a $jsonData
        echo json_encode(['success' => "Dados inseridos com sucesso!"]);
    } catch (PDOException $e) {
        echo json_encode(['error' => "Erro ao inserir dados: " . $e->getMessage()]);
    }
} else {
    echo json_encode(['error' => "Método de requisição inválido. Use POST."]);
}
?>
