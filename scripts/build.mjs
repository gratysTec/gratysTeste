import { readFile, writeFile, mkdir, rm, cp } from 'node:fs/promises';
import { createHash } from 'node:crypto';
import { fileURLToPath } from 'node:url';
import { resolve, dirname } from 'node:path';
import { sections, validatePosts, renderSection, escapeHtml } from './content.mjs';

export const projectRoot = resolve(dirname(fileURLToPath(import.meta.url)), '..');

export async function build({ output = resolve(projectRoot, 'dist'), postsFile = resolve(projectRoot, 'content/posts.json') } = {}) {
  const posts = validatePosts(JSON.parse(await readFile(postsFile, 'utf8')));
  const read = (path) => readFile(resolve(projectRoot, path), 'utf8');
  const [header, footer, stylesheet, script, index, rules, notFound] = await Promise.all([
    read('src/partials/header.html'), read('src/partials/footer.html'), read('style.css'), read('public/app.js'),
    read('src/pages/index.html'), read('src/pages/regras.html'), read('src/pages/404.html')
  ]);
  const hash = (data) => createHash('sha256').update(data).digest('hex').slice(0, 12);
  const assets = { stylesheet: `/assets/style.${hash(stylesheet)}.css`, script: `/assets/app.${hash(script)}.js` };
  const navigation = [{ key: 'index', label: 'Início', icon: '🏠' }, ...Object.entries(sections).map(([key, value]) => ({ key, ...value })), { key: 'regras', label: 'Regras', icon: '📖' }];
  const pages = [
    { key: 'index', title: 'IFolha — IFMT Campus Cáceres', description: 'Jornal digital acadêmico: notícias, eventos, palestras, editais e informações do IFMT Campus Cáceres.', body: index },
    ...Object.entries(sections).map(([key, section]) => ({ key, title: `${section.label} — IFolha`, description: section.description, body: renderSection(key, posts.filter((post) => post.category === key)) })),
    { key: 'regras', title: 'Regras — IFolha', description: 'Guia do estudante: direitos, deveres e convivência no campus.', body: rules },
    { key: '404', title: 'Página não encontrada — IFolha', description: 'Volte para o IFolha e encontre as informações do campus.', body: notFound }
  ];
  await rm(output, { recursive: true, force: true });
  await mkdir(resolve(output, 'assets'), { recursive: true });
  await cp(resolve(projectRoot, 'public'), output, { recursive: true });
  await rm(resolve(output, 'app.js'));
  await writeFile(resolve(output, assets.stylesheet.slice(1)), stylesheet);
  await writeFile(resolve(output, assets.script.slice(1)), script);
  for (const page of pages) {
    const values = {
      ...assets,
      title: escapeHtml(page.title),
      description: escapeHtml(page.description),
      navigation: navigation.map((item) => `<a href="${item.key === 'index' ? '/' : `/${item.key}`}" class="nav-btn${page.key === item.key ? ' active' : ''}"${page.key === item.key ? ' aria-current="page"' : ''}>${item.icon} ${item.label}</a>`).join('\n')
    };
    const shell = header.replace(/\{\{(\w+)\}\}/g, (_, key) => {
      if (!Object.hasOwn(values, key)) throw new Error(`Variável de template desconhecida: ${key}`);
      return values[key];
    });
    await writeFile(resolve(output, `${page.key}.html`), `${shell}\n${page.body}\n${footer}`);
  }
  return { output, pages: pages.length, posts: posts.length };
}

if (process.argv[1] && resolve(process.argv[1]) === fileURLToPath(import.meta.url)) {
  const result = await build();
  console.log(`IFolha: ${result.pages} páginas geradas em dist/; ${result.posts} publicações. Sem banco de dados.`);
}
