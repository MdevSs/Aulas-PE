<?php 
    try{
        // var = new PDO('mysqli: host = ip/localhost; dbname = nome do banco', 'usuario', 'senha')
        $oCon = new PDO('mysql: host=localhost; dbname=GRUPO02', 'Aluno02-B', 'Aluno02.2DS');
    } catch(PDOException $oErro) {
        die($oErro -> getMessage());
    }




?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../IMG/FundoRoxo.png" type="image/png">
    <link rel="stylesheet" href="../CSS/Acervo.css">
    <title>Document</title>
</head>
<body>
    <header>
        <img src="../IMG/LogoBranco.png" alt="Logo">
        <h1>Acervos</h1>
    </header>
    <main>
        <a href="../index.htm"><img src="../IMG/seta-para-a-esquerda.png" alt=""></a>
        <section>
        <?php 
        
            $cSQL = "SELECT acervo.codigo, acervo.nome, autor.nome autor FROM acervo LEFT JOIN autor ON autor.codigo=acervo.autor;";
            
            // $oReg = $oCon -> query($cSQL);
            // $oReg = $oReg -> fetchAll(PDO::FETCH_ASSOC);

            // $oReg = $oCon -> query($cSQL)->fetchAll(PDO::FTECH_ASSOC);
            
            // PDO::FETCH_ASSOC
            // PDO::FETCH_NUM
            // PDO::FETCH_BOTH
            // PDO::FETCH_COLUMN


            foreach($oCon -> query($cSQL)->fetchAll(PDO::FETCH_ASSOC) as $oReg)
            {
                echo '<div class="livro">
                    <img src="../../Adm/IMG/Acervos/FOTO'. $oReg['codigo'] .'.png" alt="obra">
                    <h2>'. $oReg['nome'] .'</h2>
                    <h4>'. $oReg['autor'] .'</h4>
                    <img src="../IMG/stars.png" alt="avaliacao" data-n-valor="'. $oReg['codigo'] .'" onClick="fnAvalia(this, event)">
                </div>';
                
            }
            
            $oCon = null;
            ?>
        </section>
    </main>

    <script>

        function fnAvalia(oImagem, e){
            console.log(e);
            console.log(oImagem);

            let nPor = e.offsetX/e.target.offsetWidth;
            nPor = nPor.toFixed(1)*100;
            console.log(nPor)
            console.log("linear-gradient(to right, #FFF000 "+ nPor +"%, transparent "+ nPor +"%)")
            oImagem.style.background = "linear-gradient(to right, #FFF000 "+ nPor +"%, transparent "+ nPor +"%)";

            console.log(oImagem.dataset.nValor);

            let nPontos = 0;

            if(nPor < 20)
                nPontos = 1;
            else if(nPor < 40)
                nPontos = 2;
            else if(nPor < 60)
                nPontos = 3;
            else if(nPor < 80)
                nPontos = 4;
            else if(nPor < 100)
                nPontos = 5;

            

            // oDados = {
            //     "nObra": parseInt(oImagem.dataset.nValor),
            //     "nNota": nPontos
            // };
            
            oForm = new FormData();
            oForm.append("nObra", oImagem.dataset.nValor);
            oForm.append("nNota", nPontos);


            fetch('avaliar.php', {'method': 'POST', 'body': oForm})
                .then(oResposta=>oResposta.json())
                .then(oRes=>console.log(JSON.parse(oRes)))
                .catch(oError=>console.log(oError));
                

        }

        // function fnSeleciona(e)
        // {
        //  console.log(e);   
        // }

    </script>

</body>
</html>