<?php
include('header.php');
include('actions/connection.php');

// Verificar se o ID da pergunta foi enviado via URL
if (isset($_GET['id_pergunta'])) {
    $id_pergunta = $_GET['id_pergunta'];

    // Consulta a pergunta específica
    $sql = "SELECT * FROM perg WHERE id_pergunta = $id_pergunta";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "<script>alert('Pergunta não encontrada.'); window.location.href='criar_perguntas.php';</script>";
        exit;
    }
} else {
    echo "<script>alert('ID da pergunta não fornecido.'); window.location.href='criar_perguntas.php';</script>";
    exit;
}

// Atualizar pergunta
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nova_pergunta = $_POST['pergunta'];
    $novo_tipo = $_POST['tipo'];

    if ($nova_pergunta && $novo_tipo) {
        // Atualizar a pergunta no banco de dados
        $update_sql = "UPDATE perg SET pergunta = '$nova_pergunta', tipo = '$novo_tipo' WHERE id_pergunta = $id_pergunta";

        if ($conn->query($update_sql) === TRUE) {
            // Redirecionar para 'criar_perguntas.php' após o sucesso
            echo "<script>alert('Pergunta atualizada com sucesso.'); window.location.href='criar_perguntas.php';</script>";
        } else {
            echo "<script>alert('Erro ao atualizar a pergunta: " . $conn->error . "');</script>";
        }
    } else {
        echo "<script>alert('Por favor, preencha todos os campos corretamente.');</script>";
    }
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Pergunta</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h2 class="mb-4">Editar Pergunta</h2>

    <!-- Formulário para editar a pergunta -->
    <form method="POST">
        <div class="mb-3">
            <label for="pergunta" class="form-label">Pergunta</label>
            <input type="text" class="form-control" id="pergunta" name="pergunta" value="<?= $row['pergunta'] ?>" required>
        </div>

        <div class="mb-3">
            <label for="tipo" class="form-label">Tipo de Pergunta</label>
            <select class="form-select" id="tipo" name="tipo" required>
                <option value="1" <?= $row['tipo'] == 1 ? 'selected' : '' ?>>Texto</option>
                <option value="2" <?= $row['tipo'] == 2 ? 'selected' : '' ?>>Imagem</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Salvar Alterações</button>
    </form>
</div>

<!-- Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
