<?php
include 'conexao.php';

$sql = "SELECT id, nome, valor FROM procedimentos";
$result = $conn->query($sql);

$procedimentos = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $procedimentos[$row['id']] = [
            'nome' => $row['nome'],
            'valor' => $row['valor']
        ];
    }
}
?>