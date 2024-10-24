<?php include('header.php'); ?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visualizar Formulários de Texto</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h2>Formulários de texto Cadastrados</h2>
    <div class="accordion" id="formulariosAccordion">
        <?php
        include('actions/connection.php'); 

        // Consulta SQL para selecionar os formulários com suas perguntas
        $sql = "SELECT id, titulo, perguntas FROM formulario_texto ORDER BY id ASC";
        $result = $conn->query($sql);

        if ($result->num_rows > 0):
            while($row = $result->fetch_assoc()):
                $perguntas = explode(', ', $row["perguntas"]); // Divide as perguntas em um array
        ?>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="heading<?= htmlspecialchars($row["id"]) ?>">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?= htmlspecialchars($row["id"]) ?>" aria-expanded="true" aria-controls="collapse<?= htmlspecialchars($row["id"]) ?>">
                            <?= htmlspecialchars($row["titulo"]) ?>
                        </button>
                    </h2>
                    <div id="collapse<?= htmlspecialchars($row["id"]) ?>" class="accordion-collapse collapse" aria-labelledby="heading<?= htmlspecialchars($row["id"]) ?>" data-bs-parent="#formulariosAccordion">
                        <div class="accordion-body">
                            <ul class="list-group mb-3">
                                <?php foreach ($perguntas as $index => $pergunta): ?>
                                    <li class="list-group-item"><?= htmlspecialchars($pergunta) ?></li>
                                <?php endforeach; ?>
                            </ul>
                            <a href="formulario_texto_editar.php?id=<?= htmlspecialchars($row["id"]) ?>" class="btn btn-primary">Editar</a>
                        </div>
                    </div>
                </div>
        <?php 
            endwhile;
        else: 
        ?>
            <p class="text-muted">Nenhum formulário de texto cadastrado.</p>
        <?php 
        endif;

        $conn->close(); 
        ?>
    </div>
</div>

<!-- Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
