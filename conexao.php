<?php
$conn = new mysqli('localhost', 'root', '', 'lere');

// Verificar conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}
?>