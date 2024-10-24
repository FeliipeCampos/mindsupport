<?php
// Inclui a conexão com o banco de dados
include('actions/connection.php');

// Obtém o ID do formulário a ser editado
$id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: ID do formulário não encontrado.');

// Busca os dados do formulário incluindo as imagens
$sql = "SELECT titulo, imagem1, imagem2, imagem3, imagem4, imagem5, imagem6 FROM formularios_imagens WHERE id = $id";
$result = $conn->query($sql);

if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
} else {
    echo "Formulário não encontrado.";
    exit;
}
?>
<?php include('header.php'); ?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Formulário de Imagens</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h2>Editar Formulário de Imagens</h2>
    <form action="actions/atualizar_formulario_imagens.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= $id ?>">
        <div class="mb-3">
            <label for="tituloFormularioImagens" class="form-label">Título do Formulário</label>
            <input type="text" class="form-control" id="tituloFormularioImagens" name="titulo" value="<?= $row['titulo'] ?>" required>
        </div>
        <?php for ($i = 1; $i <= 6; $i++): ?>
            <div class="mb-3">
                <label for="imagem<?= $i ?>" class="form-label">Imagem <?= $i ?> (atual)</label>
                <?php if (!empty($row['imagem' . $i])): ?>
                    <img src="imagens/<?= $row['imagem' . $i] ?>" alt="Imagem <?= $i ?>" style="max-width: 100px; display: block;">
                <?php else: ?>
                    <p>Nenhuma imagem carregada.</p>
                <?php endif; ?>
                <input type="file" class="form-control" id="imagem<?= $i ?>" name="imagem<?= $i ?>">
            </div>
        <?php endfor; ?>
        <button type="submit" class="btn btn-primary">Salvar Alterações</button>
    </form>
</div>

<!-- Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
