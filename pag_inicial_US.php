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
    <link rel="stylesheet" href="estilo_paginicialUS.css">

    <title>LERÊ - HOME</title>

    <script>
        // Passando o status de login para o JavaScript (criação da variável global)
        const isUserLoggedIn = <?php echo json_encode(!is_null($nome_usuario)); ?>;
    </script>


    <script src="./pag_inicialJS.js" defer></script>
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

    <div class="home">
        <img src="./imagens/banner.png" alt="banner" id="banner">

        <h1>Nossos Procedimentos</h1>
        <div class="menu_fotos">
            <div id="Preenchimento_Facial">
                <a href="./pag_procedimentosUS.php#procePreFA">
                    <img src="./imagens/harmonização_facial.png" alt="harmonização_facial" class="espaco_foto">
                </a>
                <h3>Preenchimento <br> Facial</h3>
            </div>
            <div id="Microagulhamento_">
                <a href="./pag_procedimentosUS.php#proceMicro">
                    <img src="./imagens/microagulhamento.png" alt="microagulhamento" class="espaco_foto">
                </a>
                <h3>Microagulhamento</h3>
            </div>
            <div id="Limpeza_">
                <a href="./pag_procedimentosUS.php#proceLimpeza">
                    <img src="./imagens/limpeza.png" alt="limpeza" class="espaco_foto">
                </a>
                <h3>Limpeza</h3>
            </div>
            <div id="Led_terapia">
                <a href="./pag_procedimentosUS.php#proceLed">
                    <img src="./imagens/led_terapia.png" alt="led_terapia" class="espaco_foto">
                </a>
                <h3>Led Terapia</h3>
            </div>
        </div>
        <a href="./pag_procedimentosUS.php">
            <button>CONHEÇA TODOS OS PROCEDIMENTOS DE ESTÉTICA FACIAL ➜</button>
        </a>
    </div>
</body>

</html>