<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

    <style>
    *{
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }
    body{
        background: linear-gradient(to right, aquamarine, #FAFAFA);
        width: 100vw;
        height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 200px;
    }
    form
    {
        display: inherit;
        gap: 100px;
        background-color: rgba(2, 2, 2, 0.096);
        backdrop-filter: blur(20px); 
        flex-direction: column;
        padding: 50px;
        border-radius: 12px;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.329);
    }
    
    form>div{
        display: inherit;
        flex-direction: column;
    }
    </style>

    
    <form action="form.php" method="post">
        <div>
            <label for="">Nome do Cargo</label>
            <input type="text" name="txtNome">
        </div>

        <button>Enviar</button>
    </form>

    <form action="form2.php" method="post">
        <div>
            <label for="">Nome Funcionario  </label>
            <input type="text" name="txtFunNome">
        </div>

        <div>
            <label for="">Cargo</label>
            
            <select name="txtCargo">
            <option value="0">...</option>
            <?php
                
                //conecta o codigo ao banco
                $oCon = mysqli_connect('localhost', 'Aluno2DS', 'SenhaBD2', 'BANCOCOMUM');
                

                //verifica se o input nao e null
          
                    //cria uma variavel com o texto concatenado a variavel a ser enviada ao banco
                    $tConsult = "SELECT * FROM `CARGOS06`";

                    //envia o contudo da variavel ao banco de dados
                    $oCmd = mysqli_query($oCon, $tConsult);

                    
                    while($oReg = mysqli_fetch_assoc($oCmd))
                    {
                        echo '<option value='. $oReg['CGSCODIGO'] .'>'.$oReg['CGSNOME'].'</option>';
                    }


        
                //encerra a conexao pra nn dar ruim no banco
                mysqli_close($oCon);
        
        ?>

            </select>
        </div>

        <button>Enviar</button>
    </form>

</body>
</html>

