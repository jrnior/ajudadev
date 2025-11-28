<?php
session_start();
include '../pages/conexao.php';

// Verificar se está logado como ADMIN
if (!isset($_SESSION['admin_logado']) || $_SESSION['admin_logado'] !== true) {
    header("Location: admin_login.php");
    exit();
}

// Buscar estatísticas do sistema
$sql_estatisticas = "
    SELECT 
        COUNT(*) as total_usuarios,
        MAX(data_criacao) as ultimo_cadastro,
        MIN(data_criacao) as primeiro_cadastro
    FROM usuarios
";
$result_estatisticas = $conn->query($sql_estatisticas);
$estatisticas = $result_estatisticas->fetch_assoc();

// Buscar todos os usuários
$sql_usuarios = "SELECT id, nome, email, data_criacao, is_admin FROM usuarios ORDER BY data_criacao DESC";
$result_usuarios = $conn->query($sql_usuarios);

// Buscar usuários online
$tempo_online = date('Y-m-d H:i:s', strtotime('-15 minutes'));
$sql_online = "
    SELECT COUNT(*) as usuarios_online 
    FROM usuarios 
    WHERE data_criacao > '$tempo_online'
";
$result_online = $conn->query($sql_online);
$online = $result_online->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Painel Admin - AjudaDev</title>
</head>
<body>
    <div>
        <h1>Painel Administrativo - AjudaDev</h1>
        <p>Logado como: <strong><?php echo $_SESSION['admin_nome']; ?></strong> | 
           <a href="admin_logout.php">Sair do Admin</a></p>
        
        <!-- Estatísticas Gerais -->
        <div>
            <h2>Estatísticas do Sistema</h2>
            <p><strong>Total de Usuários:</strong> <?php echo $estatisticas['total_usuarios']; ?></p>
            <p><strong>Usuários Online:</strong> <?php echo $online['usuarios_online']; ?></p>
            <p><strong>Primeiro Cadastro:</strong> <?php echo date('d/m/Y H:i', strtotime($estatisticas['primeiro_cadastro'])); ?></p>
            <p><strong>Último Cadastro:</strong> <?php echo date('d/m/Y H:i', strtotime($estatisticas['ultimo_cadastro'])); ?></p>
        </div>

        <!-- Lista de Usuários -->
        <div>
            <h2>Lista de Usuários Cadastrados</h2>
            
            <table border="1" cellpadding="8" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>Data de Cadastro</th>
                        <th>Tipo</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($usuario = $result_usuarios->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $usuario['id']; ?></td>
                        <td><?php echo htmlspecialchars($usuario['nome']); ?></td>
                        <td><?php echo htmlspecialchars($usuario['email']); ?></td>
                        <td><?php echo date('d/m/Y H:i', strtotime($usuario['data_criacao'])); ?></td>
                        <td><?php echo $usuario['is_admin'] == 1 ? '👑 Admin' : '👤 Usuário'; ?></td>
                        <td>
                            <?php 
                            $tempo_usuario = strtotime($usuario['data_criacao']);
                            $tempo_limite = strtotime('-15 minutes');
                            echo ($tempo_usuario > $tempo_limite) ? '🟢 Online' : '⚫ Offline'; 
                            ?>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
            
            <p><strong>Total:</strong> <?php echo $result_usuarios->num_rows; ?> usuário(s)</p>
        </div>

        <!-- Ações do Admin -->
        <div>
            <h2>Ações Administrativas</h2>
            <button onclick="exportarUsuarios()">Exportar Usuários (CSV)</button>
            <button onclick="tornarAdmin()">Tornar Usuário como Admin</button>
            <a href="../pages/dashboard.php">
                <button>Voltar ao Dashboard</button>
            </a>
        </div>
    </div>

    <script>
    function exportarUsuarios() {
        window.location.href = 'exportar_usuarios.php';
    }
    
    function tornarAdmin() {
        const userId = prompt('Digite o ID do usuário para torná-lo admin:');
        if (userId) {
            window.location.href = 'tornar_admin.php?id=' + userId;
        }
    }
    
    // Atualizar estatísticas a cada 30 segundos
    setInterval(() => {
        location.reload();
    }, 30000);
    </script>
</body>
</html>