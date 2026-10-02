<section class="admin-page">

    <div class="rules-header">
        <div class="rules-header-decoration">
            ✦ ✿ ✦
        </div>

        <span class="rules-label">
            🛠️ PAINEL DA REDAÇÃO
        </span>

        <h1>
            Gerenciamento de Publicações
        </h1>

        <p>
            Crie, edite ou remova notícias, eventos, palestras e editais do IFolha.
        </p>

        <div class="rules-header-decoration">
            ───── ♡ ─────
        </div>
    </div>

    <!-- MENSAGENS FLASH -->
    <?php if (isset($_SESSION['flash_sucesso'])): ?>
        <div style="background: var(--verde-palido); border: 2px solid var(--verde); color: var(--verde-profundo); padding: 12px 18px; border-radius: 8px; margin: 20px 0; font-weight: bold;">
            <?= htmlspecialchars($_SESSION['flash_sucesso']) ?>
            <?php unset($_SESSION['flash_sucesso']); ?>
        </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['flash_erro'])): ?>
        <div style="background: #ffe3e3; border: 2px solid #e00; color: #a00; padding: 12px 18px; border-radius: 8px; margin: 20px 0; font-weight: bold;">
            <?= htmlspecialchars($_SESSION['flash_erro']) ?>
            <?php unset($_SESSION['flash_erro']); ?>
        </div>
    <?php endif; ?>

    <!-- BARRA DE AÇÕES -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin: 25px 0; flex-wrap: wrap; gap: 15px;">
        <div>
            <a href="<?= url('/admin/posts/novo') ?>" class="btn-retro" style="display: inline-block; padding: 10px 20px; font-weight: bold;">
                ➕ Nova Publicação
            </a>
        </div>
        <div>
            <span style="font-size: 0.95rem; color: var(--cinza);">
                Total de publicações: <strong><?= count($posts) ?></strong>
            </span>
        </div>
    </div>

    <!-- LISTAGEM DAS PUBLICAÇÕES -->
    <div class="post-box" style="padding: 25px; overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse; text-align: left;">
            <thead>
                <tr style="border-bottom: 2px dashed rgba(40,107,72,.3); color: var(--verde-profundo); font-family: 'Courier Prime', monospace;">
                    <th style="padding: 10px;">ID</th>
                    <th style="padding: 10px;">Título</th>
                    <th style="padding: 10px;">Categoria</th>
                    <th style="padding: 10px;">Status</th>
                    <th style="padding: 10px;">Data</th>
                    <th style="padding: 10px; text-align: center;">Métricas</th>
                    <th style="padding: 10px; text-align: right;">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($posts)): ?>
                    <tr>
                        <td colspan="7" style="text-align: center; padding: 30px; color: var(--cinza);">
                            Nenhuma publicação cadastrada até o momento.
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($posts as $post): ?>
                        <tr style="border-bottom: 1px dotted rgba(40,107,72,.15);">
                            <td style="padding: 12px 10px; font-family: 'Courier Prime', monospace;">
                                #<?= $post['id'] ?>
                            </td>

                            <td style="padding: 12px 10px; font-weight: 600;">
                                <a href="<?= url('/post/' . $post['id']) ?>" target="_blank" title="Visualizar notícia no site" style="color: var(--verde-profundo); text-decoration: underline;">
                                    <?= htmlspecialchars($post['titulo']) ?>
                                </a>
                            </td>

                            <td style="padding: 12px 10px;">
                                <span class="post-category" style="font-size: 0.75rem;">
                                    <?= htmlspecialchars($post['categoria_nome']) ?>
                                </span>
                            </td>

                            <td style="padding: 12px 10px;">
                                <?php if (!empty($post['publicado'])): ?>
                                    <span style="background: var(--verde-palido); color: var(--verde); padding: 3px 8px; border-radius: 4px; font-size: 0.75rem; font-weight: bold;">
                                        ● Publicado
                                    </span>
                                <?php else: ?>
                                    <span style="background: var(--papel-amarelado); color: var(--cinza); padding: 3px 8px; border-radius: 4px; font-size: 0.75rem; font-weight: bold;">
                                        ○ Rascunho
                                    </span>
                                <?php endif; ?>
                            </td>

                            <td style="padding: 12px 10px; font-size: 0.85rem; color: var(--cinza);">
                                <?= date('d/m/Y', strtotime($post['criado_em'])) ?>
                            </td>

                            <td style="padding: 12px 10px; text-align: center; font-size: 0.85rem;">
                                👁 <?= (int) ($post['total_visualizacoes'] ?? 0) ?> · ♡ <?= (int) ($post['total_curtidas'] ?? 0) ?>
                            </td>

                            <td style="padding: 12px 10px; text-align: right; white-space: nowrap;">
                                <a href="<?= url('/admin/posts/editar/' . $post['id']) ?>" class="btn-retro" style="padding: 4px 10px; font-size: 0.8rem; margin-right: 5px;">
                                    ✏️ Editar
                                </a>

                                <form action="<?= url('/admin/posts/excluir/' . $post['id']) ?>" method="POST" style="display: inline-block;" onsubmit="return confirm('Tem certeza que deseja excluir esta publicação? Esta ação não pode ser desfeita.');">
                                    <button type="submit" class="btn-retro" style="padding: 4px 10px; font-size: 0.8rem; background: #ffe3e3; border-color: #d88;">
                                        🗑️
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

</section>
