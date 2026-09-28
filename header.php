<?php
// header.php
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>IFolha — IFMT Campus Cáceres</title>

    <!-- Fontes que combinam com o estilo da imagem -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Courier+Prime:wght@400;700&family=Press+Start+2P&family=Shantell+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
</head>

<body>

    <!-- FAIXA SUPERIOR -->
    <div class="top-marquee">
        <marquee>
            ✦ IFMT CAMPUS CÁCERES ✦ IFOLHA ✦ notícias, eventos e informações acadêmicas ✦ GRÁTYS TECH ✦
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

                <span class="edition-stamp">
                    EDIÇÃO 2026
                </span>

                <span class="company-name">
                    ✦ GRATYS TECH ✦
                </span>

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

                <a href="index.php" class="nav-btn active">
                    🏠 Início
                </a>

                <a href="noticias.php" class="nav-btn">
                    📰 Notícias
                </a>

                <a href="eventos.php" class="nav-btn">
                    📅 Eventos
                </a>

                <a href="palestras.php" class="nav-btn">
                    🎤 Palestras
                </a>

                <a href="editais.php" class="nav-btn">
                    📜 Editais
                </a>

                <a href="regras.php" class="nav-btn">
                    📖 Regras
                </a>

            </nav>

        </header>


        <main class="main-content">