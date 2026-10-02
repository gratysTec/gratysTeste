<?php
$isEditing = !empty($post);
?>
<section class="admin-form-page">

    <div style="margin-bottom: 20px;">
        <a href="<?= url('/admin') ?>" class="btn-retro" style="display: inline-block; padding: 6px 14px; font-size: 0.85rem;">
            ← Voltar para o Painel
        </a>
    </div>

    <article class="post-box" style="padding: 35px 30px; max-width: 800px; margin: 0 auto;">

        <div class="paper-tape"></div>

        <div class="post-header">
            <span class="post-category">
                <?= $isEditing ? '✏️ EDITAR' : '✨ NOVA' ?> PUBLICAÇÃO
            </span>
            <span class="post-date">
                <?= date('d/m/Y') ?>
            </span>
        </div>

        <h1 style="font-family: 'Courier Prime', monospace; font-size: 1.6rem; margin: 15px 0 25px; color: var(--verde-profundo);">
            <?= $isEditing ? 'Editar Publicação' : 'Criar Nova Publicação' ?>
        </h1>

        <?php if (isset($_SESSION['flash_erro'])): ?>
            <div style="background: #ffe3e3; border: 2px solid #e00; color: #a00; padding: 10px 15px; border-radius: 6px; margin-bottom: 20px; font-size: 0.9rem;">
                <?= htmlspecialchars($_SESSION['flash_erro']) ?>
                <?php unset($_SESSION['flash_erro']); ?>
            </div>
        <?php endif; ?>

        <form action="<?= url($action) ?>" method="POST">

            <!-- TÍTULO -->
            <div class="form-group" style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 6px; font-weight: bold;">
                    📰 Título da Publicação *
                </label>
                <input
                    type="text"
                    name="titulo"
                    value="<?= htmlspecialchars($post['titulo'] ?? '') ?>"
                    placeholder="Digite um título atrativo e claro"
                    style="width: 100%; padding: 10px 14px; border: 2px solid var(--verde-claro); border-radius: 8px; font-size: 1rem;"
                    required
                >
            </div>

            <!-- CATEGORIA & STATUS -->
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                <div class="form-group">
                    <label style="display: block; margin-bottom: 6px; font-weight: bold;">
                        🏷️ Categoria *
                    </label>
                    <select
                        name="categoria_id"
                        id="categoria_id"
                        onchange="toggleEventoFields(this.value)"
                        style="width: 100%; padding: 10px 14px; border: 2px solid var(--verde-claro); border-radius: 8px; font-size: 1rem; background: white;"
                        required
                    >
                        <option value="">Selecione uma categoria...</option>
                        <?php foreach ($categorias as $cat): ?>
                            <option
                                value="<?= $cat['id'] ?>"
                                <?= (($post['categoria_id'] ?? '') == $cat['id']) ? 'selected' : '' ?>
                            >
                                <?= htmlspecialchars($cat['nome']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group" style="display: flex; align-items: center; margin-top: 25px;">
                    <label style="cursor: pointer; display: flex; align-items: center; gap: 8px; font-weight: bold;">
                        <input
                            type="checkbox"
                            name="publicado"
                            value="1"
                            <?= (!isset($post['publicado']) || !empty($post['publicado'])) ? 'checked' : '' ?>
                            style="width: 18px; height: 18px; accent-color: var(--verde);"
                        >
                        <span>Visível no site (Publicado)</span>
                    </label>
                </div>
            </div>

            <!-- RESUMO -->
            <div class="form-group" style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 6px; font-weight: bold;">
                    💬 Resumo / Lead (aparece na listagem inicial)
                </label>
                <textarea
                    name="resumo"
                    rows="3"
                    placeholder="Breve resumo da publicação para chamar a atenção da comunidade..."
                    style="width: 100%; padding: 10px 14px; border: 2px solid var(--verde-claro); border-radius: 8px; font-size: 0.95rem; resize: vertical;"
                ><?= htmlspecialchars($post['resumo'] ?? '') ?></textarea>
            </div>

            <!-- CONTEÚDO COMPLETO -->
            <div class="form-group" style="margin-bottom: 25px;">
                <label style="display: block; margin-bottom: 6px; font-weight: bold;">
                    ✍️ Conteúdo Completo *
                </label>
                <textarea
                    name="conteudo"
                    rows="10"
                    placeholder="Escreva todo o conteúdo da notícia, evento ou edital..."
                    style="width: 100%; padding: 10px 14px; border: 2px solid var(--verde-claro); border-radius: 8px; font-size: 0.95rem; resize: vertical;"
                    required
                ><?= htmlspecialchars($post['conteudo'] ?? '') ?></textarea>
            </div>

            <!-- CAMPOS OPCIONAIS DE EVENTO/PALESTRA -->
            <fieldset style="border: 2px dashed var(--verde-medio); border-radius: 8px; padding: 20px; margin-bottom: 30px; background: rgba(169,213,183,.15);">
                <legend style="padding: 0 10px; font-weight: bold; color: var(--verde-profundo);">
                    📅 Detalhes do Evento ou Palestra (Opcional)
                </legend>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-top: 10px;">
                    <div class="form-group">
                        <label style="display: block; margin-bottom: 4px; font-size: 0.9rem;">
                            Data do Evento:
                        </label>
                        <input
                            type="date"
                            name="data_evento"
                            value="<?= htmlspecialchars($post['data_evento'] ?? '') ?>"
                            style="width: 100%; padding: 8px 12px; border: 1px solid var(--verde-medio); border-radius: 6px;"
                        >
                    </div>

                    <div class="form-group">
                        <label style="display: block; margin-bottom: 4px; font-size: 0.9rem;">
                            Horário:
                        </label>
                        <input
                            type="time"
                            name="horario_evento"
                            value="<?= htmlspecialchars($post['horario_evento'] ?? '') ?>"
                            style="width: 100%; padding: 8px 12px; border: 1px solid var(--verde-medio); border-radius: 6px;"
                        >
                    </div>
                </div>

                <div class="form-group" style="margin-top: 15px;">
                    <label style="display: block; margin-bottom: 4px; font-size: 0.9rem;">
                        Localização / Sala:
                    </label>
                    <input
                        type="text"
                        name="local_evento"
                        value="<?= htmlspecialchars($post['local_evento'] ?? '') ?>"
                        placeholder="ex.: Auditório do Campus, Quadra Poliesportiva..."
                        style="width: 100%; padding: 8px 12px; border: 1px solid var(--verde-medio); border-radius: 6px;"
                    >
                </div>
            </fieldset>

            <!-- BOTÕES DE SUBMISSÃO -->
            <div style="display: flex; gap: 15px; justify-content: flex-end; align-items: center;">
                <a href="<?= url('/admin') ?>" style="color: var(--cinza); font-size: 0.9rem; text-decoration: underline;">
                    Cancelar
                </a>
                <button type="submit" class="btn-retro" style="padding: 10px 24px; font-size: 1rem; font-weight: bold;">
                    💾 Salvar Publicação
                </button>
            </div>

        </form>

    </article>

</section>
