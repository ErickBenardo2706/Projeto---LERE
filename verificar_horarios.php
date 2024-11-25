<?php
header('Content-Type: application/json');

// Conexão com o banco de dados
$conn = new mysqli("localhost", "root", "", "lere");

if ($conn->connect_error) {
    echo json_encode(["error" => "Erro de conexão ao banco de dados"]);
    exit;
}

$data = $_POST['data'] ?? null;
$procedimento_id = $_POST['procedimento_id'] ?? null;

if (!$data || !$procedimento_id) {
    echo json_encode(["error" => "Parâmetros inválidos"]);
    exit;
}

// Verifica os horários ocupados
$query = $conn->prepare("SELECT hora_agendamento FROM agendamentos WHERE data_agendamento = ? AND procedimento_id = ?");
$query->bind_param("si", $data, $procedimento_id);
$query->execute();
$result = $query->get_result();

$horarios_ocupados = [];
while ($row = $result->fetch_assoc()) {
    $horarios_ocupados[] = $row['hora_agendamento'];
}

echo json_encode(["horarios_ocupados" => $horarios_ocupados]);

$conn->close();
?>