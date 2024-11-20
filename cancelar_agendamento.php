<?php
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['id'])) {
    http_response_code(403);
    echo json_encode(['error' => 'Usuário não autorizado.']);
    exit;
}

// Conexão com o banco de dados
$conn = new mysqli('localhost', 'root', '', 'lere');
if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(['error' => 'Erro de conexão com o banco de dados.']);
    exit;
}

// Verifica se o ID do agendamento foi enviado
$data = json_decode(file_get_contents('php://input'), true);
if (!isset($data['id'])) {
    http_response_code(400);
    echo json_encode(['error' => 'ID do agendamento não fornecido.']);
    exit;
}

$agendamentoId = $data['id'];
$userId = $_SESSION['id'];

// Exclui o agendamento do banco
$sql = "DELETE FROM agendamentos WHERE id = ? AND usuario_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $agendamentoId, $userId);

if ($stmt->execute() && $stmt->affected_rows > 0) {
    echo json_encode(['success' => 'Agendamento cancelado com sucesso.']);
} else {
    http_response_code(404);
    echo json_encode(['error' => 'Agendamento não encontrado ou já removido.']);
}

$stmt->close();
$conn->close();
?>