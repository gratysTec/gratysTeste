# IFolha

Jornal digital acadêmico do IFMT Campus Cáceres, desenvolvido por **GRATYS TECH**.

Esta versão funciona na Vercel como um site estático, **sem banco de dados, PHP em produção ou variáveis de ambiente**. O visual original e os créditos da equipe foram mantidos. Um pequeno script Node.js monta o cabeçalho e o rodapé em cada página durante o build.

## Rodar no computador

Use Node.js 24 e npm:

```bash
npm ci
npm test
npm run dev
```

Abra `http://localhost:3000`. Após editar os arquivos, execute `npm run build` e atualize a página. O servidor local usa as mesmas URLs e os mesmos redirecionamentos das páginas na Vercel.

## Publicar na Vercel

Importe **gratysTec/gratysTeste** e mantenha:

| Configuração | Valor |
| --- | --- |
| Framework Preset | Other |
| Root Directory | raiz do repositório (`.`) |
| Install Command | `npm ci --ignore-scripts --no-audit --no-fund` |
| Build Command | `npm run build` |
| Output Directory | `dist` |
| Node.js | 24.x |
| Production Branch | `main` |
| Environment Variables | nenhuma |

O arquivo `vercel.json` já define os comandos e a pasta de saída. Depois da importação, cada atualização da branch de produção gera uma nova publicação. Não execute outro deploy manual se a integração com GitHub já iniciou um.

Se uma publicação depender de autorização por conta do colaborador, o proprietário do projeto deve aprová-la no painel da Vercel. Permissão de escrita no GitHub e acesso à equipe da Vercel são permissões diferentes.

O repositório estava conectado a dois projetos Vercel (`gratys-teste` e `gratystec`). Um mesmo push pode publicar nos dois. O proprietário pode desconectar a integração Git do projeto que não será utilizado para evitar builds duplicados.

## O que funciona agora

- Início, notícias, eventos, palestras, editais e regras, com navegação e página 404.
- Links antigos `.php` redirecionam para as novas páginas.
- Acesso ao **SUAP oficial** em outra aba. O IFolha não recebe e-mail ou senha.
- Curtida da página inicial salva somente no navegador do visitante; não é uma contagem pública. Se o armazenamento estiver bloqueado, funciona durante a página atual.
- Conteúdo público disponível mesmo sem JavaScript. A curtida e a busca são melhorias opcionais.
- Busca de publicações por texto, ignorando acentos, nas seções que tiverem conteúdo.
- Seções sem publicações mostram um estado vazio e acesso ao portal oficial. Não há notícias, eventos ou editais inventados.

## Como publicar conteúdo sem banco

Edite `content/posts.json`, que começa como uma lista vazia (`[]`). Acrescente um objeto para cada publicação, revise as informações e envie uma única atualização para o GitHub.

Modelo de preenchimento (substitua pelo conteúdo real antes de publicar):

```json
[
  {
    "id": "identificador-unico-da-publicacao",
    "category": "noticias",
    "title": "Título da publicação",
    "date": "2026-09-28",
    "summary": "Resumo revisado pela equipe.",
    "body": ["Primeiro parágrafo.", "Segundo parágrafo."],
    "link": "https://cas.ifmt.edu.br/"
  }
]
```

Categorias: `noticias`, `eventos`, `palestras` ou `editais`. Os campos `body` e `link` são opcionais. `date` é a data de publicação, no formato `AAAA-MM-DD`; datas não agendam a publicação. Informe horários e datas de eventos no texto. Use links HTTPS para a fonte ou o documento oficial. HTML é tratado como texto, e IDs repetidos, datas inválidas e links inseguros interrompem o build.

As publicações aparecem da mais recente para a mais antiga. Para remover uma, apague seu objeto do arquivo. **Não há painel administrativo, contas locais, sincronização de curtidas nem envio de conteúdo pelos visitantes nesta etapa.**

## Arquivos principais

| Arquivo/pasta | Finalidade |
| --- | --- |
| `src/partials/` | Cabeçalho e rodapé compartilhados |
| `src/pages/` | Início, regras e página 404 |
| `content/posts.json` | Publicações mantidas pela equipe |
| `style.css` | Visual original e ajustes de acessibilidade |
| `public/` | JavaScript e arquivos públicos |
| `scripts/build.mjs` | Gera as sete páginas em `dist/` |
| `scripts/content.mjs` | Valida e apresenta as publicações |
| `scripts/serve.mjs` | Servidor de desenvolvimento local |
| `tests/` | Verificação do build, rotas e conteúdo |
| `vercel.json` | Configuração da publicação |

`dist/` é gerada automaticamente e não deve ser editada nem enviada ao Git. Somente essa pasta é publicada, sem expor os scripts, os testes ou os arquivos-fonte.

## Equipe

Grasyella · Rafaella · Sophia · Thaís · Yasmin · Andressa — **GRATYS TECH**.
