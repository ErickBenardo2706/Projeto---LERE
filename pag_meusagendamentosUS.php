<?php
session_start();
$nome_usuario = isset($_SESSION['nome_completo']) ? $_SESSION['nome_completo'] : null;
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LERÊ - MEUS AGENDAMENTOS</title>
    <link rel="stylesheet" href="./estilo_pagmeusagendamentosUS.css">
</head>

<body>

    <div class="cabecalho1">
        <div class="logo">
            <img src="./imagens/logo.png" alt="logo" id="img_logo">

        </div>

        <?php if ($nome_usuario): ?>
            <div class="logado_ou_nao">
                <img src="./imagens/login_icon.png" alt="ícone de login" id="login_icon" onclick="toggleDropdown()">
                <p id="nome_usuario">Seja bem-vindo(a), <?php echo htmlspecialchars($nome_usuario); ?>!</p>
                <div class="dropdown" id="menuDropdown">
                    <a href="./logout.php">Sair</a>
                </div>
            </div>
        <?php endif; ?>
    </div>


    <div class="corpo">

        <h1>Meus Agendamentos</h1>
        <div class="sem_agendamento">
            <img src="./imagens/sem_agendamento.png" alt="" id="img_sem_agendamento">
            <h2>Você ainda não tem nenhum agendamento!</h2>
        </div>
    </div>
    </div>


</body>

</html>