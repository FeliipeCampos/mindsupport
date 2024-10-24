<?php include('header.php'); ?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visualizar Formulários de imagens</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h2>Formulários de doenças Cadastradas</h2>
    <div class="list-group">
        <?php include('actions/connection.php'); 
        
        // Consulta SQL para selecionar os títulos dos formulários
        $sql = "SELECT id, nome FROM doencas ORDER BY id ASC";
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0): ?>
            <?php while($row = $result->fetch_assoc()): ?>
                <a href="formulario_doenca_editar.php?id=<?= htmlspecialchars($row["id"]) ?>" class="list-group-item list-group-item-action"><?= htmlspecialchars($row["nome"]) ?></a>
            <?php endwhile; ?>
        <?php else: ?>
            <p class="text-muted">Nenhum formulário de texto cadastrado.</p>
        <?php endif; 
        
        $conn->close(); ?>
    </div>
</div>


<!-- Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
