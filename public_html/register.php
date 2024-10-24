<?php //include('header.php'); ?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro - Projeto Saúde</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title text-center">Cadastro de Usuário</h5>
                    <form method="post" action="actions/register.php">
                        <div class="mb-3">
                            <label for="nome" class="form-label">Nome</label>
                            <input type="text" class="form-control" id="nome" name="nome" placeholder="Seu nome" required>
                        </div>
                        <div class="mb-3">
                            <label for="sobrenome" class="form-label">Sobrenome</label>
                            <input type="text" class="form-control" id="sobrenome" name="sobrenome" placeholder="Seu sobrenome" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Seu email" required>
                        </div>
                        <!-- Campo dropdown para tipo de usuário -->
                        <div class="mb-3">
                            <label for="tipo_id" class="form-label">Tipo de Usuário</label>
                            <select class="form-control" id="tipo_id" name="tipo_id" required>
                                <option value="1">Paciente</option>
                                <option value="2">Médico</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Senha</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Sua senha" required>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Cadastrar</button>
                        </div>
                    </form>
                    <div class="text-center mt-3">
                        <p class="mb-0">Já tem uma conta? <a href="login.php">Faça login</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS com Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
