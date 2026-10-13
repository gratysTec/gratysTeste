# GratysSite

Um projeto web estruturado com uma arquitetura MVC (Model-View-Controller) personalizada em JavaScript, focado na organização modular de rotas, visualizações e assets.

---

## 📁 Estrutura de Diretórios

A estrutura do projeto está organizada da seguinte forma:

```text
gratysSite.js/
├── .htaccess
├── app/
│   ├── Controllers/
│   ├── Core/
│   ├── Models/
│   └── Views/
│       ├── admin/
│       │   └── posts/
│       ├── auth/
│       ├── errors/
│       ├── home/
│       ├── layouts/
│       ├── posts/
│       └── regras/
└── assets/
    └── css/
```

---

## 🛠️ Descrição dos Componentes

- **`/.htaccess`**: Configurações de reescrita de URL e segurança para o servidor Apache.
- **`/app/`**: Contém o núcleo da aplicação (lógica de negócios e interface).
  - **`Controllers/`**: Gerenciam as requisições do usuário, interagem com os Models e carregam as Views.
  - **`Core/`**: Classes principais e essenciais para o funcionamento do framework/arquitetura (ex: roteamento, conexão com banco de dados).
  - **`Models/`**: Responsáveis pela manipulação de dados e regras de negócio/persistência.
  - **`Views/`**: Arquivos de interface de usuário (HTML/Templates).
    - **`admin/`**: Painel administrativo (incluindo subpastas como `posts/`).
    - **`auth/`**: Telas de autenticação (login, cadastro, etc.).
    - **`errors/`**: Páginas de erro personalizadas (ex: 404, 500).
    - **`home/`**: Página inicial do site.
    - **`layouts/`**: Estruturas de layout reutilizáveis (cabeçalhos, rodapés, wrappers).
    - **`posts/`**: Páginas e componentes voltados para a exibição e gestão de posts.
    - **`regras/`**: Páginas contendo termos, políticas ou regras da aplicação.
- **`/assets/`**: Arquivos estáticos públicos do site.
  - **`css/`**: Folhas de estilo da aplicação.

---

## 🚀 Como Executar

1. Clone o repositório ou configure a pasta no seu servidor web local (como Apache/XAMPP).
2. Certifique-se de que o mod_rewrite do Apache está ativo para que o `.htaccess` funcione corretamente.
3. Configure os parâmetros de ambiente/banco de dados no diretório `Core/` se necessário.