/* Preferências locais: nenhuma conta, senha ou requisição a um banco. */
const memoryLikes = new Map();
const likeKey = (id) => `ifolha:like:${id}`;

function readLike(id) {
  if (memoryLikes.has(id)) return memoryLikes.get(id);
  try {
    return localStorage.getItem(likeKey(id)) === '1';
  } catch {
    return false;
  }
}

function paintLike(button) {
  const liked = readLike(button.dataset.like);
  button.classList.toggle('liked', liked);
  button.setAttribute('aria-pressed', String(liked));
  button.textContent = liked ? '♥ Curtido por você' : '♡ Curtir';
}

document.querySelectorAll('[data-like]').forEach((button) => {
  paintLike(button);
  button.hidden = false;
  button.addEventListener('click', () => {
    const id = button.dataset.like;
    const liked = !readLike(id);
    memoryLikes.set(id, liked);
    try {
      localStorage.setItem(likeKey(id), liked ? '1' : '0');
    } catch {
      const note = document.getElementById('like-note');
      if (note) note.textContent = 'Armazenamento indisponível: curtida válida nesta página.';
    }
    paintLike(button);
  });
});

window.addEventListener('storage', (event) => {
  if (event.key === null || event.key.startsWith('ifolha:like:')) {
    memoryLikes.clear();
    document.querySelectorAll('[data-like]').forEach(paintLike);
  }
});

const normalize = (text) => text.normalize('NFD').replace(/[\u0300-\u036f]/g, '').toLocaleLowerCase('pt-BR');
const search = document.querySelector('[data-search]');
if (search) {
  const posts = [...document.querySelectorAll('[data-post]')];
  const status = document.querySelector('[data-search-status]');
  const empty = document.querySelector('[data-search-empty]');
  document.querySelector('[data-search-controls]').hidden = false;
  search.addEventListener('input', () => {
    const query = normalize(search.value.trim());
    let count = 0;
    posts.forEach((post) => {
      const matches = normalize(post.textContent).includes(query);
      post.hidden = !matches;
      if (matches) count++;
    });
    status.textContent = `${count} ${count === 1 ? 'publicação encontrada' : 'publicações encontradas'}.`;
    empty.hidden = count !== 0;
  });
}
