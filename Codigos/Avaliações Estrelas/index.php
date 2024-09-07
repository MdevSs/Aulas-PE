<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Imagens</title>
</head>

<body>
    <?php
    
        ini_set('display_errors', '1');
        error_reporting(E_ALL);

        $oCon = new PDO('mysql:localhost; dbname=BANCOCOMUM', 'Aluno2DS', 'SenhaBD2')
        $vCampos = ["txtNome"=> null, "txtCaminho"=> null, "txtInfo"=>null];

        if(isset($_POST['txtNome']))
        {
            foreach($vCampos as $nIndice => $cValor)
            {
                if(isset($_POST[$nIndice]))
                    if(trim($_POST($nIndice))!='')
                        $vCampos[$nIndice] = trim($_POST[$nIndice])

                if(isset($_FILES($nIndice)))
                    if(trim($_FILES[$nIndice]['name'])!='')
                        $vCampos[$nIndice] = trim($_FILES[$nIndice]['name'])
            }

                    // ... Falta adicionar mais código

                    // Adicionando...

                    $cSQL = "INSERT INTO OBRAS_ARTE(OBRNOME, OBRCAMINHO, OBRINFO) VALUES(:txtNome, :txtCaminho, :txtInfo)";

                    $oCmd = $oCon -> prepare($cSQL);
                    
                    if($oCmd->execute($vCampos))
                        move_uploades_file($_FILES['txtCaminho']['tmp_name'], $_FILES['txtCaminho']['name']);
                    else
                        echo 'Erro ao gravar obra: ' . $oCon->errorInfo()[2] . $oCmd->errorInfo()[2];
            }
    ?>

    <div id="Cadastro" style="display: none">
        <form class="frmPadrao" method="POST" enctype="multipart/form-data">
    
        <label>
            <span>Nome</span>
            <input type="text" name="txtNome">
        </label>

        <label>
            <span>Arquivo</span>
            <input type="file" name="txtCaminho">
        </label>

        <label>
            <span>Informações adicionais</span>
            <textarea name="txtInfo"></textarea>
        </label>
    
        <button> Gravar </button>
        </form>
    </div>

    <?php 
    
    $cSQL = "SELECT OBRCODIGO, OBRNOME, OBRCAMINHO, OBRINFO FROM OBRAS_ARTE";
    var_dump($oCon->query($cSQL, PDO::FETCH_ASSOC))
    
    foreach($oCon->query($cSQL, PDO::FETCH_ASSOC) as $vReg)
        echo '<div>
                <img src="' . $vReg['OBRCAMINHO  '] . '" onError="this.src="\'noimage\'"/>
                
                <span>' . $vReg['OBRNOME'] . '</span>
                
                <img id="objRank" src="estrelas.png" onClick="fnSeleciona(this.event)" data-codigo="'. $vReg['OBRCODIGO'] .'"\>
                
                <\div>';
    ?>

</body>

<script>

function fnSeleciona(oImagem, oEvt)
{
    let nPontos = 0;
    //console.log(Evt);

    if(oEvt.offsetX < 40)
        nPontos = 1;
    else 
        if(oEvt.offsetX < 80)
            nPontos = 2;
        else
            if(oEvt.offsetX < 120)
                nPontos = 3;
            else
            if(oEvt.offsetX < 160)
                nPontos = 4;
            else 
                nPontos = 5;

oImagem.style.background = 'linear-gradient(to right, #FF0000' + (nPontos * 2 * 100) + '%, transparent '+ (nPontos* 2 * 100) +')';

oAvaliacao = new FormData();
oAvaliacao.append('txtNota', nPontos);
oAvaliacao.append('txtObra', oImagem.dataset.codigo);

fetch('avaliando.php', {'method': 'POST', 'body': oAvaliacao})
    .then(oResposta=>oResposta.json())
    .then(oDados=>console.log(oDados))
    .catch(oErro=>alert(oErro));
}

</script>

</html>