export const sections = {
  noticias: { label: 'Notícias', icon: '📰', description: 'Novidades e informações para a comunidade do campus.', empty: 'Nenhuma notícia publicada por aqui ainda.' },
  eventos: { label: 'Eventos', icon: '📅', description: 'Encontros, atividades e acontecimentos do campus.', empty: 'Nenhum evento publicado por aqui ainda.' },
  palestras: { label: 'Palestras', icon: '🎤', description: 'Conversas, conhecimento e oportunidades de aprender.', empty: 'Nenhuma palestra publicada por aqui ainda.' },
  editais: { label: 'Editais', icon: '📜', description: 'Seleções, oportunidades e comunicados acadêmicos.', empty: 'Nenhum edital publicado por aqui ainda.' }
};

export function escapeHtml(value) {
  return String(value).replace(/[&<>"']/g, (char) => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' })[char]);
}

export function validatePosts(posts) {
  if (!Array.isArray(posts)) throw new Error('content/posts.json precisa conter uma lista.');
  const ids = new Set();
  for (const [index, post] of posts.entries()) {
    const fail = (message) => { throw new Error(`Publicação ${index + 1}: ${message}`); };
    if (!post || typeof post !== 'object' || Array.isArray(post)) fail('formato inválido.');
    for (const key of ['id', 'category', 'title', 'date', 'summary']) {
      if (typeof post[key] !== 'string' || !post[key].trim()) fail(`campo ${key} obrigatório.`);
    }
    if (!/^[a-z0-9]+(?:-[a-z0-9]+)*$/.test(post.id) || ids.has(post.id)) fail('id inválido ou repetido.');
    ids.add(post.id);
    if (!Object.hasOwn(sections, post.category)) fail('categoria desconhecida.');
    if (!/^\d{4}-\d{2}-\d{2}$/.test(post.date)) fail('data deve usar AAAA-MM-DD.');
    const date = new Date(`${post.date}T00:00:00Z`);
    if (Number.isNaN(date.valueOf()) || date.toISOString().slice(0, 10) !== post.date) fail('data inválida.');
    if (post.body !== undefined && (!Array.isArray(post.body) || post.body.some((paragraph) => typeof paragraph !== 'string'))) fail('body deve ser uma lista de parágrafos em texto.');
    if (post.link !== undefined) {
      if (typeof post.link !== 'string') fail('link deve ser um endereço HTTPS.');
      let url;
      try { url = new URL(post.link); } catch { fail('link inválido.'); }
      if (url.protocol !== 'https:' || url.username || url.password) fail('link deve usar HTTPS sem credenciais.');
    }
  }
  return [...posts].sort((a, b) => b.date.localeCompare(a.date));
}

export function renderSection(category, posts) {
  const section = sections[category];
  const heading = `<div class="rules-header"><span class="rules-label">${section.icon} JORNAL DO CAMPUS</span><h1>${section.label}</h1><p>${section.description}</p></div>`;
  const officialLink = '<a class="back-button" href="https://cas.ifmt.edu.br/" target="_blank" rel="noopener noreferrer">Consultar o portal oficial do campus ↗</a>';
  if (!posts.length) return `<section class="rules-page">${heading}<div class="empty-state"><span class="empty-icon" aria-hidden="true">${section.icon}</span><h2>${section.empty}</h2><p>Quando a equipe publicar uma novidade, ela aparecerá aqui. Enquanto isso, acompanhe os canais oficiais do IFMT.</p>${officialLink}</div></section>`;
  const cards = posts.map((post) => {
    const date = new Intl.DateTimeFormat('pt-BR', { timeZone: 'UTC' }).format(new Date(`${post.date}T00:00:00Z`));
    return `<article class="post-box publication" id="${post.id}" data-post>
      <div class="post-header"><span class="post-category">${section.icon} ${section.label}</span><time class="post-date" datetime="${post.date}">${date}</time></div>
      <h2>${escapeHtml(post.title)}</h2><p>${escapeHtml(post.summary)}</p>
      ${(post.body ?? []).map((paragraph) => `<p>${escapeHtml(paragraph)}</p>`).join('\n')}
      ${post.link ? `<p><a class="publication-link" href="${escapeHtml(post.link)}" target="_blank" rel="noopener noreferrer">Consultar a fonte / documento ↗</a></p>` : ''}
    </article>`;
  }).join('\n');
  return `<section class="rules-page">${heading}
    <div class="search-box" data-search-controls hidden><label for="busca">Buscar em ${section.label.toLocaleLowerCase('pt-BR')}</label><input id="busca" type="search" placeholder="Digite uma palavra…" data-search autocomplete="off"><p data-search-status role="status">${posts.length} ${posts.length === 1 ? 'publicação' : 'publicações'}.</p></div>
    ${cards}
    <div class="empty-state" data-search-empty hidden><h2>Nenhuma publicação encontrada.</h2><p>Tente outra palavra ou apague a busca para ver todas.</p></div>
  </section>`;
}
