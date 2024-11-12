<?php
include('conexao.php');

$data = $_POST['data'];  // Data selecionada
$hora = "08:00"; // Exemplo de hora; você pode modificar conforme a lógica de horas permitidas

$query = "INSERT INTO agendamentos (usuario_id, procedimento_id, data_agendamento, hora_agendamento) VALUES (1, 1, '$data', '$hora')";
mysqli_query($con, $query);

echo "Agendamento realizado com sucesso!";
?>