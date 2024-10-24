<?php
session_start(); 

// Verifica se o usuário está logado
if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
    // Usuário não está logado, redireciona para a página de login
    header("Location: ../login.php"); 
    exit(); // Adiciona exit para garantir que o script pare
}
?>
