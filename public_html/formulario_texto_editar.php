<?php
// Inclui a conexão com o banco de dados
include('actions/connection.php');

// Obtém o ID do formulário a ser editado
$id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: ID do formulário não encontrado.');

// Busca os dados do formulário
$sql = "SELECT titulo, perguntas FROM formulario_texto WHERE id = $id";
$result = $conn->query($sql);

if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    $perguntas = explode(', ', $row['perguntas']); // Divide as perguntas em um array
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
    <title>Editar Formulário de Texto</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h2>Editar Formulário de Texto</h2>
    <form id="editForm" action="actions/formulario_texto_editar.php" method="post">
        <input type="hidden" name="id" value="<?= $id ?>">
        <div class="mb-3">
            <label for="tituloFormulario" class="form-label">Título do Formulário</label>
            <input type="text" class="form-control" id="tituloFormulario" name="titulo" value="<?= $row['titulo'] ?>" required>
        </div>
        <div id="perguntasContainer">
            <?php foreach ($perguntas as $index => $pergunta): ?>
                <div class="mb-3">
                    <label for="pergunta<?= $index + 1 ?>" class="form-label">Pergunta <?= $index + 1 ?></label>
                    <input type="text" class="form-control" id="pergunta<?= $index + 1 ?>" name="perguntas[]" value="<?= $pergunta ?>" required>
                </div>
            <?php endforeach; ?>
        </div>
        <button type="button" class="btn btn-secondary" id="addPergunta">Adicionar Pergunta</button>
        <button type="submit" class="btn btn-primary">Salvar Alterações</button>
    </form>
</div>

<!-- Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.getElementById('addPergunta').addEventListener('click', function() {
        const perguntasContainer = document.getElementById('perguntasContainer');
        const numPerguntas = perguntasContainer.children.length + 1;

        const newPerguntaDiv = document.createElement('div');
        newPerguntaDiv.classList.add('mb-3');

        const newLabel = document.createElement('label');
        newLabel.classList.add('form-label');
        newLabel.setAttribute('for', 'pergunta' + numPerguntas);
        newLabel.textContent = 'Pergunta ' + numPerguntas;

        const newInput = document.createElement('input');
        newInput.type = 'text';
        newInput.classList.add('form-control');
        newInput.id = 'pergunta' + numPerguntas;
        newInput.name = 'perguntas[]';
        newInput.placeholder = 'Insira a pergunta ' + numPerguntas;

        newPerguntaDiv.appendChild(newLabel);
        newPerguntaDiv.appendChild(newInput);

        perguntasContainer.appendChild(newPerguntaDiv);
    });
</script>
</body>
</html>
