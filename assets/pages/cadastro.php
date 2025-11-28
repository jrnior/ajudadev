<?php
include 'conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);
    
    // Verificar se email já existe
    $sql_verifica = "SELECT id FROM usuarios WHERE email = ?";
    $stmt = $conn->prepare($sql_verifica);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows > 0) {
        $erro = "Este email já está cadastrado!";
    } else {
        // Inserir novo usuário
        $sql_inserir = "INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql_inserir);
        $stmt->bind_param("sss", $nome, $email, $senha);
        
        if ($stmt->execute()) {
            $sucesso = "Cadastro realizado com sucesso!";
        } else {
            $erro = "Erro ao cadastrar: " . $conn->error;
        }
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro</title>
    <link rel="stylesheet" href="/assets/styles/cadastro.css">
</head>
<body>
    <div class="paginacadastro">

        <div class="container">
            
            <!-- <h2>Cadastro</h2> -->
            <a id="phpLogo" href="/index.html"><img src="../img/logo.svg" alt=""></a>
            <?php if (isset($sucesso)): ?>
                <div style="color: green;"><?php echo $sucesso; ?></div>
            <?php endif; ?>
            
            <?php if (isset($erro)): ?>
                <div style="color: red;"><?php echo $erro; ?></div>
            <?php endif; ?>
    
            <div class="cadastro">
                
                <p id="p-cadastro1">Já tem uma conta? <a href="login.php">Clique aqui</a></p>
    
                <form class="formcadastro" method="POST" action="">
                    <div>
                        <label></label>
                        <input id="nomecadastro" placeholder="Nome" type="text" name="nome" required>
                    </div>
                    
                    <div>
                        <label></label>
                        <input id="emailcadastro" placeholder="Email" type="email" name="email" required>
                    </div>
                    
                    <div>
                        <label></label>
                        <input id="senhacadastro" placeholder="Senha" type="password" name="senha" required>
                    </div>
                    
                    <button type="submit">Criar conta</button>
                </form>
                
                
                
                <!-- <p><a href="#">Não estou conseguindo me cadastrar</a></p> -->
            </div>
    </div>
    </div>
</body>
</html>