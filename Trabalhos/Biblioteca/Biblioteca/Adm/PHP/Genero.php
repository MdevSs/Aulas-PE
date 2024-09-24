<?php
    if(isset($_GET["txtNome"])){
        $genero = $_GET["txtNome"];
        $con = mysqli_connect("localhost", "root", "", "biblioteca");
        $insertGenero = "INSERT INTO genero(nome) VALUES ('$genero')";
        
        mysqli_query($con, $insertGenero);
    }
?>

<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="../CSS/Genero.css">
        <link rel="shortcut icon" href="../IMG/LogoRoxo.png">
        <title>Genero</title>
    </head>

    <body>
        <div class="section-1">
            <form>
                <h1><strong>Genero</strong></h1>

                <input type="text" name="txtNome" placeholder="nome">

                <button>gravar</button>
            </form>
        </div>
    </body>
</html>