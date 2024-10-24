<?php
include('connection.php');

$targetDir = "../imagens/";
if (!file_exists($targetDir)) {
    mkdir($targetDir, 0777, true);
}

function resizeAndSaveImage($image, $targetDir, $newWidth, $newHeight) {
    $imageExtension = strtolower(pathinfo($image['name'], PATHINFO_EXTENSION));
    $imageName = uniqid() . '.' . $imageExtension; // Gera um nome único para a nova imagem
    $filePath = $targetDir . $imageName;

    list($width, $height) = getimagesize($image['tmp_name']);
    $thumb = imagecreatetruecolor($newWidth, $newHeight);
    $source = imagecreatefromstring(file_get_contents($image['tmp_name']));
    imagecopyresized($thumb, $source, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
    imagejpeg($thumb, $filePath, 100);
    imagedestroy($thumb);
    imagedestroy($source);

    return $imageName; // Retorna o nome da nova imagem
}

$id = $_POST['id'];

// Busca os dados do formulário incluindo as imagens
$sql = "SELECT imagem1, imagem2, imagem3, imagem4, imagem5, imagem6 FROM formularios_imagens WHERE id = $id";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

$uploadedImages = [];
for ($i = 1; $i <= 6; $i++) {
    if (!empty($_FILES['imagem' . $i]['name'])) {
        // Se uma nova imagem foi enviada, sobrescreve a anterior
        $uploadedImages['imagem' . $i] = resizeAndSaveImage($_FILES['imagem' . $i], $targetDir, 500, 500);
    } else {
        // Caso nenhuma nova imagem seja enviada, mantém a imagem existente
        $uploadedImages['imagem' . $i] = $row['imagem' . $i];
    }
}

// Atualiza o banco de dados com os novos nomes de imagens
$sql = "UPDATE formularios_imagens SET titulo = '{$_POST['titulo']}', imagem1 = '{$uploadedImages['imagem1']}', imagem2 = '{$uploadedImages['imagem2']}', imagem3 = '{$uploadedImages['imagem3']}', imagem4 = '{$uploadedImages['imagem4']}', imagem5 = '{$uploadedImages['imagem5']}', imagem6 = '{$uploadedImages['imagem6']}' WHERE id = $id";

if ($conn->query($sql) === TRUE) {
    // Redireciona de volta para a página de edição após a atualização bem-sucedida
    header("Location: ../formulario_imagens_editar.php?id=" . $id);
    exit;
} else {
    echo "Erro ao atualizar o formulário de imagens: " . $conn->error;
}

$conn->close();
?>
