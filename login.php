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
    // Captura e higieniza os dados do formulário
    $email = trim($_POST['email']);
    $senha = trim($_POST['senha']);

    // Prepara a consulta SQL
    $sql = "SELECT * FROM cadastro WHERE email='$email'";
    $result = $conn->query($sql);

    // Verifica se encontrou o usuário
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Verifica se a senha está correta
        if ($senha === $row['senha']) {
            $_SESSION['email'] = $email;
            $_SESSION['nome_completo'] = $row['nome_completo']; // Armazena o nome completo na sessão

            // Redireciona para a página inicial após o login
            header("Location: pag_inicial_US.php");
            exit();
        } else {
            // Redireciona para a página de login com erro de senha incorreta
            header("Location: pag_login_US.html?error=incorrect_password");
            exit();
        }
    } else {
        // Redireciona para a página de login com erro de usuário não encontrado
        header("Location: pag_login_US.html?error=user_not_found");
        exit();
    }
}

$conn->close();
?>
