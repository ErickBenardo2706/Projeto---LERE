<?php
// Conexão ao banco de dados
$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "lere";

// Cria a conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica a conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

session_start(); 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Captura os dados do formulário
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $telefone = $_POST['telefone'];
    $data_nasc = $_POST['data_nasc'];
    $possui_doenca = isset($_POST['escolha']) && $_POST['escolha'] == 'sim' ? 1 : 0; 
    $descricao_doenca = $_POST['descricao_doenca']; 

    // Insere os dados no banco
    $sql = "INSERT INTO cadastro (nome_completo, email, senha, telefone, data_nasc, possui_doenca, descricao_doenca) VALUES (?, ?, ?, ?, ?, ?, ?)";

    // Prepare a consulta
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssis", $nome, $email, $senha, $telefone, $data_nasc, $possui_doenca, $descricao_doenca);

    if ($stmt->execute()) {
        // Cadastro realizado com sucesso
        $_SESSION['nome_completo'] = $nome; 
        header("Location: pag_inicial_US.php"); // Redireciona para a página inicial
        exit();
    } else {
        echo "Erro: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close(); // Fecha a conexão com o banco de dados
?>
