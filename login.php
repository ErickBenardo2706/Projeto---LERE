<?php
session_start();

// Conexão ao banco de dados
$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "lere"; 

$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica a conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // Variável para armazenar mensagens de erro
    $error = '';

    // Verifica se o email existe
    $sql = "SELECT * FROM cadastro WHERE email='$email'";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Verifica a senha diretamente
        if ($senha == $row['senha']) {
            // Login bem-sucedido
            $_SESSION['email'] = $email;
            header("Location: pag_inicial_US.html"); // Redireciona para a página inicial
            exit();
        } else {
            // Senha incorreta
            $error = 'incorrect_password';
        }
    } else {
        // Usuário não encontrado
        $error = 'user_not_found';
    }

    // Retorna o erro via URL para a página de login
    if ($error) {
        header("Location: pag_login_US.html?error=$error");
        exit();
    }
}

$conn->close();
?>
