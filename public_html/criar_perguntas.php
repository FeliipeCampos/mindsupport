<?php
include('header.php');
include('actions/connection.php');

// Inicia a sessão para acessar o user_id (que agora será o medico_id)
session_start();

// ID de status padrão para perguntas
$status_id = 1;

// Captura o medico_id da sessão
$medico_id = $_SESSION['user_id']; // Considerando que o médico esteja logado e o user_id seja o medico_id

// Adicionar uma nova pergunta se o formulário for enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['pergunta'])) {
    $pergunta = $_POST['pergunta'];
    $tipo = $_POST['tipo'];

    // Verifica se todos os campos obrigatórios foram preenchidos
    if ($pergunta && $tipo) {
        // Contar quantas perguntas já existem para o medico_id atual
        $seq_sql = "SELECT COUNT(*) as count FROM perg WHERE medico_id = '$medico_id'";
        $seq_result = $conn->query($seq_sql);
        
        // Verifica se a consulta foi bem-sucedida
        if ($seq_result) {
            $seq_row = $seq_result->fetch_assoc();
            $sequencia = $seq_row['count'] + 1; // Próxima sequência

            // Gerar o id_pergunta concatenando medico_id com a sequência, sem zeros adicionais
            $id_pergunta = intval($medico_id . $sequencia);

            // Inserção na tabela `perg` incluindo o medico_id, sem inserir user_id
            $sql = "INSERT INTO perg (id_pergunta, status_id, medico_id, tipo, pergunta) 
                    VALUES ($id_pergunta, $status_id, '$medico_id', '$tipo', '$pergunta')";

            if ($conn->query($sql) === TRUE) {
                // Alerta de sucesso com a mensagem "Registro adicionado"
                echo "<script>alert('Registro adicionado');</script>";
            } else {
                // Alerta de erro usando JavaScript
                echo "<script>alert('Erro ao adicionar a pergunta: " . $conn->error . "');</script>";
            }
        } else {
            // Alerta de erro na contagem de perguntas
            echo "<script>alert('Erro ao contar perguntas: " . $conn->error . "');</script>";
        }
    } else {
        // Alerta de erro se os campos não estiverem preenchidos
        echo "<script>alert('Por favor, preencha todos os campos corretamente.');</script>";
    }
}

// Desativar a pergunta se o botão for clicado
if (isset($_GET['desativar_id'])) {
    $desativar_id = $_GET['desativar_id'];
    
    // Atualizar o status da pergunta para desativada (2)
    $update_sql = "UPDATE perg SET status_id = 2 WHERE id_pergunta = $desativar_id";
    
    if ($conn->query($update_sql) === TRUE) {
        echo "<script>alert('Pergunta desativada com sucesso.');</script>";
    } else {
        echo "<script>alert('Erro ao desativar a pergunta: " . $conn->error . "');</script>";
    }
}

// Ativar a pergunta se o botão for clicado
if (isset($_GET['ativar_id'])) {
    $ativar_id = $_GET['ativar_id'];
    
    // Atualizar o status da pergunta para ativada (1)
    $update_sql = "UPDATE perg SET status_id = 1 WHERE id_pergunta = $ativar_id";
    
    if ($conn->query($update_sql) === TRUE) {
        echo "<script>alert('Pergunta ativada com sucesso.');</script>";
    } else {
        echo "<script>alert('Erro ao ativar a pergunta: " . $conn->error . "');</script>";
    }
}

// Consulta todas as perguntas para exibição
$sql = "SELECT id_seq, id_pergunta, pergunta, tipo, medico_id, status_id FROM perg ORDER BY id_seq ASC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Perguntas</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        table {
            table-layout: fixed;
            width: 100%;
        }
        th, td {
            text-align: center;
            vertical-align: middle;
            word-wrap: break-word;
        }
        .table-wrapper {
            overflow-x: auto;
        }
        .btn-criar-resposta, .btn-desativar, .btn-ativar {
            width: 150px;
            text-align: center;
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <h2 class="mb-4">Gerenciar Perguntas</h2>
    
    <!-- Formulário para adicionar nova pergunta -->
    <form method="POST" class="mb-4">
        <!-- Campo de texto para a pergunta -->
        <div class="mb-3">
            <label for="pergunta" class="form-label">Nova Pergunta</label>
            <input type="text" class="form-control" id="pergunta" name="pergunta" placeholder="Digite a nova pergunta" required>
        </div>

        <!-- Dropdown para selecionar o tipo de pergunta -->
        <div class="mb-3">
            <label for="tipo" class="form-label">Tipo de Pergunta</label>
            <select class="form-select" id="tipo" name="tipo" required>
                <option value="" disabled selected>Selecione o tipo</option>
                <option value="1">Texto</option>
                <option value="2">Imagem</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Adicionar Pergunta</button>
    </form>

    <!-- Tabela de perguntas cadastradas -->
    <div class="table-wrapper">
        <table class="table table-bordered table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>ID Seq</th>
                    <th>Pergunta</th>
                    <th>Tipo</th>
                    <th>Medico ID</th>
                    <th>Status</th>
                    <th>ID Pergunta</th>
                    <th>Criar Respostas</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result && $result->num_rows > 0): ?>
                    <?php while($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= $row['id_seq'] ?></td>
                            <td><?= $row['pergunta'] ?></td>
                            <td><?= $row['tipo'] == 1 ? 'Texto' : 'Imagem' ?></td>
                            <td><?= $row['medico_id'] ?></td>
                            <td><?= $row['status_id'] == 1 ? 'Ativada' : 'Desativada' ?></td>
                            <td><?= $row['id_pergunta'] ?></td>
                            <td>
                                <a href="criar_respostas.php?id_pergunta=<?= $row['id_pergunta'] ?>" class="btn btn-sm btn-primary btn-criar-resposta">Criar Respostas</a>
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        Ações
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="dropdown-item" href="editar_pergunta.php?id_pergunta=<?= $row['id_pergunta'] ?>">Editar</a>
                                        </li>
                                        <?php if ($row['status_id'] == 1): ?>
                                            <li>
                                                <a class="dropdown-item" href="actions/desativar_pergunta.php?id_pergunta=<?= $row['id_pergunta'] ?>">Desativar</a>
                                            </li>
                                        <?php else: ?>
                                            <li>
                                                <a class="dropdown-item" href="actions/ativar_pergunta.php?id_pergunta=<?= $row['id_pergunta'] ?>">Ativar</a>
                                            </li>
                                        <?php endif; ?>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8" class="text-muted">Nenhuma pergunta cadastrada na tabela 'perg'.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$conn->close();
?>
