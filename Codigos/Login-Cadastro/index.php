<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro | Login</title>
</head>
<body>
    
    <style>
        *{
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body{
            width: 100vw;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        main{
            width: 40%;
            display: inherit;
            flex-direction: column;
            align-items: center;
            gap: 30px;
            border-radius: 15px;
            background-color: blueviolet;
            color: white;
            padding: 20px 0px 0px 0px;
            box-shadow: 0px 0px 20px #05050550;
        }
        main div{
            background-color: #FAFAFA;
            width: 100%;
            height: 100%;
            padding: 20px;
            color: black;
            border-radius: 0px 0px 15px 15px;
        }
        main div form{
            align-items: stretch;
            width: 100%;
            display: flex;
            flex-direction: column;
            gap: 40px;
            min-height: 300px;
            justify-content: space-evenly;
        }
        label{
            display: inherit;
            flex-direction: column;
        }
        input{
            height: 30px;
            border: none;
            outline: 1px solid black;
            border-radius: 5px;
            padding: 10px;
        }
        button{
            width: 55%;
            margin: 0 auto;
            height: 40px;
            border: none;
            background-color: blueviolet;
            color: white;
            border-radius: 13px;
            font-weight: normal;
            transition:all 0.3s ease-in-out;
            font-weight: bold;
            cursor: pointer;
            font-size: large;
        }
        button:hover{
            transform: scale(110%);
        }
        p{
            margin: 0 auto;
        }
        p span{
            color: #3388EE;
        }
        p span:hover{
            text-decoration: underline;
            cursor: pointer;
        }
    </style>

    <main>

        <h2> Cadastro </h2>

        <div id="Cad">
            <form method="post" action="account.php">
                <input type="hidden" name="id" value="cad">
                <label for="txtNome"> 
                    Usuario
                    <input name="txtNome" type="text">
                </label>

                <label for="txtSenha">
                    Senha
                    <input name="txtSenha" type="password">
                </label>
                
                <button type="submit">Cadastrar</button>
                <p> Já tem uma conta? <span id="toogle" onclick="fnToogle(event)">Faça Login</span></p>
            </form>
        </div>
        <div id="Log" style="display: none;">
                <form method="POST" action="account.php">
                    <input type="hidden" name="id" value="log">

                    <label for="txtEmail">
                        Nome
                        <input type="text" name="txtNome">
                    </label>
                    
                    <label for="txtSenha">
                        Senha
                        <input name="txtSenha" type="password">
                    </label>
                    <button type="submit">Login</button>
                    <p> Desistiu? <span id="toogle" onclick="fnToogle(event)">VAI pro Cadastro de novo, BURRO!</span></p>
                </form>
        </div>
    </main>

    <script>

        oCad = document.querySelector('#Cad');
        oLog = document.querySelector('#Log');
        obtn = document.querySelector('#toogle')
        oTi = document.querySelector('h2');

        console.log(oCad);
        console.log(oLog);

        function fnToogle(e){
            console.log(oCad.style.display);
            // if(e.target)
            if(oCad.style.display != 'none'){
                oCad.style.display = "none";
                oLog.style.display = "flex";
                oTi.innerText = "Login";
            }else{
                oCad.style.display = "flex";
                oLog.style.display = "none";
                oTi.innerText = "Cadastro";
            }
        }

    </script>


</body>
</html>