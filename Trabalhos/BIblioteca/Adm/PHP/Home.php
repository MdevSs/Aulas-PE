<?php
        // $oCon = mysqli_connect('localhost', 'Aluno02-B', 'Aluno02.2DS', 'GRUPO02');
        $oCon = mysqli_connect('localhost', 'root', '', 'banco2ds');
        $oCmd = "SELECT COUNT(DATAINICIO), ACERVO.NOME, CONCAT('rgb(', FLOOR(RAND()*255), ', ', FLOOR(RAND()*255), ', ', FLOOR(RAND()*255), ', 0.5)') FROM EMPRESTIMO LEFT JOIN ACERVO ON ACERVO = ACERVO.CODIGO GROUP BY NOME";


        $oRes = mysqli_query($oCon, $oCmd);
        
        $nValores=array();
        $nLabels=array();
        $nCores=array();
        
        $i=0;
        while($oLinha=mysqli_fetch_array($oRes, MYSQLI_NUM)){
            $nValores[intval($i)]=$oLinha[0];
            $nLabels[$i]=$oLinha[1];
            $nCores[$i]=$oLinha[2];
            $i++;
        }
    ?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../CSS/Home.css">
    <link rel="shortcut icon" href="../img/favicon-home.png" type="image/png">
    <title>Home - Biblioteca | Library</title>
</head>
<body>
    
    <header>
        <h1>Biblioteca</h1>
    </header>

    <main> 
        <div id="form-dad">
            <div id="form-content">
                <div id="formularios">
                    <h2>Formulários</h2>
                    <article>
                        <a href="../PHP/Acervo.php">
                            <section>
                                Acervo
                            </section>
                        </a>
                        <a href="../PHP/Usuario.php">
                            <section>
                                Usuario
                            </section>
                        </a>
                
                        <a href="../PHP/Emprestimo.php">
                            <section>
                                Emprestimo
                            </section>
                        </a>
                    </article>
                </div>
            </div>
            <div class="datas">
                    Grafico
                <div id="canvas-content">
                    <canvas id="Chart"></canvas>
                </div>                

            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        const oChart = document.getElementById('Chart');

        /*new Chart(oChart, {
            type: 'bar',
            data: {
                labels: <?= json_encode($nLabels); ?>,
                datasets: [{
                    label: 'Emprestimos',
                    data: <?= json_encode($nValores); ?>,
                    backgroundColor: <?= json_encode($nCores) ?>,
                    borderWidth: 1
              }]
            },
            options: {
              scales: {
                y: {
                    beginAtZero: true
                }
              }
            }
        })*/

        new Chart(oChart, {
            type: 'bar',
            data: {
                labels: <?= json_encode($nLabels); ?>,
                datasets: [{
                        label: 'N° de Emprestimos',
                        data: <?= json_encode($nValores) ?>,
                        backgroundColor: <?= json_encode($nCores); ?>,  
                        borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        suggestedMax: 15,
                        sugesttedMin: 1
                    }
                }
            }
  });

    </script>
    

    <?php

    mysqli_close($oCon);

    ?>

</body>
</html>