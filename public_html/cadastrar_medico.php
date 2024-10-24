<?php
include('header.php');
include('actions/connection.php');

// Inicia a sessão
session_start();

// Verifica se houve uma alteração no status ou tipo
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_id'])) {
    $user_id = $_POST['user_id'];
    $new_status = $_POST['status_id'];
    $new_tipo = $_POST['tipo_id'];

    // Atualiza o status_id e tipo_id no banco de dados
    $update_sql = "UPDATE usuarios SET status_id = $new_status, tipo_id = $new_tipo WHERE id_sec = $user_id";

    if ($conn->query($update_sql) === TRUE) {
        echo "<script>alert('Status e Tipo atualizados com sucesso!');</script>";
    } else {
        echo "<script>alert('Erro ao atualizar o status ou tipo: " . $conn->error . "');</script>";
    }
}

// Consulta os dados dos usuários da tabela 'usuarios'
$sql = "SELECT id_sec, nome, sobrenome, email, tipo_id, status_id FROM usuarios ORDER BY id_sec ASC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listagem de Usuários</title>
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
        .btn-salvar {
            margin-top: 10px;
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <h2 class="mb-4">Listagem de Usuários</h2>

    <!-- Tabela de usuários cadastrados -->
    <div class="table-wrapper">
        <table class="table table-bordered table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>ID Sec</th>
                    <th>Nome</th>
                    <th>Sobrenome</th>
                    <th>Email</th>
                    <th>Tipo ID</th>
                    <th>Status ID</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result && $result->num_rows > 0): ?>
                    <?php while($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= $row['id_sec'] ?></td>
                            <td><?= $row['nome'] ?></td>
                            <td><?= $row['sobrenome'] ?></td>
                            <td><?= $row['email'] ?></td>
                            <td>
                                <!-- Formulário para alterar Tipo ID e Status ID -->
                                <form method="POST" action="">
                                    <input type="hidden" name="user_id" value="<?= $row['id_sec'] ?>">
                                    <select name="tipo_id" class="form-select">
                                        <option value="1" <?= $row['tipo_id'] == 1 ? 'selected' : '' ?>>Paciente</option>
                                        <option value="2" <?= $row['tipo_id'] == 2 ? 'selected' : '' ?>>Médico</option>
                                    </select>
                            </td>
                            <td>
                                    <select name="status_id" class="form-select">
                                        <option value="1" <?= $row['status_id'] == 1 ? 'selected' : '' ?>>Ativo</option>
                                        <option value="2" <?= $row['status_id'] == 2 ? 'selected' : '' ?>>Inativo</option>
                                    </select>
                            </td>
                            <td>
                                    <button type="submit" class="btn btn-sm btn-primary btn-salvar">Salvar</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="text-muted">Nenhum usuário cadastrado na tabela 'usuarios'.</td>
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
