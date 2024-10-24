<?php
include('connection.php'); 

// Verifica se o formulário foi submetido
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Captura os dados do formulário
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $cid = $_POST['cid'];
    $descricao = $_POST['descricao'];

    // Prepara a query SQL para atualização dos dados
    $sql = "UPDATE doencas SET nome = ?, cid = ?, descricao = ? WHERE id = ?";

    // Prepara a declaração para execução
    $stmt = $conn->prepare($sql);

    // Vincula os parâmetros aos valores
    $stmt->bind_param("sssi", $nome, $cid, $descricao, $id);

    // Executa a declaração
    if ($stmt->execute()) {
        // Se a atualização for bem-sucedida, redireciona para a página de edição com o ID específico
        header("Location: ../formulario_doenca_editar.php?id=" . $id);
        exit;
    } else {
        // Em caso de erro, exibe uma mensagem
        echo "Erro ao atualizar a doença: " . $stmt->error;
    }

    // Fecha a declaração e a conexão
    $stmt->close();
    $conn->close();
} else {
    // Se o método de requisição não for POST, redireciona para a página de edição
    header("Location: ../formulario_doenca_editar.php"); 
    exit;
}
?>
