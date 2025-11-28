<?php
$host = "localhost";
$usuario = "root"; // usuário padrão do MySQL
$senha = ""; // senha do MySQL (vazia por padrão no XAMPP)
$banco = "sistema_login";

// Criar conexão
$conn = new mysqli($host, $usuario, $senha, $banco);

// Verificar conexão
if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}
?>