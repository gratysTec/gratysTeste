<?php

include('header.php');

?>

<!-- =====================================================
     INÍCIO
===================================================== -->

<section id="inicio" class="home-section">

    <div class="layout-grid">


        <!-- =================================================
             COLUNA PRINCIPAL
        ================================================== -->

        <div class="main-column">


            <!-- DESTAQUE -->

            <article class="post-box featured-post">

                <div class="paper-tape"></div>

                <div class="post-header">

                    <span class="post-category">
                        🌸 DESTAQUE
                    </span>

                    <span class="post-date">
                        2026
                    </span>

                </div>


                <h2>
                    Seja bem-vindo(a) ao IFolha! <br> (｡•ᴗ•｡) </br>
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

                    <span>
                        ✦ IFolha
                    </span>

                    <span class="views">
                        👁 <span class="view-count">0</span>
                        visualizações
                    </span>

                    <button
                        class="like-btn"
                        onclick="curtir(this)"
                    >
                        ♡ <span>0</span>
                    </button>

                </div>

            </article>


            <!-- =================================================
                 QUADRO DE ATALHOS
            ================================================== -->

            <section class="links-board">

                <div class="section-title">

                    <span>✦</span>

                    <h3>
                        NAVEGUE PELO IFOLHA
                    </h3>

                    <span>✦</span>

                </div>


                <p class="section-subtitle">
                    encontre rapidamente o que você procura ♡
                </p>


                <div class="stickers-grid">


                    <a href="noticias.php" class="sticker-card">

                        <span class="sticker-icon">
                            📰
                        </span>

                        <strong>
                            Notícias
                        </strong>

                        <small>
                            novidades do campus
                        </small>

                    </a>


                    <a href="eventos.php" class="sticker-card">

                        <span class="sticker-icon">
                            📅
                        </span>

                        <strong>
                            Eventos
                        </strong>

                        <small>
                            participe do campus
                        </small>

                    </a>


                    <a href="palestras.php" class="sticker-card">

                        <span class="sticker-icon">
                            🎤
                        </span>

                        <strong>
                            Palestras
                        </strong>

                        <small>
                            conhecimento & encontros
                        </small>

                    </a>


                    <a href="editais.php" class="sticker-card">

                        <span class="sticker-icon">
                            📜
                        </span>

                        <strong>
                            Editais
                        </strong>

                        <small>
                            oportunidades acadêmicas
                        </small>

                    </a>


                    <a href="regras.php" class="sticker-card">

                        <span class="sticker-icon">
                            📖
                        </span>

                        <strong>
                            Regras
                        </strong>

                        <small>
                            regulamentos importantes
                        </small>

                    </a>

                </div>

            </section>


        <!-- ⚠️ ESTE FECHAMENTO ESTAVA FALTANDO -->

        </div>


        <!-- =================================================
             SIDEBAR
        ================================================== -->

        <aside class="sidebar-column">


            <!-- LOGIN -->

            <div class="postit-box">

                <span class="pin">
                    📌
                </span>


                <h3>
                    Login Estudantil
                </h3>


                <span class="suap-badge">
                    SUAP
                </span>


                <p class="small-text">
                    acesse sua área acadêmica
                </p>


                <form onsubmit="loginDemo(event)">

                    <div class="form-group">

                        <label>
                            💌 E-mail
                        </label>

                        <input
                            type="text"
                            placeholder="ex.: ...@estudante.ifmt.edu.br"
                            required
                        >

                    </div>


                    <div class="form-group">

                        <label>
                            🔐 Senha
                        </label>

                        <input
                            type="password"
                            id="senha"
                            placeholder="••••••••"
                            required
                        >

                    </div>


                    <button
                        type="submit"
                        class="btn-retro"
                    >
                        Entrar ✦
                    </button>

                </form>

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


                <span>
                    🏫 IFMT Campus Cáceres
                </span>


                <br>


                <span>
                    💻 Desenvolvido por GRATYS TECH
                </span>

            </div>

        </aside>

    </div>

</section>


<?php

include('footer.php');

?>