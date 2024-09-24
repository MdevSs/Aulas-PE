
<?php
    // Abre conexão

    // Se der B.O FUDEU
    try{
        $oCon = new PDO('mysql: host=localhost; dbname=biblioteca','root', '');
    }catch(PDOException $oErro){
        echo "Houve um erro: <br>";
        die($oErro->getMessage());
    }

    $vDados = array(
        'txtNome' => $_POST['txtNome'],
        'txtSenha' => $_POST['txtSenha']
    );



    $oRes;


    // Inicia um SESSION
    session_start();


    // Testa pra saber qual formulário que ta chamando esse arquivo

    // Se for 'cad' é um Cadastro
    // Se for 'log' é um Login
    switch($_POST['id']){
        case 'cad':
            // debug
                echo 'Cadastro <br>';

                // Comando criando novo registro
                $cSQL = "INSERT INTO usuario(nome,senha) VALUES(:txtNome, MD5(:txtSenha))";

                // prepara a String
                $oCmd = $oCon -> prepare($cSQL);
                echo '<br>';
                
                // debug
                var_dump($vDados);

                // Tenta Executar o comando e trocar de pagina
                try{
                    $oRes = $oCmd -> execute($vDados);

                    if($oRes == true)
                    {
                        $_SESSION['txtNome'] = $vDados['txtNome'];
                        header('Location: ../../User/index.htm');
                    }else{
                            
                        }
                }catch(PDOException $e){

                    // Caso de errado ele dá uma saída de erro coerente
                    if(strpos($e, '23000') != false)
                        echo '<h1>Já existe um usuário com esse nome</h1>';
                    die('Erro'. $e);
                }
                
                // debug
                var_dump($oRes);

                // Se o  
                

            break;
        

            

        case 'log':
                echo 'Login <br>';

                // Consultando pra vê se existe esse usuario
                $cSQL = "SELECT acesso, nome, senha FROM usuario WHERE nome = '". $vDados['txtNome'] ."' AND senha = MD5('". $vDados['txtSenha'] ."');";

                // debug
                var_dump($cSQL);
                echo '<br>';
                var_dump($vDados);
                echo '<br>';
                
                
                // Executa, atribui e busca a consulta ja organizada    
                $oRes = $oCon->query($cSQL)->fetchAll(PDO::FETCH_ASSOC);
                
                // debug
                var_dump($oRes);
                
                // Reatribuo a variavel pois era um vetor, onde o pirmeiro índice que continha os registros organizados 
                $oRes = $oRes[0];

                // debug
                var_dump($oRes['acesso']);
                
                // Testo pra saber se teve algum registro que foi trazidos
                if(count($oRes) > 0)
                {   
                    echo '<br>Acessou!<br>'; 

                    // Testo pra saber qual o nivel de acesso
                        if($oRes["acesso"] == '0'){
                            $_SESSION['txtNome'] = $vDados['txtNome'];
                            
                            // debug
                            var_dump($_SESSION['txtNome']);

                            // Troco de pagina
                            header('Location: ../../User/index.htm');
                        }else{
                            header('Location: ../PHP/Home.php');
                        }
                }else{
                    // Se não jogo erro na tela
                    echo '<h1> NÃO EXISTE USUARIO COM ESSE NOME </h1>';
                }
                // var_dump($oReg);

            break;
        default:
            die("Forma de accessar inválida");
        break;
        }   


    $oCon = null;
?>