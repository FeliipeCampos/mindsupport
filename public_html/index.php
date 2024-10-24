<?php include('header.php'); ?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projeto Saúde</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa; /* Fundo claro para um visual suave */
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
            background-color: #0056b3; /* Tom mais escuro ao passar o mouse */
        }
        .container {
            max-width: 1200px; /* Limite para a largura do conteúdo */
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <h1 class="text-center mb-4">Bem-vindo ao Projeto Saúde</h1>

    <div class="row row-cols-1 row-cols-md-4 g-4"> <!-- Alterei de 3 para 4 colunas -->
        <!-- Card para criar formulários -->
        <!-- <div class="col">
            <div class="card h-100 shadow-sm">
                <div class="card-body text-center">
                    <h5 class="card-title"><i class="fas fa-edit fa-2x mb-3"></i> Criar Formulários</h5>
                    <p class="card-text">Crie formulários personalizados para capturar dados importantes.</p>
                </div>
                <div class="card-footer text-center">
                    <a href="formularios.php" class="btn btn-primary btn-block">Criar</a>
                </div>
            </div>
        </div> -->

        <!-- Card para visualizar dados -->
        <div class="col">
            <div class="card h-100 shadow-sm">
                <div class="card-body text-center">
                    <h5 class="card-title"><i class="fas fa-database fa-2x mb-3"></i> Visualizar Dados Capturados</h5>
                    <p class="card-text">Acesse e analise os dados de saúde coletados.</p>
                </div>
                <div class="card-footer text-center">
                    <a href="visualizar_dados.php" class="btn btn-primary btn-block">Visualizar</a>
                </div>
            </div>
        </div>

        <!-- Card para cadastrar doenças -->
        <!-- <div class="col">
            <div class="card h-100 shadow-sm">
                <div class="card-body text-center">
                    <h5 class="card-title"><i class="fas fa-virus fa-2x mb-3"></i> Visualizar Doenças cadastradas</h5>
                    <p class="card-text">Registre informações sobre doenças para enriquecer o banco de dados do projeto.</p>
                </div>
                <div class="card-footer text-center">
                    <a href="cadastrar_doenca.php" class="btn btn-primary btn-block">visualizar</a>
                </div>
            </div>
        </div> -->

        <!-- Novo Card para cadastrar médicos -->
        <div class="col">
            <div class="card h-100 shadow-sm">
                <div class="card-body text-center">
                    <h5 class="card-title"><i class="fas fa-user-md fa-2x mb-3"></i> visualizar Médicos</h5>
                    <p class="card-text">Cadastre informações sobre médicos para o banco de dados do projeto.</p>
                </div>
                <div class="card-footer text-center">
                    <a href="cadastrar_medico.php" class="btn btn-primary btn-block">Visualizar</a>
                </div>
            </div>
        </div>

        <!-- Novo Card para criar perguntas -->
        <div class="col">
            <div class="card h-100 shadow-sm">
                <div class="card-body text-center">
                    <h5 class="card-title"><i class="fas fa-question-circle fa-2x mb-3"></i> Criar Perguntas</h5>
                    <p class="card-text">Defina e gerencie as perguntas que serão usadas nos formulários.</p>
                </div>
                <div class="card-footer text-center">
                    <a href="criar_perguntas.php" class="btn btn-primary btn-block">Gerenciar Perguntas</a>
                </div>
            </div>
        </div>

        <!-- Novo Card para criar respostas -->
        <!-- <div class="col">
            <div class="card h-100 shadow-sm">
                <div class="card-body text-center">
                    <h5 class="card-title"><i class="fas fa-question-circle fa-2x mb-3"></i> Criar respostas</h5>
                    <p class="card-text">Defina e gerencie as respostas que serão usadas nos formulários.</p>
                </div>
                <div class="card-footer text-center">
                    <a href="criar_respostas.php" class="btn btn-primary btn-block">Gerenciar respostas</a>
                </div>
            </div>
        </div> -->

    </div>
</div>

<!-- Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
