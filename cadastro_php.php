<?php
// Conexão ao banco de dados
$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "lere";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Captura os dados do formulário
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $telefone = $_POST['telefone'];
    $data_nasc = $_POST['data_nasc'];
    $possui_doenca = isset($_POST['escolha']) && $_POST['escolha'] == 'sim' ? 1 : 0; // Convertendo para boolean
    $descricao_doenca = $_POST['descricao_doenca']; // Captura o valor do textarea

    // Insere os dados no banco
    $sql = "INSERT INTO cadastro (nome_completo, email, senha, telefone, data_nasc, possui_doenca, descricao_doenca) VALUES (?, ?, ?, ?, ?, ?, ?)";
    
    // Prepare a consulta
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssis", $nome, $email, $senha, $telefone, $data_nasc, $possui_doenca, $descricao_doenca);
    
    if ($stmt->execute()) {
        echo "Cadastro realizado com sucesso!";
        header("Location: pag_inicial_US.html");
    } else {
        echo "Erro: " . $stmt->error;
    }

    $stmt->close();
}
