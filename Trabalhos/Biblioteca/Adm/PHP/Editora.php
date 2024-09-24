<?php
    if(isset($_GET["txtNome"])){
        $editora = $_GET["txtNome"];
        $con = mysqli_connect("localhost", "Aluno02-B", 'Aluno02.2DS', "GRUPO02");
        $insertEditora = "INSERT INTO editora(nome) VALUES ('$editora')";

        mysqli_query($con, $insertEditora);
    }
?>

<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="../CSS/Editora.css">
        <link rel="shortcut icon" href="../IMG/LogoRoxo.png">
        <title>Acervo</title>
    </head>

    <body>
        <div class="section-1">
            <form>
                <h1><strong>Editora</strong></h1>

                <input type="text" name="txtNome" placeholder="nome">

                <button>gravar</button>
            </form>
        </div>
    </body>
</html>