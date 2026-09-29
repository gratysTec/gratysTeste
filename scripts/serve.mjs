import { createServer } from 'node:http';
import { readFile, stat } from 'node:fs/promises';
import { extname, resolve, sep } from 'node:path';
import { pathToFileURL } from 'node:url';
import { projectRoot } from './build.mjs';

const config = JSON.parse(await readFile(resolve(projectRoot, 'vercel.json'), 'utf8'));
const mime = { '.html': 'text/html; charset=utf-8', '.css': 'text/css; charset=utf-8', '.js': 'text/javascript; charset=utf-8', '.svg': 'image/svg+xml', '.png': 'image/png', '.jpg': 'image/jpeg', '.webp': 'image/webp', '.pdf': 'application/pdf', '.json': 'application/json', '.txt': 'text/plain; charset=utf-8' };

export function createSiteServer(root = resolve(projectRoot, 'dist')) {
  root = resolve(root);
  return createServer(async (request, response) => {
    if (!['GET', 'HEAD'].includes(request.method)) {
      response.writeHead(405, { Allow: 'GET, HEAD' }).end();
      return;
    }
    try {
      const url = new URL(request.url, 'http://localhost');
      const pathname = decodeURIComponent(url.pathname);
      const redirect = config.redirects.find((item) => item.source === pathname);
      if (redirect || (pathname !== '/' && pathname.endsWith('/')) || pathname.endsWith('.html')) {
        const target = redirect?.destination ?? (pathname === '/index.html' ? '/' : pathname.replace(/\.html$|\/$/g, ''));
        if (!target.startsWith('/') || target.startsWith('//')) { response.writeHead(400).end(); return; }
        response.writeHead(308, { Location: target + url.search }).end();
        return;
      }
      const resource = pathname === '/' ? 'index.html' : pathname.slice(1) + (extname(pathname) ? '' : '.html');
      const path = resolve(root, resource);
      if (!path.startsWith(root + sep) || pathname.includes('\\')) { response.writeHead(400).end(); return; }
      let body, status = 200, type = mime[extname(path)] ?? 'application/octet-stream';
      try { body = await readFile(path); }
      catch { status = 404; type = mime['.html']; body = await readFile(resolve(root, '404.html')); }
      response.writeHead(status, { 'Content-Type': type, 'X-Content-Type-Options': 'nosniff' });
      response.end(request.method === 'HEAD' ? undefined : body);
    } catch { response.writeHead(400).end('Endereço inválido.'); }
  });
}

if (process.argv[1] && pathToFileURL(resolve(process.argv[1])).href === import.meta.url) {
  await stat(resolve(projectRoot, 'dist/index.html')).catch(() => { throw new Error('Execute npm run build antes de iniciar o servidor.'); });
  const port = Number(process.env.PORT || 3000);
  const host = process.env.HOST || '127.0.0.1';
  createSiteServer().listen(port, host, () => console.log(`IFolha disponível em http://${host}:${port}`));
}
