<?php
session_start();
require_once 'conexao.php'; // Certifique-se de que a conexão está correta

// Verificar se os dados necessários foram enviados
if (isset($_POST['procedimento_id'], $_POST['data'], $_POST['hora'])) {
    $procedimento_id = $_POST['procedimento_id'];
    $data = $_POST['data'];
    $hora = $_POST['hora'];
    $usuario_id = $_SESSION['usuario_id'];  // Capturar o ID do usuário da sessão

    // Verificar se o horário já está ocupado para a data
    $sql_check = "SELECT * FROM agendamentos WHERE data = ? AND hora = ?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param("ss", $data, $hora);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();

    if ($result_check->num_rows > 0) {
        echo "Horário já ocupado! Escolha outro horário.";
    } else {
        // Inserir o agendamento no banco de dados
        $sql = "INSERT INTO agendamentos (usuario_id, procedimento_id, data, hora) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iiss", $usuario_id, $procedimento_id, $data, $hora);

        if ($stmt->execute()) {
            echo "Agendamento realizado com sucesso!";
        } else {
            echo "Erro ao agendar, tente novamente.";
        }
    }
} else {
    echo "Dados não fornecidos corretamente.";
}
?>