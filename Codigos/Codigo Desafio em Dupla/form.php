<?php

    //conecta o codigo ao banco
    $oCon = mysqli_connect('localhost', 'Aluno2DS', 'SenhaBD2', 'BANCOCOMUM');
    
    //verifica se o input nao e null
    if(isset($_POST['txtNome'])==true)
    {
        // cria uma variavel com o valor do input
        $txtNome = $_POST['txtNome'];


        //cria uma variavel com o texto concatenado a variavel a ser enviada ao banco
        $tConsult = "INSERT INTO CARGOS06(CGSNOME) VALUES('". $txtNome ."')";

        //envia o contudo da variavel ao banco de dados
        $oCmd = mysqli_query($oCon, $tConsult);

        //mostra e descreve a variavel
        var_dump($oCmd);


    }
    
    //encerra a conexao pra nn dar ruim no banco
    mysqli_close($oCon);

?>