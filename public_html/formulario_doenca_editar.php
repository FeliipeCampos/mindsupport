<?php
// Inclui a conexão com o banco de dados
include('actions/connection.php');

// Obtém o ID do formulário a ser editado
$id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: ID do formulário não encontrado.');

// Busca os dados do formulário
$sql = "SELECT nome, cid, descricao FROM doencas WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
} else {
    echo "Formulário não encontrado.";
    exit;
}

$conn->close();
?>

<?php include('header.php'); ?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Doença</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h2>Editar Formulário de Texto</h2>
    <form action="actions/formulario_doenca_editar.php" method="post">
        <input type="hidden" name="id" value="<?= htmlspecialchars($id) ?>">
        <div class="mb-3">
            <label for="nome_doenca" class="form-label">Nome da doença</label>
            <input type="text" class="form-control" id="nome_doenca" name="nome" value="<?= htmlspecialchars($row['nome']) ?>" required>
        </div>
        <div class="mb-3">
            <label for="cid" class="form-label">CID</label>
            <input type="text" class="form-control" id="cid" name="cid" value="<?= htmlspecialchars($row['cid']) ?>" required>
        </div>
        <div class="mb-3">
            <label for="descricao" class="form-label">Descrição da doença</label>
            <textarea class="form-control" id="descricao" name="descricao" rows="3" required><?= htmlspecialchars($row['descricao']) ?></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Salvar Alterações</button>
    </form>
</div>

<!-- Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
