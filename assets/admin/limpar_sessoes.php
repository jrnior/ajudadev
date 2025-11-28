<?php
session_start();
include '../pages/conexao.php';

// Verificar se está logado
// Verificar se está logado como ADMIN
if (!isset($_SESSION['admin_logado']) || $_SESSION['admin_logado'] !== true) {
    header("Location: admin_login.php");
    exit();
}

// Mensagem de sucesso (não há mais tabela para limpar, mas mantemos a função)
$_SESSION['mensagem'] = "Ação concluída com sucesso!";
header("Location: admin.php");
exit();
?>