<?php
session_start();
include 'conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    
    // Buscar usuário pelo email
    $sql = "SELECT id, nome, senha FROM usuarios WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows == 1) {
        $stmt->bind_result($id, $nome, $senha_hash);
        $stmt->fetch();
        
        // Verificar senha
        if (password_verify($senha, $senha_hash)) {
            $_SESSION['usuario_id'] = $id;
            $_SESSION['usuario_nome'] = $nome;
            header("Location: dashboard.php"); // Redirecionar para página após login
            exit();
        } else {
            $erro = "Senha incorreta!";
        }
    } else {
        $erro = "Email não encontrado!";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="/assets/styles/login.css">
</head>
<body>
    <div class="container">  
        <a id="phpLogo" href="/index.html"><img src="../img/logo.svg" alt=""></a>
        <?php if (isset($erro)): ?>
            <div style="color: red;"><?php echo $erro; ?></div>
        <?php endif; ?>
        
        <p id="create-acc-a">Não tem uma conta? <a href="cadastro.php">Crie uma</a></p>
        <form class="form-login" method="POST" action="">
            <div class="emailbox">
                <label></label>
                <input id="emailbox" placeholder="Email" type="email" name="email" required>
            </div>
            
            <div class="passwordbox">
                <label></label>
                <input id="passwordbox" placeholder="Senha" type="password" name="senha" required>
            </div>
            
            <button id="btnEntrar" type="submit">Entrar</button>
        </form>
        
        <!-- <p><a href="#">Esqueceu sua senha? Clique aqui</a></p> -->
        
        
    </div>
</body>
</html>