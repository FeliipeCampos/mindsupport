<?php
// Supondo que você já tenha incluído a conexão PDO no arquivo anterior

// Converte o JSON para um array associativo
$dataArray = json_decode($jsonData, true);

// Verifica se a decodificação foi bem-sucedida
if ($dataArray === null) {
    die(json_encode(['error' => "Erro ao decodificar JSON."]));
}

// Separa os dados em variáveis
$bpm = isset($dataArray['bpm']) ? (int)$dataArray['bpm'] : null;
$passos = isset($dataArray['passos']) ? (int)$dataArray['passos'] : null;
$spo2 = isset($dataArray['spo2']) ? (int)$dataArray['spo2'] : null;
$stress_id = 0; // Valor padrão para stress_id
$status_id = 0; // Valor padrão para status_id
$usuario_id = 0; // Valor padrão para usuario_id

// Prepara a inserção dos dados na tabela dados_tratados
$sqlTratados = "INSERT INTO dados_tratados (bpm, usuario_id, passos, spo2, stress_id, status_id) VALUES (:bpm, :usuario_id, :passos, :spo2, :stress_id, :status_id)";
$stmtTratados = $pdo->prepare($sqlTratados);

// Tenta inserir os dados na tabela dados_tratados
try {
    $stmtTratados->execute([
        ':bpm' => $bpm,
        ':usuario_id' => $usuario_id, // Agora usando um valor padrão
        ':passos' => $passos,
        ':spo2' => $spo2,
        ':stress_id' => $stress_id, // Agora usando um valor padrão
        ':status_id' => $status_id // Agora usando um valor padrão
    ]);
    echo json_encode(['success' => "Dados tratados inseridos com sucesso!"]);
} catch (PDOException $e) {
    echo json_encode(['error' => "Erro ao inserir dados tratados: " . $e->getMessage()]);
}
?>
