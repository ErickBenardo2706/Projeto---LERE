<?php
session_start();

// Verifique se os dados foram enviados corretamente via POST
if (isset($_POST['data'], $_POST['horario'], $_POST['procedimento_id'], $_POST['preco'])) {
    $data = $_POST['data'];
    $horario = $_POST['horario'];
    $procedimento_id = $_POST['procedimento_id'];
    $preco = $_POST['preco'];

    // Agora você pode salvar esses dados no banco de dados
    // Exemplo de inserção no banco de dados (adapte conforme sua estrutura)
    include("conexao.php");

    $usuario_id = $_SESSION['usuario_id']; // Certifique-se de que o ID do usuário esteja na sessão

    $query = "INSERT INTO agendamentos (usuario_id, procedimento_id, data, horario, preco)
              VALUES ('$usuario_id', '$procedimento_id', '$data', '$horario', '$preco')";

    if (mysqli_query($conn, $query)) {
        echo "Agendamento realizado com sucesso!";
    } else {
        echo "Erro ao realizar o agendamento: " . mysqli_error($conn);
    }
}
?>