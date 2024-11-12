<?php
session_start();

if (isset($_POST['procedimento'])) {
    $_SESSION['procedimento_escolhido'] = $_POST['procedimento'];
    header("Location: pag_agendamento_agendarUS.php");
    exit();
} else {
    // Se o procedimento não foi selecionado, redireciona de volta à página anterior
    header("Location: pag_escolha_procedimento.php");
    exit();
}
?>