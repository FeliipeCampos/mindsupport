<?php include('header.php'); ?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Formulário - Projeto Saúde</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa; /* Fundo claro */
        }
        .card {
            transition: transform 0.2s ease, box-shadow 0.2s ease; /* Suavização ao passar o mouse */
        }
        .card:hover {
            transform: scale(1.05); /* Efeito de zoom ao passar o mouse */
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15); /* Sombra mais forte no hover */
        }
        .card-title {
            color: #007bff; /* Cor principal dos títulos */
        }
        .card-footer {
            background-color: #f8f9fa; /* Fundo claro no footer dos cards */
        }
        .btn-primary {
            background-color: #007bff; /* Cor dos botões */
            border: none;
        }
        .btn-primary:hover {
            background-color: #0056b3; /* Tom mais escuro no hover */
        }
        .container {
            max-width: 1200px; /* Limite para a largura do conteúdo */
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <h1 class="text-center mb-4">Criar Formulário</h1>
    
    <div class="row row-cols-1 row-cols-md-2 g-4">
        <!-- Card para criar formulário de texto -->
        <div class="col">
            <div class="card h-100 shadow-sm">
                <div class="card-body text-center">
                    <h5 class="card-title"><i class="fas fa-keyboard fa-2x mb-3"></i> Formulário de Texto</h5>
                    <p class="card-text">Crie formulários que permitem a entrada de texto ou veja os já cadastrados.</p>
                </div>
                <div class="card-footer text-center">
                    <a href="formulario_texto.php" class="btn btn-primary btn-block">Criar</a>
                    <a href="formulario_textos_visualizar.php" class="btn btn-primary btn-block">Ver</a>
                </div>
            </div>
        </div>

        <!-- Card para criar formulário de imagens -->
        <div class="col">
            <div class="card h-100 shadow-sm">
                <div class="card-body text-center">
                    <h5 class="card-title"><i class="fas fa-images fa-2x mb-3"></i> Formulário de Imagens</h5>
                    <p class="card-text">Crie formulários que permitam escolher entre imagens ou veja os já cadastrados.</p>
                </div>
                <div class="card-footer text-center">
                    <a href="formulario_imagens.php" class="btn btn-primary btn-block">Criar</a>
                    <a href="formulario_imagens_visualizar.php" class="btn btn-primary btn-block">Ver</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>