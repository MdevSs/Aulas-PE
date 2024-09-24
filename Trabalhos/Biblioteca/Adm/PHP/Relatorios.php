<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/Relatorios.css">
    <title>Relatórios | Biblioteca</title>
</head>
<body>
    <main>
        <!-- barra lateral -->
        <div class="side-bar">
            <button class="openButton"><i class="fa-solid fa-chevron-right"></i></button>
            <!-- tabelas -->
            <div class="tables">
                <h2> Tabelas </h2>
                <div class="tables-buttons">
                    <button class="toogle-button tables toogleOn" data-tipo="usuario"> <i class="fa-solid fa-user"></i> Usuarios </button>
                    
                    <button class="toogle-button tables off" data-tipo="acervo"> <i class="fa-solid fa-book"></i> Acervos </button>
                    <button class="toogle-button tables off" data-tipo="autor"> <i class="fa-solid fa-pen-nib"></i> Autor </button>
                    <button class="toogle-button tables off" data-tipo="emprestimo"> <i class="fa-solid fa-tag"></i> Empréstimo </button>
                </div>
            </div>
            <!-- relatórios -->
            <div class="reports">
                <h2> Relatórios </h2>
                
                <button class="toogle-button relatorio off" value="1" data-tipo="1">
                    <i class="fa-solid fa-circle"></i> 
                    Mostrar Obras 
                </button>

                <button class="search relatorio off" value="1">
                    <div class="search-header">
                        
                        <span> <i class="fa-solid fa-circle"></i> Mais Emprestados</span>
                        <i class="fa-solid fa-chevron-right"></i>
                    </div>

                    <form id="form-radios">
                        <label for="">
                            <span>Somente Emprestados</span>
                            <input type="radio" class="relatorio" name="type" value="1" data-tipo="5">
                        </label>
                        
                        <label for="">
                            <span>Emprestados e Devolvidos</span>
                            <input type="radio" class="relatorio" name="type" value="2" data-tipo="5">
                        </label>
                    </form>
                    
                </button>

                <button class="search relatorio">
                    <div class="search-header">
                        
                        <span> <i class="fa-solid fa-circle"></i> Livros Relacionados</span>
                        <i class="fa-solid fa-chevron-right"></i>
                    </div>
                    <form>
                        
                        <!-- <input data-tipo="2" type="search" placeholder="Digite o código de um Livro"> -->
                         <select data-tipo="2" class="relatorio">
                            <?php
                            
                                $oCon = new PDO('mysql: host=localhost; dbname=GRUPO02', 'Aluno02-B', 'Aluno02.2DS');

                                $cSQL = "SELECT codigo, nome FROM acervo";

                                $oRes = $oCon->query($cSQL)->fetchAll(PDO::FETCH_ASSOC);

                                foreach($oRes as $indice => $valor)
                                {
                                    echo '<option value='. $valor['codigo'] .'>'. $valor['nome'] .'</option>';
                                }

                            ?>
                         </select>
                    </form>
                </button>

                <button class="search relatorio">
                    <div class="search-header">
                        
                        <span> <i class="fa-solid fa-circle"></i>Porcentagem de emprestimo</span>
                        <i class="fa-solid fa-chevron-right"></i>
                    </div>

                    <form>
                        <input data-tipo="3" type="search" placeholder="Digite o nome do(s) Usuario">
                    </form>
                </button>

                <button class="search relatorio">
                    <div class="search-header">
                        
                        <span> <i class="fa-solid fa-circle"></i> Pesquisa</span>
                        <i class="fa-solid fa-chevron-right"></i>
                    </div>

                    <form>
                        <input data-tipo="4" type="search" placeholder="Pesquise o nome de algo">
                    </form>
                </button>

                <button class="search relatorio" id="Emprestimo">
                    <div class="search-header">
                        
                        <span> <i class="fa-solid fa-circle"></i> Emprestimo</span>
                        <i class="fa-solid fa-chevron-right"></i>
                    </div>

                    <form data-tipo="6" id="form-emprestimo">

                        <label for="">Selecione o Intervalo</label>
                        <div class="interval">
                            <input type="date">
                            <input type="date">
                        </div>

                        <div id="button-submit">Gerar</div>
                    </form>

                </button>
                
                
                <!-- <button><i class="fa-solid fa-circle"></i> Livros Parecidos </button> -->
                <!-- <button><i class="fa-solid fa-circle"></i> Emprestimos </button> -->

            </div>
        </div>

        <!-- conteúdo -->
        <div class="content">
            <!-- barra do topo do conteúdo -->
             

            <div class="content-bar">
                <h2>Relatório de ...</h2>
                <!-- nela contém filtros (que só aparecem em empréstimos) -->
                <div class="filters">
                    <form action="" onsubmit="" >
                        <input type="search"> 
                    </form>
                    <i class="fa-solid fa-magnifying-glass"></i>
                </div>

                <!-- itens que apareceram na requisição -->
                <div class="content-itens">
                    <?php

                        $cSQL = "SELECT codigo, acesso, nome FROM usuario;";
                        global $oCon;
                        $oRes = $oCon->query($cSQL, PDO::FETCH_ASSOC)->fetchAll();

                        echo '<table>
                                <thead>
                                    <tr>';
                                
                        $Campos = array_keys($oRes[0]);         
                        foreach($Campos as $indice){                

                            echo '<th>'. strtoupper($indice) .'</th>';                       
                        
                        }

                        echo        '</tr>
                                </thead>
                                <tbody>';
                        foreach($oRes as $oReg){
                            echo '<tr>';
                            foreach($oReg as $indice => $nCampo){
                                if($indice == 'acesso')
                                {
                                    if($nCampo == 0)
                                        echo '<td> Usuario </td>';
                                    else
                                        echo '<td> <strong>Admin</strong> </td>';
                                }else
                                    echo '<td> '. $nCampo .' </td>';
                            }
                            echo '</tr>';
                        }
                        echo    '</tbody>
                            </table>';



                        // var_dump($oRes);

                        $oCon = null;
                    
                    ?>
                </div>
        </div>
    </main>

    <script src="https://kit.fontawesome.com/24e6b7f5c6.js" crossorigin="anonymous"></script>
    <script src="../JS/Relatorios.js"></script>

</body>
</html>