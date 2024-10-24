<?php
include('connection.php');

// Verificar se o ID da pergunta foi enviado via URL
if (isset($_GET['id_pergunta'])) {
    $id_pergunta = $_GET['id_pergunta'];

    // Atualizar o status da pergunta para desativada (2)
    $update_sql = "UPDATE perg SET status_id = 2 WHERE id_pergunta = $id_pergunta";

    if ($conn->query($update_sql) === TRUE) {
        // Exibir alerta e redirecionar para 'criar_perguntas.php'
        echo "<script>alert('Pergunta desativada com sucesso.'); window.location.href='../criar_perguntas.php';</script>";
    } else {
        // Exibir alerta de erro e redirecionar para 'criar_perguntas.php'
        echo "<script>alert('Erro ao desativar a pergunta: " . $conn->error . "'); window.location.href='../criar_perguntas.php';</script>";
    }
} else {
    // Exibir alerta se o ID da pergunta não foi fornecido
    echo "<script>alert('ID da pergunta não fornecido.'); window.location.href='../criar_perguntas.php';</script>";
}

$conn->close();
?>
