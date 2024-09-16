<?php
    if(isset($_GET["txtNome"])){
        $oNome = $_GET['txtNome'];
        $oPais = $_GET['oPais'];
        $oDDD = $_GET['oDDD'];
        $oNumero = $_GET['oNumero'];
        $oEndereco = $_GET['oEndereco'];
        $oCasa = $_GET['oCasa'];
        $oLogradouro = $_GET['oLogradouro'];
        $oBairro = $_GET['oBairro'];
        $oCidade = $_GET['oCidade'];
        $oEstado = $_GET['oEstado'];
        $oConBiblioteca = mysqli_connect('localhost', 'root', '', '.library');
        $oComInsertCep = "INSERT INTO cep (CEPVALOR, CEPLOGRADOURO, CEPNUMERO, CEPBAIRRO, CEPCIDADE, CEPESTADO) VALUES ('$oEndereco', '$oLogradouro', '$oCasa', '$oBairro', '$oCidade', '$oEstado')";
        $oComInsertTelefone = "INSERT INTO telefone (TELPREFIXO, TELDDD, TELNUMERO) VALUES ('$oPais', '$oDDD', $oNumero)";
        $oComInsertCliente = "INSERT INTO cliente (CLINOME, CLITELEFONE, CLICEP) VALUES ('$oNome', (SELECT TELCODIGO FROM telefone WHERE TELPREFIXO = '$oPais' AND TELDDD = '$oDDD' AND TELNUMERO = '$oNumero'), (SELECT CEPCODIGO FROM cep WHERE CEPVALOR = '$oEndereco' AND CEPLOGRADOURO = '$oLogradouro' AND CEPNUMERO = '$oCasa' AND CEPBAIRRO = '$oBairro' AND CEPCIDADE = '$oCidade' AND CEPESTADO = '$oEstado'))";

        mysqli_query($oConBiblioteca, $oComInsertCep);
        mysqli_query($oConBiblioteca, $oComInsertTelefone);
        mysqli_query($oConBiblioteca, $oComInsertCliente);

        mysqli_close($oConBiblioteca);
    }
?>

<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="../CSS/Usuario.css">
        <link rel="shortcut icon" href="../IMG/Logo.png">
        <title>Telefone</title>
    </head>

    <body>
        <div class="section-1">
            <form>
                <h1><strong>Telefone</strong></h1>

                <div class="telefone">
                    <input type="text" name="txtPais" placeholder="país">

                    <input type="text" name="txtDDD" placeholder="ddd">

                    <input type="text" name="txtNumero" placeholder="numero">
                </div>

                <div class="usuario">
                    <select name="usuario">
                        <?php
                            $con = mysqli_connect("localhost", "root", "", ".library");
                            $select = "SELECT codigo, nome FROM usuario";
                            $execute = mysqli_query($con, $select);

                            while($row = mysqli_fetch_assoc($execute)){
                                echo '<option value="' . $row["codigo"] . '">' . $row["nome"] . '</option>';
                            }
                        ?>
                    </select>
                </div>

                <button>Enviar</button>
            </form>
        </div>
    </body>
</html>