<?php
// Inclui o arquivo de conexão com o banco de dados
include('connection.php');

// Verifica se o formulário foi submetido
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Captura os dados do formulário
    $nome = $_POST['nome'] ?? '';
    $cid = $_POST['cid'] ?? '';
    $descricao = $_POST['descricao'] ?? '';
    $sintomas = $_POST['sintomas'] ?? '';
    $causas = $_POST['causas'] ?? '';
    $tratamento = $_POST['tratamento'] ?? '';
    $prevencao = $_POST['prevencao'] ?? '';

    // Verifica se todos os campos obrigatórios estão preenchidos
    if ($nome && $cid && $descricao && $sintomas && $causas && $tratamento && $prevencao) {
        // Prepara a query SQL para inserção dos dados
        $sql = "INSERT INTO doencas (nome, cid, descricao, sintomas, causas, tratamento, prevencao) VALUES (?, ?, ?, ?, ?, ?, ?)";

        // Prepara a declaração para execução
        $stmt = $conn->prepare($sql);

        // Vincula os parâmetros aos valores
        $stmt->bind_param("sssssss", $nome, $cid, $descricao, $sintomas, $causas, $tratamento, $prevencao);

        // Executa a declaração
        if ($stmt->execute()) {
            // Redireciona para a página de visualização após o cadastro
            header("Location: ../formulario_doenca_visualizar.php");
            exit; // Garante que o script pare após o redirecionamento
        } else {
            echo "Erro ao cadastrar a doença: " . $stmt->error;
        }

        // Fecha a declaração e a conexão
        $stmt->close();
        $conn->close();
    } else {
        echo "Por favor, preencha todos os campos.";
    }
} else {
    // Redireciona para a página de cadastro se o método de requisição não for POST
    header("Location: cadastrar_doenca.php");
    exit;
}
?>
