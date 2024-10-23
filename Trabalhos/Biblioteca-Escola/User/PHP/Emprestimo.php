<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="../CSS/Emprestimo.css">
        <link rel="shortcut icon" href="IMG/LogoBranco.png">
        <title>The Library | Emprestimos</title>
    </head>

    <body>
        <div class="section-1">
            <div class="header">
                <a href="../Index.php"><img src="../IMG/Arrow.png"></a>
            </div>

            <div class="emprestimos">
                <table>
                    <?php
                        session_start();
                        
                        $con = new PDO('mysql:host=localhost;dbname=.the_library', 'root', '');
                        // $cmd = 'SELECT acervo FROM emprestimo WHERE usuario = (SELECT codigo FROM usuario WHERE nome =' . $_SESSION['txtNome'] . ')';
                        $cmd = 'SELECT acervo FROM emprestimo WHERE usuario = (SELECT codigo FROM usuario WHERE nome = "juan")';
                        $res = $con->query($cmd);
                        $data = $res->fetchAll(PDO::FETCH_ASSOC);

                        echo '
                            <tr>
                                <th>Acervo</th>
                            </tr>
                        ';
                        
                        foreach($data as $vetor) {
                            foreach($vetor as $campo => $valor) {
                                $cmd = 'SELECT nome FROM acervo WHERE codigo =' . $valor;
                                $cavalo = $con->query($cmd);
                                $infos = $cavalo->fetchAll(PDO::FETCH_ASSOC);
                                
                                foreach($infos as $coisas) {
                                    foreach($coisas as $futebol => $gol) {
                                        echo '
                                            <tr>
                                                <td>' . $gol . '</td>
                                            </tr>
                                        ';
                                    }
                                }
                            }
                        }
                    ?>
                </table>
            </div>
        </div>
    </body>

    <script src="JS/Index.js"></script>
</html>