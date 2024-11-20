<?php
// agendar.php

// Verifique se os dados foram recebidos via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Conecte-se ao banco de dados
    $conn = new mysqli('localhost', 'root', '', 'lere'); // Ajuste conforme seu banco de dados

    if ($conn->connect_error) {
        die("Falha na conexão: " . $conn->connect_error);
    }

    // Receber os dados enviados
    $user_id = $_POST['user_id'];
    $procedimento_id = $_POST['procedimento_id'];
    $data_agendamento = $_POST['data_agendamento'];
    $hora_agendamento = $_POST['hora_agendamento'];

    // Inserir o agendamento na tabela
    $sql = "INSERT INTO agendamentos (usuario_id, procedimento_id, data_agendamento, hora_agendamento) 
            VALUES ('$user_id', '$procedimento_id', '$data_agendamento', '$hora_agendamento')";

    if ($conn->query($sql) === TRUE) {
        echo "Agendamento realizado com sucesso!";
    } else {
        echo "Erro: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>