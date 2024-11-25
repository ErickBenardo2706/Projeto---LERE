<?php
session_start();
$nome_usuario = isset($_SESSION['nome_completo']) ? $_SESSION['nome_completo'] : null;
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="estilo_agendamento_procedimentoUS.css">
    <title>LERÊ - AGENDAR</title>
    <script>
        // Função para definir o ID do procedimento na sessão
        function setProcedimentoId(id) {
            // Armazenando o ID na sessão
            sessionStorage.setItem('procedimento_id', id);
            console.log("ID do Procedimento Selecionado: " + id);
        }
    </script>
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
        <h1>Escolha Um Procedimento</h1>

        <!-- Formulário para enviar o procedimento -->
        <form action="salvar_procedimento.php" method="POST">
            <div class="menu">
                <div class="input_radio" onclick="setProcedimentoId(1)" id="procedimento_id" data-id="1">
                    <input type="radio" name="procedimento" id="input_ledterapia" value="Led Terapia" required>
                    <label for="input_ledterapia">Led Terapia</label>
                    <label for="input_ledterapia" class="preco">R$ 200</label>
                </div>

                <div class="input_radio" onclick="setProcedimentoId(2)" id="procedimento_id" data-id="2">
                    <input type="radio" name="procedimento" id="input_limpezadepele" value="Limpeza De Pele">
                    <label for="input_limpezadepele">Limpeza De Pele</label>
                    <label for="input_limpezadepele" class="preco">R$ 275</label>
                </div>

                <div class="input_radio" onclick="setProcedimentoId(3)" id="procedimento_id" data-id="3">
                    <input type="radio" name="procedimento" id="input_microagulhamento" value="Microagulhamento">
                    <label for="input_microagulhamento">Microagulhamento</label>
                    <label for="input_microagulhamento" class="preco">R$ 550</label>

                </div>

                <div class="input_radio" onclick="setProcedimentoId(4)" id="procedimento_id" data-id="4">
                    <input type="radio" name="procedimento" id="input_preenchimentofacial" value="Preenchimento Facial">
                    <label for="input_preenchimentofacial">Preenchimento Facial</label>
                    <label for="input_preenchimentofacial" class="preco">R$ 2.000</label>

                </div>

                <div class="input_radio" onclick="setProcedimentoId(5)" id="procedimento_id" data-id="5">
                    <input type="radio" name="procedimento" id="input_preenchimentolabial" value="Preenchimento Labial">
                    <label for="input_preenchimentolabial">Preenchimento Labial</label>
                    <label for="input_preenchimentolabial" class="preco">R$ 1.650</label>

                </div>
            </div>
            <!-- Botão que envia o formulário -->
            <button type="submit" id="button_proximo">Próximo</button>
        </form>
    </div>

</body>

</html>