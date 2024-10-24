<?php include('header.php'); ?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Formulário de Texto - Projeto Saúde</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <div class="card">
        <h5 class="card-header">Criar Formulário de Texto</h5>
        <div class="card-body">
            <form id="dynamicForm" action="actions/formulario_texto.php" method="post">
                <div class="mb-3">
                    <label for="tituloFormulario" class="form-label">Título do Formulário</label>
                    <input type="text" class="form-control" id="tituloFormulario" name="titulo" placeholder="Insira o título do formulário">
                </div>
                <div id="perguntasContainer">
                    <div class="mb-3">
                        <label for="pergunta1" class="form-label">Pergunta 1</label>
                        <input type="text" class="form-control" id="pergunta1" name="perguntas[]" placeholder="Insira a primeira pergunta">
                    </div>
                </div>
                <button type="button" class="btn btn-secondary" id="addPergunta">Adicionar Pergunta</button>
                <button type="submit" class="btn btn-primary">Criar Formulário</button>
            </form>
        </div>
    </div>
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
