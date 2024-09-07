<?php
    $oCon = new PDO('mysql:host=localhost; dbname=BANCOCOMUM', 'Aluno2DS', 'SenhaBD2');

    if(isset($_POST['txtNota'])) {
        $vDados = array('USUARIO'=> $_SERVER["REMOTE_ADDR"],
                        'OBRA'=> (int)$_POST['txtObra'],
                        'NOTA'=> (int)$_POST['txtNota']);
        $oCmd = $oCon -> prepare("INSERT INTO OBRAS_AVALIACAO(AVLUSUARIO, AVLOBRA, AVLNOTA) VALUES(:USUARIO, :OBRA, :NOTA) ON DUPLICATE KEY UPDATE AVLNOTA = :NOTA");
        $oCmd->execute($vDados);

        if($oCmd->execute($vDados)){=
            echo '{"status": 0, "mensagem": "Gravado"}';
        }else
            echo '{"status": -98, "mesangem": "Erro: '. $oCmd->errorInfo()[2] .'"}';
    }
    else  
        die('{"status": -99, "mesangem": "Configuração inválida"}');
?>