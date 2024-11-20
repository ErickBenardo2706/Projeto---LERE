<?php
// Iniciar a sessão
session_start();

// Verificar se as variáveis de sessão existem
$nome_usuario = isset($_SESSION['nome_completo']) ? $_SESSION['nome_completo'] : null;
$user_id = isset($_SESSION['id']) ? $_SESSION['id'] : null;

// Definir a localidade para português do Brasil
setlocale(LC_TIME, 'pt_BR.UTF-8');

// Conectar ao banco de dados e pegar os agendamentos do usuário logado
if ($user_id !== null) {
    $conn = new mysqli('localhost', 'root', '', 'lere');

    if ($conn->connect_error) {
        die("Conexão falhou: " . $conn->connect_error);
    }

    // Preparar a consulta para pegar os agendamentos do usuário logado
    $sql = "SELECT a.id, a.data_agendamento, a.hora_agendamento, p.nome AS procedimento, p.valor 
            FROM agendamentos a
            JOIN procedimentos p ON a.procedimento_id = p.id
            WHERE a.usuario_id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Criar um array de agendamentos para o usuário logado
    $agendamentos = [];
    while ($row = $result->fetch_assoc()) {
        $agendamentos[] = $row;
    }
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LERÊ - MEUS AGENDAMENTOS</title>
    <link rel="stylesheet" href="./estilo_pagmeusagendamentosUS.css">
    <script src="./meus_agendamentos.js"></script>
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
        <div id="user_id" data-id="<?php echo $user_id !== null ? htmlspecialchars($user_id) : ''; ?>"></div>

        <h1>Meus Agendamentos</h1>

        <dialog class="modal_cancelar" id="modal_cancelar">
            <h3>Você deseja cancelar esse agendamento?</h3>
            <button id="btn_nao">Não!</button>
            <button id="btn_sim">Sim!</button>
        </dialog>



        <?php if (empty($agendamentos)): ?>
            <div class="sem_agendamento">
                <img src="./imagens/sem_agendamento.png" alt="" id="img_sem_agendamento">
                <h2>Você ainda não tem nenhum agendamento!</h2>
            </div>
        <?php else: ?>
            <div class="com_agendamento">
                <?php foreach ($agendamentos as $agendamento): ?>
                    <div class="agendamento" data-id="<?php echo $agendamento['id']; ?>">
                        <h3>Agendado!</h3>

                        <?php
                        // Usando a classe DateTime para formatar a data
                        $data = new DateTime($agendamento['data_agendamento']);
                        $data_formatada = $data->format('l, d \d\e F \d\e Y'); // Exemplo: "sexta-feira, 22 de novembro de 2024"
                
                        // Alterando a primeira letra da data para maiúscula
                        $data_formatada = ucfirst($data_formatada);

                        // Tradução dos dias da semana e meses
                        $dias = [
                            'Monday' => 'Segunda-feira',
                            'Tuesday' => 'Terça-feira',
                            'Wednesday' => 'Quarta-feira',
                            'Thursday' => 'Quinta-feira',
                            'Friday' => 'Sexta-feira',
                            'Saturday' => 'Sábado',
                            'Sunday' => 'Domingo'
                        ];

                        $meses = [
                            'January' => 'Janeiro',
                            'February' => 'Fevereiro',
                            'March' => 'Março',
                            'April' => 'Abril',
                            'May' => 'Maio',
                            'June' => 'Junho',
                            'July' => 'Julho',
                            'August' => 'Agosto',
                            'September' => 'Setembro',
                            'October' => 'Outubro',
                            'November' => 'Novembro',
                            'December' => 'Dezembro'
                        ];

                        foreach ($dias as $en => $pt) {
                            $data_formatada = str_replace($en, $pt, $data_formatada);
                        }

                        foreach ($meses as $en => $pt) {
                            $data_formatada = str_replace($en, $pt, $data_formatada);
                        }
                        ?>

                        <p>Data: <strong><?php echo $data_formatada; ?></strong></p>
                        <p>Horário: <strong>
                                <?php
                                $hora = new DateTime($agendamento['hora_agendamento']);
                                echo $hora->format('H:i');
                                ?>
                            </strong></p>
                        <p>Procedimento: <strong><?php echo htmlspecialchars($agendamento['procedimento']); ?></strong></p>
                        <p>Preço: <strong>R$<?php echo number_format($agendamento['valor'], 2, ',', '.'); ?></strong></p>
                        <button class="btn_cancelar" data-id="<?php echo $agendamento['id']; ?>">Cancelar</button>
                    </div>
                <?php endforeach; ?>
            </div>

        <?php endif; ?>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const userIdElement = document.querySelector("#user_id");
            const userId = userIdElement ? userIdElement.dataset.id : null;

            if (userId) {
                console.log("ID do Usuário (para teste):", userId);
            } else {
                console.log("Nenhum ID de usuário encontrado.");
            }
        });
    </script>

</body>

</html>