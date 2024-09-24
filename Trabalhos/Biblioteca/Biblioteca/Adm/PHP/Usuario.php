<?php
    if(isset($_GET["txtNome"])){
        $nome = $_GET["txtNome"];
        $senha = $_GET["txtSenha"];
        $con = mysqli_connect("localhost", "root", "", ".library");
        $insertUsuario = "INSERT INTO usuario(nome, senha) VALUES('$nome', MD5('$senha'))";
        
        mysqli_query($con, $insertUsuario);

        mysqli_close($con);
    }
?>

<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="../CSS/Usuario.css">
        <link rel="shortcut icon" href="../IMG/Logo.png">
        <title>Cliente</title>
    </head>

    <body>
        <div class="section-1">
            <form>
                <h1><strong>Usuario</strong></h1>

                <div class="nome">
                    <input type="text" name="txtNome" placeholder="nome">
                </div>

                <div class="telefone">
                    <input type="text" name="txtSenha" placeholder="senha">
                </div>

                <button>Cadastrar</button>
            </form>
        </div>
    </body>
</html>