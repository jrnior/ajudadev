<?php
session_start();
include '../pages/conexao.php';

// Verificar se está logado
// Verificar se está logado como ADMIN
if (!isset($_SESSION['admin_logado']) || $_SESSION['admin_logado'] !== true) {
    header("Location: admin_login.php");
    exit();
}

// Configurar headers para download CSV
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=usuarios_ajudadev.csv');

// Criar output CSV
$output = fopen('php://output', 'w');

// Cabeçalho CSV
fputcsv($output, ['ID', 'Nome', 'Email', 'Data Cadastro', 'Status'], ';');

// Buscar usuários
$sql = "SELECT id, nome, email, data_criacao FROM usuarios ORDER BY id";
$result = $conn->query($sql);

while ($usuario = $result->fetch_assoc()) {
    $status = (strtotime($usuario['data_criacao']) > strtotime('-15 minutes')) ? 'Online' : 'Offline';
    
    fputcsv($output, [
        $usuario['id'],
        $usuario['nome'],
        $usuario['email'],
        date('d/m/Y H:i', strtotime($usuario['data_criacao'])),
        $status
    ], ';');
}

fclose($output);
exit();
?>