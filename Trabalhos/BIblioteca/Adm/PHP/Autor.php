<?php
    if(isset($_GET["txtNome"])){
        $autor = $_GET["txtNome"];
        $con = mysqli_connect("localhost", "root", "", ".library");
        $insertAutor = "INSERT INTO autor(nome) VALUES ('$autor')";
        
        mysqli_query($con, $insertAutor);
    }
?>

<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="../CSS/Autor.css">
        <link rel="shortcut icon" href="../IMG/LogoRoxo.png">
        <title>Acervo</title>
    </head>

    <body>
        <div class="section-1">
            <form>
                <h1><strong>Autor</strong></h1>

                <input type="text" name="txtNome" placeholder="nome">

                <button>gravar</button>
            </form>
        </div>
    </body>
</html>