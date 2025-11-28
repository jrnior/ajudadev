<?php
session_start();
include '../pages/conexao.php';


if (!isset($_SESSION['admin_logado']) || $_SESSION['admin_logado'] !== true) {
    header("Location: admin_login.php");
    exit();
}

if (isset($_GET['id'])) {
    $user_id = intval($_GET['id']);
    
    $sql = "UPDATE usuarios SET is_admin = 1 WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    
    if ($stmt->execute()) {
        $mensagem = "Usuário tornado admin com sucesso!";
    } else {
        $mensagem = "Erro ao tornar usuário admin: " . $conn->error;
    }
    
    header("Location: admin.php?mensagem=" . urlencode($mensagem));
    exit();
} else {
    header("Location: admin.php");
    exit();
}
?>