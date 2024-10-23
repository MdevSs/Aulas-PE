<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="CSS/Index.css">
        <link rel="shortcut icon" href="IMG/LogoBranco.png">
        <title>The Library | Home</title>
    </head>

    <body>
        <div class="header">
            <div class="user">
                <?php
                    session_start();
                    echo '<strong>Ola, ' . $_SESSION['txtNome'] . '!</strong>';
                ?>
            </div>

            <div class="item">
                <a href="PHP/Acervo.php"><strong>Acervo</strong></a>
    
                <a href="PHP/Emprestimo.php"><strong>Emprestimos</strong></a>
            </div>
        </div>

        <div class="section-1">
            <h1><strong>The Library</strong></h1> <img src="IMG/LogoBranco.png">
        </div>

        <div class="section-2">
            <h1><strong>Quem somos?</strong></h1>

            <br>

            <div class="livro">
                <img src="IMG/Exemplo1.png">

                <p>
                    <strong>
                        Somos uma das maiores .the_librarys existentes do mundo. Com um catálogo de mais 1000 livros já finalizados para você! Varie desde medicina e assassinato até mitologia e mistério acompanhando tudo de perto no melhor lugar.
                    </strong>
                </p>
            </div>

            <br>

            <div class="livro">
                <p>
                    <strong>
                        O nosso maior objetivo é permitir que, qualquer pessoa possa pegar qualquer um de nossos livros em qualquer dia para entrar no vasto mundo da leitura! Então venha logo e tire uma foto do seu cartão de credito/debito e mande para nós! Não esqueça de colocar dinheiro na conta!
                    </strong>
                </p>

                <img src="IMG/Exemplo2.png">
            </div>
        </div>

        <div class="footer">
            <h1><strong>Juan Ramon & Leandro Henrique</strong></h1>
        </div>
    </body>

    <script src="JS/Index.js"></script>
</html>