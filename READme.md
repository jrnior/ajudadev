# ajudadev

um site guia pra quem quer aprender a programar

## sobre o projeto

o ajudadev é um site que eu criei pra ajudar pessoas que querem entrar na area de programação mas não sabem por onde começar. o site tem cursos organizados por topicos (frontend, backend, IA, etc) e cada um tem materiais e conceitos basicos pra iniciantes.

basicamente é tipo um mapa pra quem ta perdido e quer aprender a codar.

## tecnologias usadas

- HTML5
- CSS3  
- JavaScript
- PHP (pro login e cadastro)
- MySQL (banco de dados)

## funcionalidades

- design responsivo pra mobile
- sistema de login e cadastro
- dashboard personalizado
- cursos organizados por area
- animações e hover effects
- navegação intuitiva

## estrutura do projeto

ajudadev/
├── index.html
├── assets/
│ ├── img/
│ │ ├── logo.svg
│ │ ├── notebook.svg
│ │ ├── d.svg
│ │ └── [outras imagens]
│ ├── js/
│ │ └── auth.js
│ ├── pages/
│ │ ├── backend.html
│ │ ├── cadastro.php
│ │ ├── conexao.php
│ │ ├── curso-de-ia.html
│ │ ├── cursos.html
│ │ ├── dashboard.php
│ │ ├── frontend.html
│ │ ├── login.php
│ │ ├── logout.php
│ │ ├── privacidade.html
│ │ ├── sobre-ia.html
│ │ └── sobre-nos.html
│ └── styles/
│ ├── backend.css
│ ├── cadastro.css
│ ├── curso-de-ia.css
│ ├── cursos.css
│ ├── dashboard.css
│ ├── frontend.css
│ ├── login.css
│ ├── privacidade.css
│ ├── sobre-nos.css
│ └── style.css
text


## como rodar o projeto

### pra rodar local:

1. instala o XAMPP ou WAMP
2. clona o repositorio na pasta `htdocs`
3. cria um banco de dados MySQL chamado `ajudadev`
4. configura as credenciais do banco no `conexao.php`
5. acessa `http://localhost/ajudadev`

### configurar o banco de dados:

no arquivo `assets/pages/conexao.php`, muda essas linhas:

```php
$host = "localhost";
$user = "seu_usuario";
$password = "sua_senha"; 
$dbname = "ajudadev";

cursos disponiveis

    IA: o que é IA, machine learning, IA generativa

    Frontend: HTML, CSS, JavaScript, responsividade

    Backend: PHP, banco de dados, APIs, segurança

o que ainda falta

    sistema de progresso nos cursos

    mais conteudos nas paginas

    sistema de comentarios

    melhorar o painel admin

    adicionar mais cursos

como contribuir

se quiser ajudar no projeto:

    faz um fork

    cria uma branch (git checkout -b feature/melhoria)

    commita as mudanças (git commit -m 'adiciona alguma coisa')

    da um push (git push origin feature/melhoria)

    abre um pull request

creditos

    fontes: Google Fonts (IBM Plex Sans)

    icones: SVG

    inspiração: sites de cursos online

contato

feito por @jrnior

se tiver alguma duvida ou sugestão, pode abrir uma issue ou me mandar mensagem no github

status: 85% completo (sistema de login funcionando, cursos basicos prontos)

licença: livre pra usar e modificar