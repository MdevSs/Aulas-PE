<?php
    $con = mysqli_connect("localhost", "root", "", "banco2ds");
    if(isset($_POST["nome"])){
        $nome = $_POST["nome"];
        $categoria = $_POST["categoria"];
        $autor = $_POST["autor"];
        $editora = $_POST["editora"];
        $genero = $_POST["genero"];
        $insertAcervo = "INSERT INTO acervo(nome, categoria, autor, editora, genero) values ('$nome', '$categoria', '$autor', '$editora', '$genero')";

        mysqli_query($con, $insertAcervo);

        var_dump($_FILES['imagem']['tmp_name']);
        var_dump($_FILES['imagem']['name']);
        move_uploaded_file($_FILES['imagem']['tmp_name'], '../IMG/Acervos/FOTO'. str_replace('..', '.' ,mysqli_insert_id($con) .'.'. substr($_FILES['imagem']['name'], -4)));

        
    }
?>

<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="../CSS/Acervo.css">
        <link rel="shortcut icon" href="../IMG/LogoBranco.png">
        <title>Acervo</title>
    </head>

    <body>

        <div class="section-images">
            <div class="border">
                <div class="content">
                    <div class="content-button">
                        <button id="switch-button">Cadastrar Novo Acervo</button>
                    </div>
                    <div class="content-images">
                        

                        <?php
                        
                        $cmd = "SELECT acervo.codigo Codigo, acervo.nome Livro, autor.nome Autor, genero.nome Genero from acervo left join autor on autor=autor.codigo left join genero on acervo.genero = genero.codigo;";

                        $oRes = mysqli_query($con, $cmd);

                        while($linha = mysqli_fetch_assoc($oRes))
                        {
                            echo '<div class="Acervo">
                                <div class="Acervo-img">

                                    <img src="..\IMG\Acervos\FOTO'. $linha['Codigo'] .'.png" alt="capa" onError="this.src=\'..\'IMG\Acervos\ErrorImage.png\'" />
                                    
                                </div>
                                <div class="Acervo-content">
                                    <h1>'. $linha['Livro'] .'</h1>
                                    <h2>'. $linha['Autor'] .'</h2>
                                    <h3>'. $linha['Genero'] .'</h3>
                                </div>
                            </div>';
                        }

                        ?>
                        
                    </div>
                </div>
            </div>
        </div>

        <div class="section-1">
            <form method="POST" enctype="multipart/form-data">
                <h1><strong>Acervo</strong></h1>

                <div class="nome">
                    <input type="text" name="nome" placeholder="nome">
                </div>

                <div class="categoria">
                    <select name="categoria">
                        <option value="1">Livro</option>
                        <option value="2">Revista</option>
                        <option value="3">Jornal</option>
                    </select>
                </div>

                <div class="autor">
                    <select name="autor">
                        <?php
                            $select = "SELECT codigo, nome FROM autor";
                            $execute = mysqli_query($con, $select);

                            while($row = mysqli_fetch_assoc($execute)){
                                echo '<option value="' . $row["codigo"] . '">' . $row["nome"] . '</option>';
                            }
                        ?>
                    </select>

                    <a href="Autor.php">Novo autor</a>
                </div>

                <div class="editora">
                    <select name="editora">
                        <?php
                            $select = "SELECT codigo, nome FROM editora";
                            $execute = mysqli_query($con, $select);

                            while($row = mysqli_fetch_assoc($execute)){
                                echo '<option value="' . $row["codigo"] . '">' . $row["nome"] . '</option>';
                            }
                        ?>
                    </select>

                    <a href="Editora.php">Nova editora</a>
                </div>

                <div class="genero">
                    <select name="genero">
                        <?php
                            $select = "SELECT codigo, nome FROM genero";
                            $execute = mysqli_query($con, $select);

                            while($row = mysqli_fetch_assoc($execute)){
                                echo '<option value="' . $row["codigo"] . '">' . $row["nome"] . '</option>';
                            }
                        ?>
                    </select>

                    <a href="Genero.php">Novo genero</a>
                </div>

                <div class="imagem">
                    <h2>Envie uma imagem</h2>
                    <input type="file" name="imagem" accept="image/png,image/jpg" id="inp-imagem" >
                </div>

                <button>Enviar</button>
            </form>
        </div>

    <?php 
        mysqli_close($con);
    ?>

    <script src="../JS/Acervo.js" ></script>

    </body>
</html>