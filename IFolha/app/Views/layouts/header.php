<?php
$activePage   = $activePage ?? 'inicio';
$tituloPagina = $tituloPagina ?? 'IFolha — IFMT Campus Cáceres';
$usuarioLogado = $_SESSION['usuario'] ?? null;
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= htmlspecialchars($tituloPagina) ?></title>

    <!-- Fontes do projeto -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Courier+Prime:wght@400;700&family=Press+Start+2P&family=Shantell+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- CSS Principal -->
    <link rel="stylesheet" href="<?= url('/assets/css/style.css') ?>?v=<?= time() ?>">
</head>

<body>

    <!-- FAIXA SUPERIOR -->
    <div class="top-marquee">
        <marquee>
            ✦ IFMT CAMPUS CÁCERES ✦ IFOLHA ✦ notícias, eventos e informações acadêmicas ✦ GRATYS TECH ✦
        </marquee>
    </div>

    <div class="page-wrapper">

        <!-- CABEÇALHO -->
        <header class="newspaper-header">

            <div class="tape tape-left"></div>
            <div class="tape tape-right"></div>

            <span class="doodle doodle-star">✦</span>
            <span class="doodle doodle-flower">✿</span>
            <span class="doodle doodle-sparkle">✧</span>

            <div class="header-meta">
                <span>📍 IFMT Campus Cáceres</span>
                <span class="edition-stamp">EDIÇÃO 2026</span>
                <span class="company-name">✦ GRATYS TECH ✦</span>
            </div>

            <div class="logo-decoration">
                ✦ jornal digital acadêmico ✦
            </div>

            <h1 class="blog-title">
                IFOLHA
            </h1>

            <p class="blog-subtitle">
                ✧ o seu portal de notícias fofinho &amp; informativo do IFMT ✧
            </p>

            <!-- NAVEGAÇÃO -->
            <nav class="nav-bar">
                <a href="<?= url('/') ?>" class="nav-btn <?= ($activePage === 'inicio') ? 'active' : '' ?>">
                    🏠 Início
                </a>

                <a href="<?= url('/noticias') ?>" class="nav-btn <?= ($activePage === 'noticias') ? 'active' : '' ?>">
                    📰 Notícias
                </a>

                <a href="<?= url('/eventos') ?>" class="nav-btn <?= ($activePage === 'eventos') ? 'active' : '' ?>">
                    📅 Eventos
                </a>

                <a href="<?= url('/palestras') ?>" class="nav-btn <?= ($activePage === 'palestras') ? 'active' : '' ?>">
                    🎤 Palestras
                </a>

                <a href="<?= url('/editais') ?>" class="nav-btn <?= ($activePage === 'editais') ? 'active' : '' ?>">
                    📜 Editais
                </a>

                <a href="<?= url('/regras') ?>" class="nav-btn <?= ($activePage === 'regras') ? 'active' : '' ?>">
                    📖 Regras
                </a>

                <?php if (!empty($usuarioLogado) && ($usuarioLogado['tipo'] ?? '') === 'admin'): ?>
                    <a href="<?= url('/admin') ?>" class="nav-btn <?= ($activePage === 'admin') ? 'active' : '' ?>" style="background: var(--amarelo); color: var(--verde-profundo); font-weight: bold;">
                        ⚙️ Painel
                    </a>
                <?php endif; ?>
            </nav>

        </header>

        <main class="main-content">
