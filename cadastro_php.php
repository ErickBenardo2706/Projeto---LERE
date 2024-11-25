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

session_start();  // Inicia a sessão

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
        $usuario_id = $stmt->insert_id;  // Pega o ID do usuário recém-criado
        $_SESSION['id'] = $usuario_id; // Armazena o ID do usuário na sessão
        $_SESSION['nome_completo'] = $nome;  // Armazena o nome do usuário na sessão

        // Redireciona para a página inicial com a sessão do usuário
        header("Location: pag_inicial_US.php");
        exit();
    } else {
        echo "Erro: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close(); // Fecha a conexão com o banco de dados
?>