<?php
include('header.php');
include('actions/connection.php');

// Inicia a sessão para acessar o user_id (que agora será o medico_id)
session_start();

// Verifica se o ID da pergunta foi passado via GET
if (isset($_GET['id_pergunta'])) {
    $id_pergunta = $_GET['id_pergunta'];

    // Consulta para buscar os detalhes da pergunta específica
    $sql = "SELECT id_pergunta, pergunta, tipo, medico_id, status_id FROM perg WHERE id_seq = '$id_pergunta'";
    $result = $conn->query($sql);

    // Verifica se a consulta retornou alguma pergunta
    if ($result && $result->num_rows > 0) {
        $pergunta = $result->fetch_assoc();
    } else {
        echo "<script>alert('Pergunta não encontrada!'); window.location.href = 'criar_perguntas.php';</script>";
        exit();
    }
} else {
    echo "<script>alert('ID de pergunta não fornecido!'); window.location.href = 'criar_perguntas.php';</script>";
    exit();
}

// Verifica se o formulário de edição foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nova_pergunta = $_POST['pergunta'];
    $novo_tipo = $_POST['tipo'];

    // Verifica se todos os campos foram preenchidos
    if ($nova_pergunta && $novo_tipo) {
        // Atualizar a pergunta no banco de dados
        $update_sql = "UPDATE perg SET pergunta = '$nova_pergunta', tipo = '$novo_tipo' WHERE id_seq = '$id_pergunta'";
        
        if ($conn->query($update_sql) === TRUE) {
            echo "<script>alert('Pergunta atualizada com sucesso!'); window.location.href = 'criar_perguntas.php';</script>";
        } else {
            echo "<script>alert('Erro ao atualizar a pergunta: " . $conn->error . "');</script>";
        }
    } else {
        echo "<script>alert('Por favor, preencha todos os campos corretamente.');</script>";
    }
}
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

    <!-- Exibe os detalhes da pergunta -->
    <div class="card mb-4">
        <div class="card-header">
            Detalhes da Pergunta
        </div>
        <div class="card-body">
            <p><strong>ID Pergunta:</strong> <?= $pergunta['id_pergunta'] ?></p>
            <p><strong>Tipo:</strong> <?= $pergunta['tipo'] == 1 ? 'Texto' : 'Imagem' ?></p>
            <p><strong>Médico ID:</strong> <?= $pergunta['medico_id'] ?></p>
            <p><strong>Status:</strong> <?= $pergunta['status_id'] == 1 ? 'Ativada' : 'Desativada' ?></p>
        </div>
    </div>

    <!-- Formulário de edição da pergunta -->
    <form method="POST">
        <!-- Campo de texto para a pergunta -->
        <div class="mb-3">
            <label for="pergunta" class="form-label">Pergunta</label>
            <input type="text" class="form-control" id="pergunta" name="pergunta" value="<?= $pergunta['pergunta'] ?>" required>
        </div>

        <!-- Dropdown para selecionar o tipo de pergunta -->
        <div class="mb-3">
            <label for="tipo" class="form-label">Tipo de Pergunta</label>
            <select class="form-select" id="tipo" name="tipo" required>
                <option value="1" <?= $pergunta['tipo'] == 1 ? 'selected' : '' ?>>Texto</option>
                <option value="2" <?= $pergunta['tipo'] == 2 ? 'selected' : '' ?>>Imagem</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Salvar Alterações</button>
        <a href="criar_perguntas.php" class="btn btn-secondary">Cancelar</a>
    </form>
</div>

<!-- Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$conn->close();
?>
