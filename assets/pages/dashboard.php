<?php
session_start();

// Verificar se usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="/assets/styles/dashboard.css">
</head>
<body>
    <div class="dashboard">
        <a id="phpLogo" href="/index.html"><img src="../img/logo.svg" alt=""></a>
        
        <!-- LINK DO ADMIN NO CANTO SUPERIOR DIREITO -->
        <a id="adminLink" href="/assets/admin/admin_login.php">Painel Admin</a>
        
        <div class="container">
            <h2>Bem-vindo, <?php echo $_SESSION['usuario_nome']; ?>!</h2>
    
            <div class="dashboard-items">
                <a id="courses" href="/assets/pages/cursos.html">Cursos</a>
                <!-- <a id="training" href="">Treinamentos</a> -->
                <a id="logout" href="logout.php">Sair</a>
            </div>
        </div>
    </div>
</body>
</html>