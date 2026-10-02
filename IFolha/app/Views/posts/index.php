<section class="posts-page">

    <div class="rules-header">
        <div class="rules-header-decoration">
            ✦ ✿ ✦
        </div>

        <span class="rules-label">
            <?= $categoriaIcon ?? '📰' ?> SEÇÃO ACADÊMICA
        </span>

        <h1>
            <?= htmlspecialchars($categoriaNome) ?>
        </h1>

        <p>
            Acompanhe as últimas atualizações de <?= htmlspecialchars($categoriaNome) ?> do IFMT Campus Cáceres.
        </p>

        <div class="rules-header-decoration">
            ───── ♡ ─────
        </div>
    </div>

    <div class="layout-grid" style="margin-top: 30px;">

        <div class="main-column" style="width: 100%;">

            <?php if (empty($posts)): ?>
                <div class="post-box" style="text-align: center; padding: 40px 20px;">
                    <span style="font-size: 2.5rem;">🌸</span>
                    <h2 style="margin: 15px 0;">Nenhuma publicação encontrada</h2>
                    <p style="color: var(--cinza);">
                        Ainda não há registros cadastrados na seção de <strong><?= htmlspecialchars($categoriaNome) ?></strong>.
                        Volte em breve para conferir as novidades da redação!
                    </p>
                    <a href="<?= url('/') ?>" class="btn-retro" style="display: inline-block; margin-top: 20px;">
                        ← Voltar ao Início
                    </a>
                </div>
            <?php else: ?>
                <?php foreach ($posts as $post): ?>
                    <article class="post-box" style="margin-bottom: 30px;">

                        <div class="paper-tape"></div>

                        <div class="post-header">
                            <span class="post-category">
                                <?= htmlspecialchars($post['categoria_nome']) ?>
                            </span>

                            <span class="post-date">
                                📅 <?= date('d/m/Y \à\s H:i', strtotime($post['criado_em'])) ?>
                            </span>
                        </div>

                        <h2>
                            <a href="<?= url('/post/' . $post['id']) ?>">
                                <?= htmlspecialchars($post['titulo']) ?>
                            </a>
                        </h2>

                        <?php if (!empty($post['data_evento'])): ?>
                            <div class="info-tip" style="margin: 15px 0;">
                                📍 <strong>Evento:</strong> <?= date('d/m/Y', strtotime($post['data_evento'])) ?>
                                <?php if (!empty($post['horario_evento'])): ?> às <?= htmlspecialchars(substr($post['horario_evento'], 0, 5)) ?><?php endif; ?>
                                <?php if (!empty($post['local_evento'])): ?> — Local: <?= htmlspecialchars($post['local_evento']) ?><?php endif; ?>
                            </div>
                        <?php endif; ?>

                        <p>
                            <?= nl2br(htmlspecialchars($post['resumo'] ?? substr(strip_tags($post['conteudo']), 0, 200) . '...')) ?>
                        </p>

                        <div style="margin-top: 20px;">
                            <a href="<?= url('/post/' . $post['id']) ?>" class="btn-retro" style="display: inline-block; padding: 8px 18px;">
                                Continuar lendo ➔
                            </a>
                        </div>

                        <div class="post-footer" style="margin-top: 25px;">
                            <span>✦ Redação: <?= htmlspecialchars($post['autor_nome'] ?? 'IFolha') ?></span>

                            <span class="views">
                                👁 <?= (int) ($post['total_visualizacoes'] ?? 0) ?> visualizações
                            </span>

                            <button class="like-btn" onclick="curtir(this, <?= $post['id'] ?>)">
                                ♡ <span><?= (int) ($post['total_curtidas'] ?? 0) ?></span>
                            </button>
                        </div>

                    </article>
                <?php endforeach; ?>
            <?php endif; ?>

        </div>

    </div>

</section>
