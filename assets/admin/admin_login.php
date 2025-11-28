<?php
session_start();
include '../pages/conexao.php';

// Se já estiver logado como admin, redireciona para o painel
if (isset($_SESSION['admin_logado']) && $_SESSION['admin_logado'] === true) {
    header("Location: admin.php");
    exit();
}

$erro = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    
    // Buscar usuário pelo email
    $sql = "SELECT id, nome, senha, is_admin FROM usuarios WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows == 1) {
        $stmt->bind_result($id, $nome, $senha_hash, $is_admin);
        $stmt->fetch();
        
        // Verificar senha E se é admin
        if (password_verify($senha, $senha_hash) && $is_admin == 1) {
            $_SESSION['admin_logado'] = true;
            $_SESSION['admin_id'] = $id;
            $_SESSION['admin_nome'] = $nome;
            header("Location: admin.php");
            exit();
        } else {
            $erro = "Credenciais inválidas ou usuário não é administrador!";
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
    <title>Login Admin - AjudaDev</title>
</head>
<body>
    <div>
        <h1>Login Administrativo</h1>
        <p>Acesso restrito aos administradores do sistema</p>
        
        <?php if (!empty($erro)): ?>
            <div style="color: red; margin: 10px 0;"><?php echo $erro; ?></div>
        <?php endif; ?>
        
        <form method="POST" action="">
            <div>
                <label>Email:</label><br>
                <input type="email" name="email" required>
            </div>
            
            <div>
                <label>Senha:</label><br>
                <input type="password" name="senha" required>
            </div>
            
            <button type="submit">Entrar como Admin</button>
        </form>
        
        <p><a href="../pages/dashboard.php">Voltar ao Dashboard</a></p>
    </div>
</body>
</html>