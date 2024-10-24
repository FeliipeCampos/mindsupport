<?php
include('header.php');
include('actions/connection.php');

// Inicia a sessão para acessar o user_id
session_start();

// Captura o medico_id da sessão
$user_id = $_SESSION['user_id']; // ID do usuário logado (medico_id)

// Captura o id_pergunta da URL
$id_pergunta = isset($_GET['id_pergunta']) ? $_GET['id_pergunta'] : null;

// Verifica se o id_pergunta foi fornecido
if (!$id_pergunta) {
    echo "ID da pergunta não fornecido.";
    exit;
}

// Consulta para buscar detalhes da pergunta pelo id_pergunta
$sql_pergunta = "SELECT id_pergunta, status_id, medico_id, tipo, pergunta, created_dt FROM perg WHERE id_pergunta = '$id_pergunta'";
$result_pergunta = $conn->query($sql_pergunta);

if ($result_pergunta->num_rows > 0) {
    // Obtém os detalhes da pergunta
    $pergunta_data = $result_pergunta->fetch_assoc();

    // Consulta para buscar o nome e sobrenome do médico
    $medico_id = $pergunta_data['medico_id'];
    $sql_medico = "SELECT nome, sobrenome FROM usuarios WHERE id_sec = '$medico_id'";
    $result_medico = $conn->query($sql_medico);

    if ($result_medico->num_rows > 0) {
        $medico_data = $result_medico->fetch_assoc();
        $nome_medico = $medico_data['nome'] . " " . $medico_data['sobrenome'];
    } else {
        $nome_medico = "Médico não encontrado";
    }
} else {
    echo "Pergunta não encontrada.";
    exit;
}

// Adicionar uma nova resposta se o formulário for enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tipo = $pergunta_data['tipo'];

    // Tratamento para resposta tipo texto
    if ($tipo == 1) {
        $resp_texto = $_POST['resp_texto'];

        // Verifica se o campo de resposta foi preenchido
        if ($resp_texto) {
            // Contar quantas respostas já existem para o id_pergunta atual
            $seq_sql = "SELECT COUNT(*) as count FROM perg_opcoes WHERE pergunta_id = '$id_pergunta'";
            $seq_result = $conn->query($seq_sql);

            if ($seq_result) {
                $seq_row = $seq_result->fetch_assoc();
                $sequencia = $seq_row['count'] + 1; // Próxima sequência

                // Gerar o id_resposta concatenando user_id com a sequência
                $id_resposta = intval($user_id . $sequencia);

                // Inserção na tabela `perg_opcoes` incluindo o id da pergunta e o id_resposta
                $sql_resposta = "INSERT INTO perg_opcoes (pergunta_id, id_resposta, resp_texto, user_id, status_id) 
                                 VALUES ('$id_pergunta', '$id_resposta', '$resp_texto', '$user_id', 1)";

                if ($conn->query($sql_resposta) === TRUE) {
                    // Alerta de sucesso com a mensagem "Resposta adicionada"
                    echo "<script>alert('Resposta adicionada com sucesso!');</script>";
                } else {
                    // Alerta de erro
                    echo "<script>alert('Erro ao adicionar a resposta: " . $conn->error . "');</script>";
                }
            } else {
                echo "<script>alert('Erro ao contar respostas: " . $conn->error . "');</script>";
            }
        } else {
            // Alerta de erro se o campo de resposta não estiver preenchido
            echo "<script>alert('Por favor, insira uma resposta.');</script>";
        }
    }

    // Tratamento para resposta tipo imagem
    if ($tipo == 2 && isset($_FILES['resp_imagem'])) {
        $imagem = $_FILES['resp_imagem'];

        // Verifica se o arquivo foi carregado corretamente
        if ($imagem['error'] === UPLOAD_ERR_OK) {
            $extensao = pathinfo($imagem['name'], PATHINFO_EXTENSION); // Obtém a extensão do arquivo
            $hash = md5(uniqid(rand(), true)); // Gera o hash único
            $novo_nome_imagem = $hash . '.' . $extensao; // Define o novo nome da imagem com hash
            $caminho_imagem = 'imagens/' . $novo_nome_imagem; // Define o caminho de armazenamento

            // Move a imagem para a pasta "imagens" no servidor
            if (move_uploaded_file($imagem['tmp_name'], $caminho_imagem)) {
                // Contar quantas respostas já existem para o id_pergunta atual
                $seq_sql = "SELECT COUNT(*) as count FROM perg_opcoes WHERE pergunta_id = '$id_pergunta'";
                $seq_result = $conn->query($seq_sql);

                if ($seq_result) {
                    $seq_row = $seq_result->fetch_assoc();
                    $sequencia = $seq_row['count'] + 1; // Próxima sequência

                    // Gerar o id_resposta concatenando user_id com a sequência
                    $id_resposta = intval($user_id . $sequencia);

                    // Inserir os dados da imagem na tabela perg_opcoes
                    $sql_resposta = "INSERT INTO perg_opcoes (pergunta_id, id_resposta, resp_imagem, user_id, status_id) 
                                     VALUES ('$id_pergunta', '$id_resposta', '$caminho_imagem', '$user_id', 1)";

                    if ($conn->query($sql_resposta) === TRUE) {
                        // Alerta de sucesso
                        echo "<script>alert('Imagem enviada com sucesso!');</script>";
                    } else {
                        // Alerta de erro ao salvar no banco de dados
                        echo "<script>alert('Erro ao salvar a imagem no banco de dados: " . $conn->error . "');</script>";
                    }
                } else {
                    echo "<script>alert('Erro ao contar respostas: " . $conn->error . "');</script>";
                }
            } else {
                // Alerta de erro ao mover o arquivo
                echo "<script>alert('Erro ao mover o arquivo para o servidor.');</script>";
            }
        } else {
            // Alerta de erro no upload
            echo "<script>alert('Erro ao carregar a imagem.');</script>";
        }
    }
}

// Desativar a resposta se o botão for clicado
if (isset($_GET['desativar_id'])) {
    $desativar_id = $_GET['desativar_id'];
    
    // Atualizar o status da resposta para desativada (2)
    $update_sql = "UPDATE perg_opcoes SET status_id = 2 WHERE id_resposta = $desativar_id";
    
    if ($conn->query($update_sql) === TRUE) {
        echo "<script>alert('Resposta desativada com sucesso.');</script>";
    } else {
        echo "<script>alert('Erro ao desativar a resposta: " . $conn->error . "');</script>";
    }
}

// Ativar a resposta se o botão for clicado
if (isset($_GET['ativar_id'])) {
    $ativar_id = $_GET['ativar_id'];
    
    // Atualizar o status da resposta para ativada (1)
    $update_sql = "UPDATE perg_opcoes SET status_id = 1 WHERE id_resposta = $ativar_id";
    
    if ($conn->query($update_sql) === TRUE) {
        echo "<script>alert('Resposta ativada com sucesso.');</script>";
    } else {
        echo "<script>alert('Erro ao ativar a resposta: " . $conn->error . "');</script>";
    }
}

// Consulta para buscar todas as respostas cadastradas para essa pergunta
$sql_respostas = "SELECT id_resposta, resp_texto, resp_imagem, user_id, status_id FROM perg_opcoes WHERE pergunta_id = '$id_pergunta'";
$result_respostas = $conn->query($sql_respostas);

?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inserir Resposta</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h2 class="mb-4">Inserir Resposta para a Pergunta</h2>
    
    <div class="mb-4">
        <h4>Pergunta:</h4>
        <p><?php echo $pergunta_data['pergunta']; ?></p>
        <p><strong>Médico:</strong> <?php echo $nome_medico; ?></p>
        <p><strong>Data:</strong> <?php echo $pergunta_data['created_dt']; ?></p>
    </div>

    <!-- Exibição do formulário para adicionar respostas -->
    <form method="POST" enctype="multipart/form-data">
        <?php if ($pergunta_data['tipo'] == 1) { ?>
            <!-- Resposta tipo texto -->
            <div class="mb-3">
                <label for="resp_texto" class="form-label">Resposta em Texto:</label>
                <textarea class="form-control" id="resp_texto" name="resp_texto" rows="4"></textarea>
            </div>
        <?php } elseif ($pergunta_data['tipo'] == 2) { ?>
            <!-- Resposta tipo imagem -->
            <div class="mb-3">
                <label for="resp_imagem" class="form-label">Carregar Imagem:</label>
                <input class="form-control" type="file" id="resp_imagem" name="resp_imagem" accept="image/*">
            </div>
        <?php } ?>
        <button type="submit" class="btn btn-primary">Enviar Resposta</button>
    </form>

    <!-- Exibição das respostas já cadastradas -->
    <h3 class="mt-5">Respostas Cadastradas</h3>
    
    <table class="table">
        <thead>
            <tr>
                <th>ID Resposta</th>
                <th>Conteúdo</th>
                <th>Status</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result_respostas->num_rows > 0) {
                while ($row = $result_respostas->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $row['id_resposta']; ?></td>
                        <td>
                            <?php if ($row['resp_texto']) {
                                echo $row['resp_texto'];
                            } elseif ($row['resp_imagem']) { ?>
                                <img src="<?php echo $row['resp_imagem']; ?>" alt="Resposta Imagem" width="100">
                            <?php } ?>
                        </td>
                        <td>
                            <?php echo $row['status_id'] == 1 ? 'Ativo' : 'Inativo'; ?>
                        </td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton<?php echo $row['id_resposta']; ?>" data-bs-toggle="dropdown" aria-expanded="false">
                                    Ações
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton<?php echo $row['id_resposta']; ?>">
                                    <?php if ($row['status_id'] == 1) { ?>
                                        <li><a class="dropdown-item" href="?id_pergunta=<?php echo $id_pergunta; ?>&desativar_id=<?php echo $row['id_resposta']; ?>">Desativar</a></li>
                                    <?php } else { ?>
                                        <li><a class="dropdown-item" href="?id_pergunta=<?php echo $id_pergunta; ?>&ativar_id=<?php echo $row['id_resposta']; ?>">Ativar</a></li>
                                    <?php } ?>
                                    <li><a class="dropdown-item" href="editar_resposta.php?id_resposta=<?php echo $row['id_resposta']; ?>">Editar</a></li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                <?php }
            } else { ?>
                <tr>
                    <td colspan="4">Nenhuma resposta cadastrada.</td>
                </tr>
            <?php } ?>
        </tbody>

    </table>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

<?php
$conn->close();
?>
