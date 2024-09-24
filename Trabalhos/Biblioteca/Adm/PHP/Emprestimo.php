<?php
    if(isset($_GET["txtUsuario"])){
        $cliente = $_GET["txtUsuario"];
        $acervo = $_GET["txtAcervo"];
        $inicio = $_GET["dtInicio"];
        $fim = $_GET["dtFim"];
        $con = mysqli_connect('localhost', 'Aluno02-B', 'Aluno02.2DS', 'GRUPO02');
        $insert = "INSERT INTO emprestimo(usuario, acervo, datainicio, datafim) VALUES('$cliente', '$acervo', '$inicio', '$fim')";
        mysqli_query($con, $insert);
        mysqli_close($con);
    }
?>

<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="../CSS/Emprestimo.css">
        <link rel="shortcut icon" href="../IMG/Logo.png">
        <title>Emprestimo</title>
    </head>

    <body>
        <div class="section-1">
            <div id="content">
                <form>
                    <h1><strong>Emprestimo</strong></h1>
                    <div class="cliente">
                        <select name="txtUsuario">
                            <?php
                                $con = mysqli_connect('localhost', 'Aluno02-B', 'Aluno02.2DS', 'GRUPO02');
                                $select = "SELECT * FROM usuario";
                                $res = mysqli_query($con, $select);
                                while($row = mysqli_fetch_assoc($res)) {
                                    echo '<option value="' . $row['codigo'] . '">' . $row['nome'] . '</option>';
                                }
                                mysqli_close($con);
                            ?>
                        </select>
                    </div>
                    <div class="acervo">
                        <select name="txtAcervo">
                            <?php
                                $con = mysqli_connect('localhost', 'Aluno02-B', 'Aluno02.2DS', 'GRUPO02');
                                $select = "SELECT * FROM acervo";
                                $res = mysqli_query($con, $select);
                                while ($row = mysqli_fetch_assoc($res)) {
                                    echo '<option value="'. $row['codigo'] . '">' . $row['nome'] . '</option>';
                                }
                                mysqli_close($con);
                            ?>
                        </select>
                    </div>
                    <div class="inicio">
                        <label>Data inicial</label>
                        <input type="date" name="dtInicio">
                    </div>
                    <div class="inicio">
                        <label>Data final</label>
                
                        <input type="date" name="dtFim">
                    </div>
                    <button>Enviar</button>
                </form>
                <a href="Home.php">Voltar</a>
            </div>
        </div>
    </body>
</html>