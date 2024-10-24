<?php
include('header.php');
include('actions/connection.php');

// Verificar se o ID da resposta foi enviado via URL
if (isset($_GET['id_resposta'])) {
    $id_resposta = $_GET['id_resposta'];

    // Consulta a resposta específica na tabela perg_opcoes
    $sql = "SELECT * FROM perg_opcoes WHERE id_resposta = $id_resposta";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "<script>alert('Resposta não encontrada.'); window.location.href='criar_respostas.php';</script>";
        exit;
    }
} else {
    echo "<script>alert('ID da resposta não fornecido.'); window.location.href='criar_respostas.php';</script>";
    exit;
}

// Atualizar resposta
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verifica se a resposta é do tipo texto ou imagem
    $tipo = $row['resp_texto'] ? 1 : 2;

    if ($tipo == 1) {
        // Resposta do tipo texto
        $nova_resposta = $_POST['resp_texto'];

        if ($nova_resposta) {
            // Atualizar a resposta de texto no banco de dados
            $update_sql = "UPDATE perg_opcoes SET resp_texto = '$nova_resposta' WHERE id_resposta = $id_resposta";

            if ($conn->query($update_sql) === TRUE) {
                echo "<script>alert('Resposta atualizada com sucesso.'); window.location.href='criar_respostas.php';</script>";
            } else {
                echo "<script>alert('Erro ao atualizar a resposta: " . $conn->error . "');</script>";
            }
        } else {
            echo "<script>alert('Por favor, preencha o campo de resposta.');</script>";
        }
    } elseif ($tipo == 2) {
        // Resposta do tipo imagem
        if (isset($_FILES['resp_imagem']) && $_FILES['resp_imagem']['error'] === UPLOAD_ERR_OK) {
            // Obter informações da nova imagem enviada
            $imagem = $_FILES['resp_imagem'];
            $extensao = pathinfo($imagem['name'], PATHINFO_EXTENSION);
            $hash = md5(uniqid(rand(), true));
            $novo_nome_imagem = $hash . '.' . $extensao;
            $caminho_imagem = 'imagens/' . $novo_nome_imagem;

            // Move a nova imagem para o servidor
            if (move_uploaded_file($imagem['tmp_name'], $caminho_imagem)) {
                // Atualizar a imagem no banco de dados
                $update_sql = "UPDATE perg_opcoes SET resp_imagem = '$caminho_imagem' WHERE id_resposta = $id_resposta";

                if ($conn->query($update_sql) === TRUE) {
                    echo "<script>alert('Imagem atualizada com sucesso.'); window.location.href='criar_respostas.php';</script>";
                } else {
                    echo "<script>alert('Erro ao atualizar a imagem: " . $conn->error . "');</script>";
                }
            } else {
                echo "<script>alert('Erro ao mover o arquivo para o servidor.');</script>";
            }
        } else {
            echo "<script>alert('Por favor, selecione uma imagem válida.');</script>";
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Resposta</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h2 class="mb-4">Editar Resposta</h2>

    <!-- Formulário para editar a resposta -->
    <form method="POST" enctype="multipart/form-data">
        <?php if ($row['resp_texto']) { ?>
            <!-- Campo para editar resposta em texto -->
            <div class="mb-3">
                <label for="resp_texto" class="form-label">Resposta em Texto</label>
                <textarea class="form-control" id="resp_texto" name="resp_texto" rows="4" required><?= $row['resp_texto'] ?></textarea>
            </div>
        <?php } elseif ($row['resp_imagem']) { ?>
            <!-- Campo para editar resposta em imagem -->
            <div class="mb-3">
                <label for="resp_imagem" class="form-label">Imagem Atual:</label><br>
                <img src="<?= $row['resp_imagem'] ?>" alt="Resposta Imagem" width="200"><br><br>
                <label for="resp_imagem" class="form-label">Carregar Nova Imagem</label>
                <input class="form-control" type="file" id="resp_imagem" name="resp_imagem" accept="image/*">
            </div>
        <?php } ?>

        <button type="submit" class="btn btn-primary">Salvar Alterações</button>
    </form>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
