<?php
// Inclui a conexão com o banco de dados
include('connection.php');

// Verifica se o formulário foi submetido
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Captura os dados do formulário
    $id = $_POST['id'];
    $titulo = $_POST['titulo'];
    $perguntasArray = $_POST['perguntas'];

    // Junta as perguntas em uma única string, separadas por vírgula
    $perguntas = implode(', ', $perguntasArray);

    // Prepara a query SQL para atualização dos dados
    $sql = "UPDATE formulario_texto SET titulo = ?, perguntas = ? WHERE id = ?";

    // Prepara a declaração para execução
    if ($stmt = $conn->prepare($sql)) {
        // Vincula os parâmetros aos valores
        $stmt->bind_param("ssi", $titulo, $perguntas, $id);

        // Executa a declaração
        if ($stmt->execute()) {
            // Redireciona de volta para a página de edição após atualização bem-sucedida
            header("Location: ../formulario_textos_visualizar.php?id=" . $id);
            exit;
        } else {
            // Se ocorrer um erro durante a atualização, exibe uma mensagem de erro
            echo "Erro ao atualizar o formulário: " . $stmt->error;
        }

        // Fecha a declaração
        $stmt->close();
    } else {
        echo "Erro ao preparar a declaração SQL: " . $conn->error;
    }

    // Fecha a conexão
    $conn->close();
} else {
    // Redireciona para a página de edição se o método de requisição não for POST
    header("Location: ../formulario_textos_visualizar.php");
    exit;
}
?>
