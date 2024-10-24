<?php
// Inclui o arquivo de conexão com o banco de dados
include('connection.php');

// Verifica se o formulário foi submetido
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recebe os dados do formulário
    $titulo = $_POST['titulo'];
    $perguntasArray = $_POST['perguntas'];
    
    // Junta as perguntas em uma única string, separadas por vírgula
    $perguntas = implode(', ', $perguntasArray);

    // Prepara a query SQL para inserção dos dados
    $sql = "INSERT INTO formulario_texto (titulo, perguntas) VALUES (?, ?)";

    // Prepara a declaração para execução
    $stmt = $conn->prepare($sql);

    // Vincula os parâmetros aos valores
    $stmt->bind_param("ss", $titulo, $perguntas);

    // Executa a declaração
    if ($stmt->execute()) {
        echo "Formulário criado com sucesso!";
    } else {
        echo "Erro ao criar o formulário: " . $stmt->error;
    }

    // Fecha a declaração e a conexão
    $stmt->close();
    $conn->close();
} else {
    // Se o formulário não foi submetido, redireciona para a página do formulário
    header("Location: criar_formulario_texto.php");
    exit;
}
?>
