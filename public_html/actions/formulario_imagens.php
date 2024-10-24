<?php
include('connection.php'); 

$targetDir = "../imagens/";
if (!file_exists($targetDir)) {
    mkdir($targetDir, 0777, true);
}

function resizeAndSaveImage($image, $targetDir, $newWidth, $newHeight) {
    $imageExtension = strtolower(pathinfo($image['name'], PATHINFO_EXTENSION));
    $imageName = uniqid() . '.' . $imageExtension; // Gera um nome único para a imagem
    $filePath = $targetDir . $imageName;

    // Redimensiona e salva a imagem
    list($width, $height) = getimagesize($image['tmp_name']);
    $thumb = imagecreatetruecolor($newWidth, $newHeight);
    $source = imagecreatefromstring(file_get_contents($image['tmp_name']));
    imagecopyresized($thumb, $source, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
    imagejpeg($thumb, $filePath, 100);
    imagedestroy($thumb);
    imagedestroy($source);

    return $imageName; // Retorna o nome da imagem para ser salvo no banco de dados
}

// Processa o upload e redimensionamento das imagens
$uploadedImages = [];
for ($i = 1; $i <= 6; $i++) {
    if (!empty($_FILES['imagem' . $i]['name'])) {
        $uploadedImages[] = resizeAndSaveImage($_FILES['imagem' . $i], $targetDir, 500, 500);
    } else {
        $uploadedImages[] = null; // Caso nenhuma imagem seja enviada
    }
}

// Prepara a inserção no banco de dados
$sql = "INSERT INTO formularios_imagens (titulo, imagem1, imagem2, imagem3, imagem4, imagem5, imagem6) VALUES (?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssssss", $_POST['titulo'], $uploadedImages[0], $uploadedImages[1], $uploadedImages[2], $uploadedImages[3], $uploadedImages[4], $uploadedImages[5]);

// Executa a inserção
if ($stmt->execute()) {
    echo "Formulário de imagens criado com sucesso.";
} else {
    echo "Erro ao criar o formulário de imagens: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
