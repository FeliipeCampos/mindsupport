<?php
include('connection.php');

// Recebe os dados do formulário
$nome = $_POST['nome'];
$sobrenome = $_POST['sobrenome'];
$email = $_POST['email'];
$tipo_id = $_POST['tipo_id']; 
$status_id = 1; 
$senha = password_hash($_POST['password'], PASSWORD_DEFAULT);

// Prepara a inserção dos dados com os campos atualizados
$sql = "INSERT INTO usuarios (nome, sobrenome, email, senha, tipo_id, status_id) VALUES (?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssii", $nome, $sobrenome, $email, $senha, $tipo_id, $status_id);

// Executa a inserção
if ($stmt->execute()) {
    // Redireciona para login.php após cadastro bem-sucedido
    header("Location: ../login.php");
    exit(); // Garante que o script pare após o redirecionamento
} else {
    echo "Erro ao cadastrar usuário: " . $stmt->error;
}

// Fecha a conexão
$stmt->close();
$conn->close();
?>
