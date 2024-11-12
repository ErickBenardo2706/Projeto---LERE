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
    <link rel="stylesheet" href="./estilo_pagsobrenosUS.css">

    <title>LERÊ - SOBRE NÓS</title>
    <script>
        // Passando o status de login para o JavaScript (criação da variável global)
        const isUserLoggedIn = <?php echo json_encode(!is_null($nome_usuario)); ?>;
    </script>
    <script src="./pag_sobrenosJS.js" defer></script>
</head>

<body>

    <div class="cabecalho1">
        <div class="logo">
            <img src="./imagens/logo.png" alt="logo" id="img_logo">
            <div class="menu">
                <ul>
                    <li><a href="./pag_inicial_US.php">INÍCIO</a></li>
                    <li><a href="#" onclick="checkLoginStatus()">AGENDAMENTO</a></li>
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

        <h2>Sobre Nós</h2>
        <p>Bem-vindo à LERÊ, a sua referência em estética facial e bem-estar! Fundada há [X] anos, <br>
            nossa missão é proporcionar uma experiência transformadora e personalizada para cada <br>
            cliente, utilizando o que há de mais avançado em técnicas e produtos de cuidados faciais.
            <br>
            <br>
            Na LERÊ, acreditamos que cada rosto é único e merece um tratamento especial. Nossa <br>
            equipe é composta por profissionais altamente qualificados e apaixonados pela arte da <br>
            estética facial, sempre atualizados com as últimas tendências e inovações do setor. <br>
            Trabalhamos com compromisso e dedicação para garantir resultados excepcionais e a <br>
            máxima satisfação de nossos clientes. <br>
            <br>
            Valorizamos profundamente o relacionamento com nossos clientes e estamos sempre à <br>
            disposição para oferecer um atendimento personalizado e atencioso. Desde o primeiro <br>
            contato, até o acompanhamento pós-tratamento, nosso objetivo é construir uma relação de <br>
            confiança e cuidar da sua beleza e bem-estar de forma completa. <br>
            <br>
            Nosso compromisso com a excelência e o carinho com que tratamos cada cliente são os <br>
            pilares que sustentam a nossa trajetória. Ao longo dos anos, temos o orgulho de ter <br>
            transformado a vida de muitas pessoas, ajudando-as a se sentir mais confiantes e <br>
            radiantes. <br>
            <br>
            Na LERÊ, você encontrará um ambiente acolhedor e inovador, onde sua satisfação é a <br>
            nossa maior recompensa. Venha nos visitar e descubra como podemos realçar sua beleza e <br>
            proporcionar momentos inesquecíveis. <br>

            <br><br>
    </div>
    </p>



    </div>


    <div class="faixada">
        <img src="./imagens/Local1.png" alt="">
        <br><br><br>
        <img src="./imagens/Local2.png" alt="">

    </div>
</body>

</html>