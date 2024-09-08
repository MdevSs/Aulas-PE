<?php
    if(isset($_GET["txtUsuario"])){
        $usuario = $_GET["txtUsuario"];
        $senha = $_GET["txtSenha"];
        $conexao = mysqli_connect("localhost", "root", "", "banco2ds");
        $select = "SELECT nome,senha FROM funcionario WHERE nome = '$usuario' AND senha = MD5('$senha')";
        $execute = mysqli_query($conexao, $select);
        
        if(mysqli_num_rows($execute) != 0){
            header("Location: ../PHP/Home.php");
        }
        else{
            header("Location: ../HTML/Login.htm");
        }
    }
?>