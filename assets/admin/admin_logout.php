<?php
session_start();

// Limpar apenas a sessão admin, mantendo a sessão normal se existir
unset($_SESSION['admin_logado']);
unset($_SESSION['admin_id']);
unset($_SESSION['admin_nome']);

// Redirecionar para o login admin
header("Location: admin_login.php");
exit();
?>