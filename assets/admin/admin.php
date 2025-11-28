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
    color: white;
    line-height: 1.6;
}

/* Container Principal */
.admin-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 40px 20px;
}

/* Header do Admin */
.admin-header {
    background-color: #091F2C;
    padding: 30px;
    margin-bottom: 30px;
}

.admin-header h1 {
    font-size: 32px;
    font-weight: bold;
    color: white;
    margin-bottom: 15px;
}

.admin-info {
    color: #ffffffff;
    font-size: 16px;
}

.admin-info a {
    color: #ffffffff;
    text-decoration: none;
}

.admin-info a:hover {
    text-decoration: underline;
}

/* Estatísticas */
.admin-stats {
    background-color: #091F2C;
    padding: 30px;
    margin-bottom: 30px;
}

.admin-stats h2 {
    font-size: 24px;
    font-weight: bold;
    color: white;
    margin-bottom: 20px;
}

.stats-content {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 15px;
}

.stat-item {
    background-color: #114559;
    padding: 15px;
    color: white;
}

.stat-item strong {
    display: block;
    margin-bottom: 5px;
}

/* Lista de Usuários */
.users-section {
    background-color: #091F2C;
    padding: 30px;
    margin-bottom: 30px;
}

.users-section h2 {
    font-size: 24px;
    font-weight: bold;
    color: white;
    margin-bottom: 20px;
}

.users-table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 20px;
}

.users-table th {
    background-color: #114559;
    padding: 15px;
    text-align: left;
    font-weight: bold;
    color: white;
    border: 1px solid #0d2e3d;
}

.users-table td {
    padding: 15px;
    background-color: #114559;
    color: white;
    border: 1px solid #0d2e3d;
}

.users-total {
    background-color: #114559;
    padding: 15px;
    color: white;
    font-weight: bold;
}

/* Ações do Admin */
.admin-actions {
    background-color: #091F2C;
    padding: 30px;
}

.admin-actions h2 {
    font-size: 24px;
    font-weight: bold;
    color: white;
    margin-bottom: 20px;
}

.actions-grid {
    display: flex;
    gap: 15px;
    flex-wrap: wrap;
}

.actions-grid button {
    background-color: #114559;
    color: white;
    border: none;
    padding: 12px 20px;
    font-family: "IBM Plex Sans", sans-serif;
    font-size: 16px;
    cursor: pointer;
    font-weight: 500;
}

.actions-grid button:hover {
    background-color: #367B99;
}

.actions-grid a {
    text-decoration: none;
}

.btn-dashboard {
    background-color: #114559;
    color: white;
    border: none;
    padding: 12px 20px;
    font-family: "IBM Plex Sans", sans-serif;
    font-size: 16px;
    cursor: pointer;
    text-decoration: none;
    display: inline-block;
}

.btn-dashboard:hover {
    background-color: #367B99;
}

/* Responsividade */
@media (max-width: 768px) {
    .admin-container {
        padding: 20px 15px;
    }
    
    .admin-header,
    .admin-stats,
    .users-section,
    .admin-actions {
        padding: 20px;
    }
    
    .stats-content {
        grid-template-columns: 1fr;
    }
    
    .users-table {
        display: block;
        overflow-x: auto;
    }
    
    .actions-grid {
        flex-direction: column;
    }
    
    .actions-grid button,
    .btn-dashboard {
        width: 100%;
        text-align: center;
    }
}

@media (max-width: 480px) {
    .admin-header h1 {
        font-size: 28px;
    }
    
    .admin-stats h2,
    .users-section h2,
    .admin-actions h2 {
        font-size: 22px;
    }
    
    .users-table th,
    .users-table td {
        padding: 10px;
        font-size: 14px;
    }
}
    </style>
</head>
<body>
    <div class="admin-container">
        <!-- Header do Admin -->
        <div class="admin-header">
            <h1>Painel de Admin - ajudadev</h1>
            <div class="admin-info">
                Logado como: <strong>Junior Gomes</strong> | 
                <a href="admin_logout.php">Sair do Admin</a>
            </div>
        </div>

        <!-- Estatísticas -->
        <div class="admin-stats">
            <h2>Estatísticas do Sistema</h2>
            <div class="stats-content">
                <div class="stat-item">
                    <strong>Total de Usuários:</strong> 3
                </div>
                <div class="stat-item">
                    <strong>Usuários Online:</strong> 0
                </div>
                <div class="stat-item">
                    <strong>Primeiro Cadastro:</strong> 27/11/2025 23:39
                </div>
                <div class="stat-item">
                    <strong>Último Cadastro:</strong> 28/11/2025 13:04
                </div>
            </div>
        </div>

        <!-- Lista de Usuários -->
        <div class="users-section">
            <h2>Lista de Usuários Cadastrados</h2>
            
            <table class="users-table">
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
                    <tr>
                        <td>1</td>
                        <td>Junior</td>
                        <td>juniorgomes1@email.com</td>
                        <td>28/11/2025 13:04</td>
                        <td>👤 Usuário</td>
                        <td>⚫ Offline</td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Junior Gomes</td>
                        <td>juniorgomes@gmail.com</td>
                        <td>28/11/2025 00:46</td>
                        <td>👑 Admin</td>
                        <td>⚫ Offline</td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>Junior</td>
                        <td>junior@gmail.com</td>
                        <td>27/11/2025 23:39</td>
                        <td>👤 Usuário</td>
                        <td>⚫ Offline</td>
                    </tr>
                </tbody>
            </table>
            
            <div class="users-total">
                Total: 3 usuário(s)
            </div>
        </div>

        <!-- Ações do Admin -->
        <div class="admin-actions">
            <h2>Ações Administrativas</h2>
            <div class="actions-grid">
                <button onclick="exportarUsuarios()">Exportar Usuários (CSV)</button>
                <button onclick="tornarAdmin()">Tornar Usuário como Admin</button>
                <a href="../pages/dashboard.php" class="btn-dashboard">Voltar ao Dashboard</a>
            </div>
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
    </script>
</body>
</html>