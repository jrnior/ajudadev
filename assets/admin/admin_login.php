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

    <style>
   @import url('https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:ital,wght@0,100..700;1,100..700&display=swap');

* {
    margin: 0; 
    padding: 0; 
    box-sizing: border-box;
}

body {
    font-family: "IBM Plex Sans", sans-serif;
    background-color: #151414;
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    padding: 20px;
}

.adminlogin {
    background-color: #091F2C;
    padding: 40px 30px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    width: 100%;
    max-width: 400px;
    /* Removido border-radius */
}

.adminlogin h1 {
    font-size: 24px;
    color: white;
    font-weight: 400;
    text-align: center;
    margin-bottom: 30px;
}

.loginadmin-form {
    display: flex;
    flex-direction: column;
    gap: 20px;
    width: 100%;
}

#adminmail, #adminpass {
    background-color: #114559;
    color: white;
    font-family: "IBM Plex Sans", sans-serif;
    border: none;
    padding: 12px 15px;
    font-size: 16px;
    width: 100%;
    /* Removido border-radius */
}

#adminmail::placeholder,
#adminpass::placeholder {
    color: #cccccc;
}

#adminloginbtn {
    padding: 12px;
    background-color: #114559;
    color: white;
    font-family: "IBM Plex Sans", sans-serif;
    font-size: 16px;
    border: none;
    /* Removido border-radius */
    cursor: pointer;
    width: 100%;
    margin-top: 10px;
    font-weight: bold;
}

#adminloginbtn:hover {
    background-color: #256883;
}

.adminlogin p {
    color: white;
    margin-top: 20px;
    text-align: center;
}

.adminlogin p a {
    color: white;
    text-decoration: none;
}

.adminlogin p a:hover {
    text-decoration: underline;
}

/* Estilo para mensagens de erro */
.adminlogin div[style*="color: red"] {
    background-color: rgba(255, 0, 0, 0.1);
    padding: 10px;
    margin-bottom: 15px;
    text-align: center;
    width: 100%;
}

/* Responsividade */
@media (max-width: 480px) {
    body {
        padding: 15px;
    }
    
    .adminlogin {
        padding: 30px 20px;
        max-width: 350px;
    }
    
    .adminlogin h1 {
        font-size: 22px;
        margin-bottom: 25px;
    }
    
    #adminmail, #adminpass {
        padding: 10px 12px;
        font-size: 15px;
    }
    
    #adminloginbtn {
        padding: 10px;
        font-size: 15px;
    }
}

@media (max-width: 320px) {
    .adminlogin {
        padding: 25px 15px;
        max-width: 300px;
    }
    
    .adminlogin h1 {
        font-size: 20px;
        margin-bottom: 20px;
    }
    
    #adminmail, #adminpass {
        padding: 8px 10px;
        font-size: 14px;
    }
    
    #adminloginbtn {
        padding: 8px;
        font-size: 14px;
    }
}
    </style>
</head>

<body>
    <div class="adminlogin">

        <div class="container">
            <h1>Login de Admin</h1>
            <!-- <p>Acesso restrito aos administradores do sistema</p> -->
    
            <?php if (!empty($erro)): ?>
                <div style="color: red; margin: 10px 0;"><?php echo $erro; ?></div>
            <?php endif; ?>
    
            <form class="loginadmin-form" method="POST" action="">
                <div>
                    <!-- <label>Email:</label><br> -->
                    <input id="adminmail" placeholder="Email" type="email" name="email" required>
                </div>
    
                <div>
                    <!-- <label>Senha:</label><br> -->
                    <input id="adminpass" placeholder="Senha" type="password" name="senha" required>
                </div>
    
                <button id="adminloginbtn" type="submit">Entrar como Admin</button>
            </form>
    
            <p><a href="../pages/dashboard.php">Voltar ao Dashboard</a></p>
        </div>
    </div>
</body>

</html>