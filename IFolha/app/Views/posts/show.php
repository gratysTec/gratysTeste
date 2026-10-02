<section class="post-single-page">

    <div style="margin-bottom: 20px;">
        <a href="javascript:history.back()" class="btn-retro" style="display: inline-block; padding: 6px 14px; font-size: 0.85rem;">
            ← Voltar
        </a>
    </div>

    <article class="post-box" style="padding: 35px 30px;">

        <div class="paper-tape"></div>

        <div class="post-header">
            <span class="post-category">
                🌸 <?= htmlspecialchars($post['categoria_nome']) ?>
            </span>

            <span class="post-date">
                📅 Publicado em <?= date('d/m/Y \à\s H:i', strtotime($post['criado_em'])) ?>
            </span>
        </div>

        <h1 style="font-family: 'Courier Prime', monospace; font-size: 1.8rem; margin: 20px 0; color: var(--verde-profundo);">
            <?= htmlspecialchars($post['titulo']) ?>
        </h1>

        <?php if (!empty($post['resumo'])): ?>
            <div class="info-tip" style="margin-bottom: 25px;">
                💡 <em><?= htmlspecialchars($post['resumo']) ?></em>
            </div>
        <?php endif; ?>

        <?php if (!empty($post['data_evento'])): ?>
            <div class="info-tip" style="margin-bottom: 25px; background: var(--amarelo);">
                📅 <strong>Data do Evento:</strong> <?= date('d/m/Y', strtotime($post['data_evento'])) ?>
                <?php if (!empty($post['horario_evento'])): ?> às <?= htmlspecialchars(substr($post['horario_evento'], 0, 5)) ?><?php endif; ?>
                <br>
                📍 <strong>Local:</strong> <?= htmlspecialchars($post['local_evento'] ?? 'Campus IFMT Cáceres') ?>
            </div>
        <?php endif; ?>

        <div class="post-body-content" style="line-height: 1.8; font-size: 1.05rem; white-space: pre-line;">
            <?= htmlspecialchars($post['conteudo']) ?>
        </div>

        <div class="post-footer" style="margin-top: 35px; border-top: 2px dashed rgba(40,107,72,.2); padding-top: 20px;">
            <span>
                ✍️ Por: <strong><?= htmlspecialchars($post['autor_nome'] ?? 'Redação IFolha') ?></strong>
            </span>

            <span class="views">
                👁 <?= (int) ($post['total_visualizacoes'] ?? 0) ?> visualizações
            </span>

            <button class="like-btn" onclick="curtir(this, <?= $post['id'] ?>)">
                ♡ <span><?= (int) ($post['total_curtidas'] ?? 0) ?></span>
            </button>
        </div>

    </article>

</section>
