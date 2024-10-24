<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Doença - Projeto Saúde</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Optional: FontAwesome for icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
</head>
<body>

<?php include('header.php'); ?>

<div class="container mt-5">
    <div class="card">
        <h5 class="card-header">Cadastrar Doença</h5>
        <div class="card-body">
            <form action="actions/cadastrar_doenca.php" method="post">
                <div class="mb-3">
                    <label for="nomeDoenca" class="form-label">Nome da Doença</label>
                    <input type="text" class="form-control" id="nomeDoenca" name="nome" required>
                </div>
                <div class="mb-3">
                    <label for="cidDoenca" class="form-label">CID</label>
                    <input type="text" class="form-control" id="cidDoenca" name="cid" required>
                </div>
                <div class="mb-3">
                    <label for="descricaoDoenca" class="form-label">Descrição</label>
                    <textarea class="form-control" id="descricaoDoenca" name="descricao" rows="3" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="sintomasDoenca" class="form-label">Sintomas</label>
                    <textarea class="form-control" id="sintomasDoenca" name="sintomas" rows="3" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="causasDoenca" class="form-label">Causas</label>
                    <textarea class="form-control" id="causasDoenca" name="causas" rows="3" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="tratamentoDoenca" class="form-label">Tratamento</label>
                    <textarea class="form-control" id="tratamentoDoenca" name="tratamento" rows="3" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="prevencaoDoenca" class="form-label">Prevenção</label>
                    <textarea class="form-control" id="prevencaoDoenca" name="prevencao" rows="3" required></textarea>
                </div>
                <a href="perguntas_doenca_editar.php" class="btn btn-secondary">Edite as Perguntas</a>
                <button type="submit" class="btn btn-primary">Cadastrar Doença</button>
            </form>
        </div>
    </div>
</div><br>

<!-- Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
