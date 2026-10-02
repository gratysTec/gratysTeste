# IFolha - Arquitetura MVC (PHP + MySQL + XAMPP)

Jornal digital acadêmico do **IFMT Campus Cáceres Professor Olegário Baldo**, desenvolvido por **GRATYS TECH**.

---

## 🏛️ Estrutura da Arquitetura MVC

O projeto foi estruturado seguindo o padrão **MVC (Model-View-Controller)** com **Front Controller** e rotas amigáveis:

```text
projeto-integrador-sophia/
├── README.md                       # Documentação do projeto para XAMPP
├── database/                       # Scripts e sementes do Banco de Dados
│   ├── bdifolha.sql                # Estrutura do banco de dados (DDL)
│   └── bdnoticias.sql              # Dados iniciais e sementes (DML)
└── IFolha/                         # Aplicação Web
    ├── .htaccess                   # Regras de reescrita de URL amigável (mod_rewrite)
    ├── index.php                   # Front Controller Único e definição de Rotas
    ├── assets/                     # Recursos estáticos
    │   └── css/
    │       └── style.css           # Estilização visual temática retrô
    │
    └── app/
        ├── bootstrap.php           # Sessão e autoloader PSR-4 para App\...
        │
        ├── Core/                   # Núcleo da arquitetura MVC
        │   ├── Database.php        # Conexão PDO Singleton configurada para XAMPP
        │   ├── Model.php           # Modelo base que fornece conexão PDO às entidades
        │   ├── Controller.php      # Controller base com métodos render(), json() e redirect()
        │   └── Router.php          # Motor de rotas com regex e suporte a parâmetros na URL
        │
        ├── Controllers/            # Controladores da aplicação
        │   ├── HomeController.php  # Página inicial e destaques
        │   ├── PostController.php  # Notícias, eventos, palestras, editais, detalhes e curtidas
        │   ├── RegrasController.php# Guia de regras do estudante
        │   ├── AuthController.php  # Autenticação de usuários (login/logout com sessão)
        │   └── AdminController.php # Painel administrativo e CRUD de publicações
        │
        ├── Models/                 # Camada de dados e regras de negócio
        │   ├── Post.php            # Consultas de posts, contagem de views, curtidas e categorias
        │   ├── Categoria.php       # Gerenciamento de categorias
        │   └── Usuario.php         # Busca e autenticação de usuários
        │
        └── Views/                  # Camada de apresentação (HTML/PHP)
            ├── layouts/
            │   ├── main.php        # Layout base composto
            │   ├── header.php      # Cabeçalho decorado com navegação ativa
            │   └── footer.php      # Rodapé com equipe e script de curtidas
            ├── home/
            │   └── index.php       # Tela inicial com mural de atalhos e feed de notícias
            ├── posts/
            │   ├── index.php       # Listagem por categoria (Notícias, Eventos, Palestras, Editais)
            │   └── show.php        # Visualização detalhada da publicação
            ├── regras/
            │   └── index.php       # Guia completo de direitos, deveres e regras acadêmicas
            ├── admin/
            │   ├── index.php       # Tabela de gerenciamento do CRUD
            │   ├── create.php      # Formulário de criação de publicação
            │   └── edit.php        # Formulário de edição de publicação
            └── errors/
                └── 404.php         # Página de erro 404 estilizada
```

---

## 🚦 Tabela de Rotas

| Método | Rota | Controller | Ação | Descrição |
| :--- | :--- | :--- | :--- | :--- |
| `GET` | `/` ou `/home` | `HomeController` | `index` | Página inicial do jornal |
| `GET` | `/noticias` | `PostController` | `noticias` | Listagem da categoria Notícias |
| `GET` | `/eventos` | `PostController` | `eventos` | Listagem da categoria Eventos |
| `GET` | `/palestras` | `PostController` | `palestras` | Listagem da categoria Palestras |
| `GET` | `/editais` | `PostController` | `editais` | Listagem da categoria Editais |
| `GET` | `/post/{id}` | `PostController` | `show` | Exibição de post com incremento de visualização |
| `POST`| `/curtir/{id}` | `PostController` | `curtir` | Alterna curtida no post via AJAX |
| `GET` | `/regras` | `RegrasController` | `index` | Guia de regras do estudante |
| `POST`| `/login` | `AuthController` | `login` | Login com a tabela `usuarios` |
| `GET` | `/logout` | `AuthController` | `logout` | Encerra a sessão |
| `GET` | `/admin` | `AdminController` | `index` | Listagem e gerenciamento de publicações (CRUD) |
| `GET` | `/admin/posts/novo` | `AdminController` | `create` | Formulário para criar nova publicação |
| `POST`| `/admin/posts/novo` | `AdminController` | `store` | Salva nova publicação no banco |
| `GET` | `/admin/posts/editar/{id}` | `AdminController` | `edit` | Formulário de edição da publicação |
| `POST`| `/admin/posts/editar/{id}` | `AdminController` | `update` | Atualiza publicação existente no banco |
| `POST`| `/admin/posts/excluir/{id}` | `AdminController` | `delete` | Remove publicação do sistema |

---

## 🚀 Como Executar no XAMPP

### 1. Pré-requisitos
- **XAMPP** instalado (PHP 8.1+, Apache e MySQL): [https://www.apachefriends.org/](https://www.apachefriends.org/)

### 2. Copiar os Arquivos para a pasta `htdocs`
Localize a pasta `htdocs` da sua instalação do XAMPP:
- **Windows:** `C:\xampp\htdocs\`

Copie a pasta `IFolha` ou o repositório completo para dentro de `htdocs`.

### 3. Iniciar os Serviços no XAMPP
No painel de controle do XAMPP, inicie:
- **Apache**
- **MySQL**

### 4. Importar o Banco de Dados no phpMyAdmin
1. Acesse no navegador: [http://localhost/phpmyadmin](http://localhost/phpmyadmin)
2. Crie uma nova base de dados chamada **`ifolha`** com agrupamento `utf8mb4_unicode_ci`.
3. Selecione a base `ifolha` e clique na aba **Importar**:
   - Selecione o arquivo `database/bdifolha.sql` e execute.
4. Repita a importação na base `ifolha` selecionando o arquivo `database/bdnoticias.sql` e execute para carregar os registros iniciais e o usuário administrador.

### 5. Ativar `mod_rewrite` no Apache (se necessário)
Caso receba erro 404 ao navegar entre as páginas:
1. No painel do XAMPP, em **Apache**, clique em **Config** > **httpd.conf**.
2. Certifique-se de que a linha `LoadModule rewrite_module modules/mod_rewrite.so` não esteja comentada com `#`.
3. Certifique-se de que a diretiva `<Directory ...>` da pasta htdocs contenha `AllowOverride All`.
4. Reinicie o Apache.

---

## 🗄️ Credenciais Padrão do XAMPP

| Parâmetro | Valor Padrão |
| :--- | :--- |
| **Host** | `localhost` |
| **Porta** | `3306` |
| **Banco de Dados** | `ifolha` |
| **Usuário** | `root` |
| **Senha** | *(em branco / vazio)* |

---

## 🔑 Acesso ao Painel Administrativo

- **E-mail:** `redacao@ifmt.edu.br`
- **Senha:** `123456`
- **URL Direta:** [http://localhost/IFolha/admin](http://localhost/IFolha/admin) *(ou [http://localhost/projeto-integrador-sophia/IFolha/admin](http://localhost/projeto-integrador-sophia/IFolha/admin))*

---
