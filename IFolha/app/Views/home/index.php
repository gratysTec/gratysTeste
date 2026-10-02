<!-- =====================================================
     INÍCIO
===================================================== -->
<section id="inicio" class="home-section">

    <div class="layout-grid">

        <!-- =================================================
             COLUNA PRINCIPAL
        ================================================== -->
        <div class="main-column">

            <!-- DESTAQUE BOAS-VINDAS -->
            <article class="post-box featured-post">

                <div class="paper-tape"></div>

                <div class="post-header">
                    <span class="post-category">🌸 DESTAQUE</span>
                    <span class="post-date">2026</span>
                </div>

                <h2>
                    Seja bem-vindo(a) ao IFolha! <br> (｡•ᴗ•｡)
                </h2>

                <p>
                    Um cantinho estético, retrô e super decorado
                    criado para manter toda a comunidade do
                    <strong>IFMT Campus Cáceres</strong> informada
                    sobre notícias, eventos, palestras, editais
                    e regras acadêmicas.
                </p>

                <div class="info-tip">
                    💬 <em>
                        Use os botões no topo para navegar pelo
                        jornal e encontrar as informações que procura!
                    </em>
                </div>

                <div class="post-footer">
                    <span>✦ IFolha</span>
                    <span class="views">
                        👁 <span class="view-count">100+</span> visualizações
                    </span>
                    <button class="like-btn" onclick="curtir(this)">
                        ♡ <span>42</span>
                    </button>
                </div>

            </article>

            <!-- =================================================
                 ÚLTIMAS NOTÍCIAS DO BANCO DE DADOS
            ================================================== -->
            <?php if (!empty($posts)): ?>
                <section class="latest-posts" style="margin-top: 30px;">
                    <div class="section-title">
                        <span>✦</span>
                        <h3>ÚLTIMAS PUBLICAÇÕES</h3>
                        <span>✦</span>
                    </div>

                    <?php foreach ($posts as $post): ?>
                        <article class="post-box" style="margin-top: 20px;">
                            <div class="paper-tape"></div>

                            <div class="post-header">
                                <span class="post-category">
                                    <?= htmlspecialchars($post['categoria_nome']) ?>
                                </span>
                                <span class="post-date">
                                    <?= date('d/m/Y', strtotime($post['criado_em'])) ?>
                                </span>
                            </div>

                            <h2>
                                <a href="<?= url('/post/' . $post['id']) ?>">
                                    <?= htmlspecialchars($post['titulo']) ?>
                                </a>
                            </h2>

                            <p>
                                <?= nl2br(htmlspecialchars($post['resumo'] ?? substr(strip_tags($post['conteudo']), 0, 160) . '...')) ?>
                            </p>

                            <div style="margin-top: 15px;">
                                <a href="<?= url('/post/' . $post['id']) ?>" class="btn-retro" style="display: inline-block; padding: 6px 14px; font-size: 0.85rem;">
                                    Ler notícia completa ➔
                                </a>
                            </div>

                            <div class="post-footer" style="margin-top: 20px;">
                                <span>✦ <?= htmlspecialchars($post['autor_nome'] ?? 'Redação') ?></span>
                                <span class="views">
                                    👁 <?= (int) ($post['total_visualizacoes'] ?? 0) ?> visualizações
                                </span>
                                <button class="like-btn" onclick="curtir(this, <?= $post['id'] ?>)">
                                    ♡ <span><?= (int) ($post['total_curtidas'] ?? 0) ?></span>
                                </button>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </section>
            <?php endif; ?>

            <!-- =================================================
                 QUADRO DE ATALHOS
            ================================================== -->
            <section class="links-board" style="margin-top: 30px;">

                <div class="section-title">
                    <span>✦</span>
                    <h3>NAVEGUE PELO IFOLHA</h3>
                    <span>✦</span>
                </div>

                <p class="section-subtitle">
                    encontre rapidamente o que você procura ♡
                </p>

                <div class="stickers-grid">

                    <a href="<?= url('/noticias') ?>" class="sticker-card">
                        <span class="sticker-icon">📰</span>
                        <strong>Notícias</strong>
                        <small>novidades do campus</small>
                    </a>

                    <a href="<?= url('/eventos') ?>" class="sticker-card">
                        <span class="sticker-icon">📅</span>
                        <strong>Eventos</strong>
                        <small>participe do campus</small>
                    </a>

                    <a href="<?= url('/palestras') ?>" class="sticker-card">
                        <span class="sticker-icon">🎤</span>
                        <strong>Palestras</strong>
                        <small>conhecimento & encontros</small>
                    </a>

                    <a href="<?= url('/editais') ?>" class="sticker-card">
                        <span class="sticker-icon">📜</span>
                        <strong>Editais</strong>
                        <small>oportunidades acadêmicas</small>
                    </a>

                    <a href="<?= url('/regras') ?>" class="sticker-card">
                        <span class="sticker-icon">📖</span>
                        <strong>Regras</strong>
                        <small>regulamentos importantes</small>
                    </a>

                </div>

            </section>

        </div>

        <!-- =================================================
             SIDEBAR
        ================================================== -->
        <aside class="sidebar-column">

            <!-- LOGIN -->
            <div class="postit-box">

                <span class="pin">📌</span>

                <h3>Login Estudantil</h3>

                <span class="suap-badge">SUAP</span>

                <?php if (isset($_SESSION['usuario'])): ?>
                    <p class="small-text">
                        Bem-vindo(a), <strong><?= htmlspecialchars($_SESSION['usuario']['nome']) ?></strong>!
                    </p>
                    <p style="margin: 10px 0; font-size: 0.85rem;">
                        Perfil: <span class="edition-stamp"><?= strtoupper($_SESSION['usuario']['tipo'] ?? 'ALUNO') ?></span>
                    </p>
                    <?php if (($_SESSION['usuario']['tipo'] ?? '') === 'admin'): ?>
                        <a href="<?= url('/admin') ?>" class="btn-retro" style="display: block; text-align: center; margin-top: 10px; background: var(--amarelo); color: var(--verde-profundo); font-weight: bold;">
                            ⚙️ Acessar Painel Admin
                        </a>
                    <?php endif; ?>
                    <a href="<?= url('/logout') ?>" class="btn-retro" style="display: block; text-align: center; margin-top: 10px;">
                        Sair da conta
                    </a>
                <?php else: ?>
                    <p class="small-text">
                        acesse sua área acadêmica
                    </p>

                    <?php if (isset($_SESSION['login_erro'])): ?>
                        <div style="background: #ffe3e3; color: #a00; padding: 6px 10px; border-radius: 6px; font-size: 0.8rem; margin-bottom: 10px;">
                            <?= htmlspecialchars($_SESSION['login_erro']) ?>
                            <?php unset($_SESSION['login_erro']); ?>
                        </div>
                    <?php endif; ?>

                    <form action="<?= url('/login') ?>" method="POST">
                        <div class="form-group">
                            <label>💌 E-mail</label>
                            <input
                                type="text"
                                name="email"
                                placeholder="ex.: ...@estudante.ifmt.edu.br"
                                required
                            >
                        </div>

                        <div class="form-group">
                            <label>🔐 Senha</label>
                            <input
                                type="password"
                                name="senha"
                                id="senha"
                                placeholder="••••••••"
                                required
                            >
                        </div>

                        <button type="submit" class="btn-retro">
                            Entrar ✦
                        </button>
                    </form>
                <?php endif; ?>

            </div>

            <!-- SOBRE -->
            <div class="post-box info-box">

                <h3 class="sidebar-title">
                    ✿ SOBRE O IFOLHA ✿
                </h3>

                <p>
                    O IFolha é um jornal digital criado para
                    facilitar o acesso da comunidade acadêmica
                    às informações do campus.
                </p>

                <div class="info-divider">
                    ───────────
                </div>

                <span>🏫 IFMT Campus Cáceres</span>
                <br>
                <span>💻 Desenvolvido por GRATYS TECH</span>

            </div>

        </aside>

    </div>

</section>
