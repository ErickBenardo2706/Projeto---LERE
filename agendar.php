<?php
include 'conexao.php'; // Certifique-se de incluir a conexão ao banco de dados

$user_id = $_POST['user_id'];
$procedimento_id = $_POST['procedimento_id'];
$data_agendamento = $_POST['data_agendamento'];
$hora_agendamento = $_POST['hora_agendamento'];

// Verifica se o horário está ocupado para o mesmo procedimento
$sql_verificar = "SELECT * FROM agendamentos WHERE procedimento_id = ? AND data_agendamento = ? AND hora_agendamento = ?";
$stmt = $conn->prepare($sql_verificar);
$stmt->bind_param("iss", $procedimento_id, $data_agendamento, $hora_agendamento);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Horário já ocupado para o mesmo procedimento
    echo json_encode(['success' => false, 'message' => 'Esse horário já está ocupado para o procedimento selecionado.']);
    exit;
}

// Insere o agendamento
$sql_inserir = "INSERT INTO agendamentos (usuario_id, procedimento_id, data_agendamento, hora_agendamento) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql_inserir);
$stmt->bind_param("iiss", $user_id, $procedimento_id, $data_agendamento, $hora_agendamento);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Agendamento confirmado com sucesso!']);
} else {
    echo json_encode(['success' => false, 'message' => 'Erro ao confirmar o agendamento.']);
}
?>