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

// Função para registrar atividade do usuário
function registrarAtividade($usuario_id) {
    global $conn;
    
    $sql = "INSERT INTO atividades_usuarios (usuario_id, ultima_atividade) 
            VALUES (?, NOW()) 
            ON DUPLICATE KEY UPDATE ultima_atividade = NOW()";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $usuario_id);
    $stmt->execute();
}

// Registrar atividade se o usuário estiver logado
if (isset($_SESSION['usuario_id'])) {
    registrarAtividade($_SESSION['usuario_id']);
}
?>