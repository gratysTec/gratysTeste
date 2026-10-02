        </main>

        <!-- =========================
             RODAPÉ
        ========================= -->
        <footer class="site-footer">

            <div class="footer-decoration">
                ✦ ✿ ✦ IFOLHA ✦ ✿ ✦
            </div>

            <div class="footer-content">

                <div class="footer-info">
                    <h3>IFOLHA</h3>
                    <p>
                        Jornal digital do IFMT Campus Cáceres Professor Olegário Baldo.
                    </p>
                    <p>Informação acadêmica ♡</p>
                </div>

                <div class="footer-team">
                    <h4>desenvolvido por</h4>
                    <p><strong>GRATYS TECH</strong></p>
                    <p>
                        Grasyella · Rafaella · Sophia · Thaís · Yasmin · Andressa
                    </p>
                </div>

            </div>

            <div class="footer-bottom">
                <span>© 2026 IFolha</span>
                <span>✦ GRATYS TECH ✦</span>
                <span>IFMT Campus Cáceres</span>
            </div>

        </footer>

    </div>

    <!-- Script para interações (curtidas e AJAX) -->
    <script>
    function curtir(btn, postId) {
        if (!postId) {
            let span = btn.querySelector('span');
            span.textContent = parseInt(span.textContent || '0') + 1;
            btn.classList.add('liked');
            return;
        }

        fetch('<?= url('/curtir/') ?>' + postId, { method: 'POST' })
            .then(res => res.json())
            .then(data => {
                if (data.sucesso) {
                    let span = btn.querySelector('span');
                    span.textContent = data.total;
                    if (data.liked) {
                        btn.classList.add('liked');
                    } else {
                        btn.classList.remove('liked');
                    }
                }
            })
            .catch(err => console.error('Erro ao curtir:', err));
    }
    </script>

</body>
</html>
