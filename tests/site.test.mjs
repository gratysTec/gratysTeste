import test from 'node:test';
import assert from 'node:assert/strict';
import { mkdtemp, readFile, writeFile, rm } from 'node:fs/promises';
import { tmpdir } from 'node:os';
import { join } from 'node:path';
import { once } from 'node:events';
import { build } from '../scripts/build.mjs';
import { validatePosts } from '../scripts/content.mjs';
import { createSiteServer } from '../scripts/serve.mjs';

test('site estático: rotas, assets, navegação, redirecionamentos e 404', async (t) => {
  const output = await mkdtemp(join(tmpdir(), 'ifolha-test-'));
  t.after(() => rm(output, { recursive: true, force: true }));
  const result = await build({ output });
  assert.equal(result.pages, 7);
  const server = createSiteServer(output);
  server.listen(0, '127.0.0.1');
  await once(server, 'listening');
  t.after(() => new Promise((resolve) => server.close(resolve)));
  const base = `http://127.0.0.1:${server.address().port}`;
  for (const route of ['', 'noticias', 'eventos', 'palestras', 'editais', 'regras']) {
    const response = await fetch(`${base}/${route}`);
    assert.equal(response.status, 200, route);
    const html = await response.text();
    assert.equal((html.match(/<h1\b/g) ?? []).length, 1, `${route}: um título principal`);
    assert.equal((html.match(/aria-current="page"/g) ?? []).length, 1);
    assert.match(html, new RegExp(`href="/${route}" class="nav-btn active"`));
    assert.doesNotMatch(html, /<\?php|onclick=|onsubmit=|type="password"|\{\{\w+\}\}/);
    for (const [, link] of html.matchAll(/(?:href|src)="(\/[^"#]*)"/g)) {
      assert.equal((await fetch(base + link)).status, 200, `${route}: ${link}`);
    }
  }
  for (const route of ['index', 'noticias', 'eventos', 'palestras', 'editais', 'regras']) {
    const response = await fetch(`${base}/${route}.php?origem=antigo`, { redirect: 'manual' });
    assert.equal(response.status, 308);
    assert.equal(response.headers.get('location'), `/${route === 'index' ? '' : route}?origem=antigo`);
  }
  const missing = await fetch(`${base}/pagina-inexistente`);
  assert.equal(missing.status, 404);
  assert.match(await missing.text(), /Essa folha não está no jornal/);
  assert.equal((await fetch(`${base}/content/posts.json`)).status, 404);
  assert.equal((await fetch(`${base}/scripts/build.mjs`)).status, 404);
  assert.equal((await fetch(`${base}/`, { method: 'POST' })).status, 405);
});

test('publicações são geradas por categoria, ordenadas e escapadas como texto', async (t) => {
  const temp = await mkdtemp(join(tmpdir(), 'ifolha-content-'));
  t.after(() => rm(temp, { recursive: true, force: true }));
  const postsFile = join(temp, 'posts.json');
  await writeFile(postsFile, JSON.stringify([
    { id: 'anterior', category: 'noticias', title: 'Primeira publicação', date: '2026-09-20', summary: 'Texto anterior.' },
    { id: 'recente', category: 'noticias', title: '<script>alert(1)</script>', date: '2026-09-28', summary: 'Campus & comunidade', body: ['<img src=x onerror=alert(1)>'], link: 'https://cas.ifmt.edu.br/?a=1&b=2' },
    { id: 'evento', category: 'eventos', title: 'Evento de teste', date: '2026-09-28', summary: 'Somente para este teste.' }
  ]));
  const output = join(temp, 'dist');
  await build({ output, postsFile });
  const html = await readFile(join(output, 'noticias.html'), 'utf8');
  assert.ok(html.indexOf('id="recente"') < html.indexOf('id="anterior"'));
  assert.doesNotMatch(html, /id="evento"|<script>alert|<img src=x/);
  assert.match(html, /&lt;script&gt;alert/);
  assert.match(html, /Campus &amp; comunidade/);
  assert.match(html, /28\/09\/2026/);
  assert.match(html, /data-search/);
});

test('erros de conteúdo interrompem a publicação com uma mensagem útil', () => {
  const valid = { id: 'teste', category: 'noticias', title: 'Teste', date: '2026-09-28', summary: 'Resumo.' };
  assert.throws(() => validatePosts({}), /lista/);
  assert.throws(() => validatePosts([{ ...valid, date: '2026-02-30' }]), /data inválida/);
  assert.throws(() => validatePosts([{ ...valid, category: 'constructor' }]), /categoria/);
  assert.throws(() => validatePosts([{ ...valid, link: 'javascript:alert(1)' }]), /HTTPS/);
  assert.throws(() => validatePosts([valid, valid]), /repetido/);
  assert.throws(() => validatePosts([{ ...valid, body: '<b>texto</b>' }]), /parágrafos/);
});
