<?php 

try{
    // var = new PDO('mysqli: host = ip/localhost; dbname = nome do banco', 'usuario', 'senha')
    $oCon = new PDO('mysql: host=localhost; dbname=biblioteca', 'root', '');
} catch(PDOException $oErro) {
    die($oErro -> getMessage());
}

if(isset($_POST['nNota'])){

    $vDados = array(
        'nObra'=>intval($_POST['nObra']),
        'nNota'=>intval($_POST['nNota']),
        'IP'=> $_SERVER['REMOTE_ADDR']
    );

    echo(json_encode($vDados));

    $cSQL="INSERT INTO `avaliacao`(`AVAIP`, `AVAOBRA`, `AVANOTA`) VALUES (:IP,:nObra,:nNota) ON DUPLICATE KEY UPDATE AVANOTA = :nNota";

    $oCmd = $oCon -> prepare($cSQL);

    $oCmd -> execute($vDados);

    if($oCmd->execute($vDados)){
        echo '{"status": 0, "mensagem": "Gravado"}';
    }else
        echo '{"status": -98, "mesangem": "Erro: '. $oCmd->errorInfo()[2] .'"}';

} else
    die('{"status": -99, "mesangem": "Configuração inválida"}');

?>
