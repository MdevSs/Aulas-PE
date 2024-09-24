<?php
    if(isset($_GET["txtCep"])){
        $oEndereco = $_GET['oEndereco'];
        $oCasa = $_GET['oCasa'];
        $oLogradouro = $_GET['oLogradouro'];
        $oBairro = $_GET['oBairro'];
        $oCidade = $_GET['oCidade'];
        $oEstado = $_GET['oEstado'];
        $oConBiblioteca = mysqli_connect('localhost', 'root', '', '.library');
        $oComInsertCep = "INSERT INTO cep (CEPVALOR, CEPLOGRADOURO, CEPNUMERO, CEPBAIRRO, CEPCIDADE, CEPESTADO) VALUES ('$oEndereco', '$oLogradouro', '$oCasa', '$oBairro', '$oCidade', '$oEstado')";

        mysqli_query($oConBiblioteca, $oComInsertCep);

        mysqli_close($oConBiblioteca);
    }
?>

<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="../CSS/Endereco.css">
        <link rel="shortcut icon" href="../IMG/LogoBranco.png">
        <title>Cliente</title>
    </head>

    <body>
        <div class="section-1">
            <form>
                <h1><strong>Endereço</strong></h1>

                <div class="endereco">
                    <input type="text" name="txtCep" placeholder="cep" onkeyup="if(this.value.length == 8) endereco(this.value)">

                    <input type="text" name="txtCasa" placeholder="n° da casa">
                </div>

                <label class="resposta"></label>

                <div class="auxiliar">
                    <input type="text" name="txtLogradouro" class="logradouro">
                    
                    <input type="text" name="txtBairro" class="bairro">

                    <input type="text" name="txtCidade" class="cidade">

                    <input type="text" name="txtEstado" class="estado">
                </div>

                <button>Enviar</button>
            </form>
        </div>
    </body>

    <script src="../JS/Endereco.js"></script>
</html>