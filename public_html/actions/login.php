<?php
session_start(); // Inicia a sessão
include('connection.php');

// Recebe os dados do formulário
$email = $_POST['email'];
$password = $_POST['password'];

// Cria a consulta SQL diretamente (sem prepared statement)
$sql = "SELECT id_sec, nome, senha FROM usuarios WHERE email = '$email'";
$result = $conn->query($sql);

if ($result && $result->num_rows === 1) {
    // Usuário encontrado, obtém os dados
    $user = $result->fetch_assoc();
    
    // Verifica a senha
    if (password_verify($password, $user['senha'])) {
        // Senha correta, armazena o ID e nome do usuário na sessão
        $_SESSION['user_id'] = $user['id_sec'];
        $_SESSION['usuario_nome'] = $user['nome']; // Armazena o nome
        $_SESSION['logado'] = true; // Define que o usuário está logado
        
        // Redireciona para index.php
        header("Location: ../index.php");
        exit();
    } else {
        // Senha incorreta
        echo "Senha incorreta. Tente novamente.";
    }
} else {
    // Usuário não encontrado
    echo "Usuário não encontrado. Verifique seu email.";
}

// Fecha a conexão
$conn->close();
?>
