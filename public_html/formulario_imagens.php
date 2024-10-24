<?php include('header.php'); ?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Formulário de Imagens - Projeto Saúde</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <div class="card">
        <h5 class="card-header">Criar Formulário de Imagens</h5>
        <div class="card-body">
            <form action="actions/formulario_imagens.php" method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="tituloFormularioImagens" class="form-label">Título do Formulário</label>
                    <input type="text" class="form-control" id="tituloFormularioImagens" name="titulo" placeholder="Insira o título do formulário de imagens">
                </div>
                <div class="mb-3">
                    <label for="imagem1" class="form-label">Imagem 1</label>
                    <input type="file" class="form-control" id="imagem1" name="imagem1">
                </div>
                <div class="mb-3">
                    <label for="imagem2" class="form-label">Imagem 2</label>
                    <input type="file" class="form-control" id="imagem2" name="imagem2">
                </div>
                <div class="mb-3">
                    <label for="imagem3" class="form-label">Imagem 3</label>
                    <input type="file" class="form-control" id="imagem3" name="imagem3">
                </div>
                <div class="mb-3">
                    <label for="imagem4" class="form-label">Imagem 4</label>
                    <input type="file" class="form-control" id="imagem4" name="imagem4">
                </div>
                <div class="mb-3">
                    <label for="imagem5" class="form-label">Imagem 5</label>
                    <input type="file" class="form-control" id="imagem5" name="imagem5">
                </div>
                <div class="mb-3">
                    <label for="imagem6" class="form-label">Imagem 6</label>
                    <input type="file" class="form-control" id="imagem6" name="imagem6">
                </div>
                <button type="submit" class="btn btn-primary">Enviar Formulário</button>
            </form>
        </div>
    </div>
</div>

<!-- Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
