<?php
session_start();
$nome_usuario = isset($_SESSION['nome_completo']) ? $_SESSION['nome_completo'] : null;
$procedimento_escolhido = isset($_SESSION['procedimento_escolhido']) ? $_SESSION['procedimento_escolhido'] : 'Nenhum procedimento selecionado';
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./estilo.pag_agendamento_agendarUS.css">
    <title>LERÊ - AGENDAR</title>
    <script>

        document.addEventListener('DOMContentLoaded', function () {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                locale: 'pt-br'
            });
            calendar.render();
        });




    </script>
    <script src="pag_agendamento_agendarJS.js"></script>
</head>

<body>

    <div class="cabecalho1">
        <div class="logo">
            <img src="./imagens/logo.png" alt="logo" id="img_logo">
        </div>

        <?php if ($nome_usuario): ?>
            <div class="logado_ou_nao">
                <img src="./imagens/login_icon.png" alt="ícone de login" id="login_icon">
                <p id="nome_usuario">Seja bem-vindo(a), <?php echo htmlspecialchars($nome_usuario); ?>!</p>
                <div class="dropdown" id="menuDropdown">
                    <a href="./logout.php">Sair</a>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <div class="corpo">
        <h1>Escolha Uma Data</h1>
        <h3><?php echo htmlspecialchars($procedimento_escolhido); ?></h3>
        <div id='calendar'></div>

        <!-- Contêiner de horários disponíveis -->
        <div id="horarios-disponiveis-container">
            <h2>Horários Disponíveis</h2>
            <div id="horarios-disponiveis"></div>
        </div>
    </div>


    <script src="JavaScript/index.global.min.js"></script>
    <script src="JavaScript/core/locales-all.global.min.js"></script>

</body>

</html>