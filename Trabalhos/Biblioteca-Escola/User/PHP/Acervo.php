<?php 
    try{
        // var = new PDO('mysqli: host = ip/localhost; dbname = nome do banco', 'usuario', 'senha')
        $oCon = new PDO('mysql:host=localhost;dbname=.the_library', 'root', '');
    } catch(PDOException $oErro) {
        die($oErro -> getMessage());
    }
?>

<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../CSS/Acervo.css">
        <link rel="shortcut icon" href="../IMG/FundoRoxo.png" type="image/png">
        <title>The Library | Acervo</title>
    </head>

    <body>
        <header>
            <img src="../IMG/LogoBranco.png" alt="Logo">
            <h1>Acervos</h1>
        </header>
        
        <main>
            <a href="../index.php"><img src="../IMG/seta-para-a-esquerda.png" alt=""></a>
            <section>
            <?php
                $cSQL = "SELECT acervo.codigo, acervo.nome, autor.nome autor FROM acervo LEFT JOIN autor ON autor.codigo=acervo.autor;";
                $oReg = $oCon->query($cSQL)->fetchAll(PDO::FETCH_ASSOC);

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
    </body>

    <script src="../JS/Acervo.js">
        //Sei la
    </script>
</html>