// assets/js/auth.js - Sistema Universal de Autenticação

class AuthManager {
    constructor() {
        this.loginBtn = document.getElementById('loginBtn');
        this.init();
    }

    // Verifica se o usuário está logado
    isLoggedIn() {
        return localStorage.getItem('userLoggedIn') === 'true';
    }

    // Obtém o nome do usuário
    getUserName() {
        return localStorage.getItem('userName') || 'Usuário';
    }

    // Atualiza o botão de login/logout
    updateLoginButton() {
        if (!this.loginBtn) return;

        if (this.isLoggedIn()) {
            this.loginBtn.textContent = 'Sair';
            this.loginBtn.href = '#';
            this.loginBtn.onclick = (e) => {
                e.preventDefault();
                this.logout();
            };
        } else {
            this.loginBtn.textContent = 'Entrar';
            this.loginBtn.href = '/assets/pages/login.php';
            this.loginBtn.onclick = null;
        }
    }

    // Faz logout
    logout() {
        if (confirm('Deseja realmente sair?')) {
            localStorage.removeItem('userLoggedIn');
            localStorage.removeItem('userName');
            localStorage.removeItem('userId');
            
            // Redireciona para a página inicial
            window.location.href = '/index.html';
        }
    }

    // Faz login (chamado pela página de login)
    login(userData) {
        localStorage.setItem('userLoggedIn', 'true');
        localStorage.setItem('userName', userData.nome);
        localStorage.setItem('userId', userData.id);
        
        this.updateLoginButton();
    }

    // Inicializa o sistema
    init() {
        this.updateLoginButton();
        
        // Verifica se há parâmetro de logout na URL
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.get('logout') === 'true') {
            this.logout();
        }
    }
}

// Inicializa quando o DOM estiver carregado
document.addEventListener('DOMContentLoaded', function() {
    window.authManager = new AuthManager();
});