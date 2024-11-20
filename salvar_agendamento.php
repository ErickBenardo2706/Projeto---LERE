<?php
// Conexão com o banco de dados
require 'conexao.php';

// Obtém os dados enviados via POST
$usuario_id = $_POST['usuario_id'];
$procedimento_id = $_POST['procedimento_id'];
$data_agendamento = $_POST['data_agendamento'];
$hora_agendamento = $_POST['hora_agendamento'];

// Prepara e executa a consulta para inserir os dados na tabela agendamentos
$query = "INSERT INTO agendamentos (usuario_id, procedimento_id, data_agendamento, hora_agendamento) 
          VALUES ('$usuario_id', '$procedimento_id', '$data_agendamento', '$hora_agendamento')";

if (mysqli_query($conn, $query)) {
    echo json_encode(['success' => true]);  // Retorna sucesso para o JavaScript
} else {
    echo json_encode(['success' => false, 'message' => 'Erro ao salvar no banco de dados.']);
}

// Fecha a conexão
mysqli_close($conn);
?>