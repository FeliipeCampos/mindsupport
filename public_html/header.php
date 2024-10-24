<?php include('actions/session.php'); ?>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <a class="navbar-brand" href="index.php">Projeto Saúde</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Início</a>
                </li>
                <!-- <li class="nav-item">
                    <a class="nav-link" href="formularios.php">Formulários</a>
                </li> -->
                <li class="nav-item">
                    <a class="nav-link" href="visualizar_dados.php">Visualizar Dados</a>
                </li>
                <!-- <li class="nav-item">
                    <a class="nav-link" href="cadastrar_doenca.php">Cadastrar Doença</a>
                </li> -->
                <li class="nav-item">
                    <a class="nav-link" href="register.php">Registrar</a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <?php echo isset($_SESSION['usuario_nome']) ? htmlspecialchars($_SESSION['usuario_nome']) : 'Usuário'; ?>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="actions/logout.php">Sair</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>