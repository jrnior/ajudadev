<?php
session_start();

// Limpa a sessão PHP
session_destroy();

// Redireciona para a página inicial com parâmetro de logout
header("Location: /index.html?logout=true");
exit();
?>