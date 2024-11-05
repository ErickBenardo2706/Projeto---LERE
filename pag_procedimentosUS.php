<?php
session_start();
$nome_usuario = isset($_SESSION['nome_completo']) ? $_SESSION['nome_completo'] : null;
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LERÊ - Procedimentos</title>
    <link rel="stylesheet" href="estilo.procedimentosUS.css">
    <script src="./pag_procedimentosJS.js" defer></script>
</head>

<body>

    <div class="cabecalho1">
        <div class="logo">
            <img src="./imagens/logo.png" alt="logo" id="img_logo">
            <div class="menu">
                <ul>
                    <li><a href="./pag_inicial_US.php">INÍCIO</a></li>
                    <li><a href="">AGENDAMENTO</a></li>
                    <li><a href="./pag_contato_US.html">CONTATO</a></li>
                    <li><a href="./pag_sobrenos_US.php">SOBRE NÓS</a></li>
                    <?php if (!$nome_usuario): ?>
                        <li><a href="./pag_login_US.html">LOGIN</a></li>
                    <?php endif; ?>
                </ul>
            </div>
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
        <div id="proceLed">
            <img src="./procedimentos/ledterapia.png" alt="Led Terapia" class="procedimento-img">
        </div>
        <br><br><br>

        <div id="proceLimpeza">
            <img src="./procedimentos/limpezadepele.png" alt="Limpeza de Pele" class="procedimento-img">
        </div>
        <br><br><br>

        <div id="proceMicro">
            <img src="./procedimentos/microagulhamento.png" alt="Microagulhamento" class="procedimento-img">
        </div>
        <br><br><br>

        <div>

            <div id="procePreFA">
                <img src="./procedimentos/preenchimentoFA.png" alt="Preenchimento Facial" class="procedimento-img">
            </div>
            <br><br><br>

            <img src="./procedimentos/preenchimentoLA.png" alt="Preenchimento Labial" class="procedimento-img">

        </div>

</body>

</html>