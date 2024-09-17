<?php 
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    //A turma B nao sabia usar isso, conversei com o um colega da Turma A e ele falou que precisa disso para retornar o resultado em JSON
    header("Acess-Control-Allow-Origin:: *");

    $oCon = new PDO('mysql:host=localhost;dbname=biblioteca','root', '');
    // $oCon = new PDO('mysql:host=localhost;dbname=biblioteca','Aluno02-B', 'Aluno02.2DS');  *conexão com o servidor da escola

    function fnMostrarLivros()
    {
        global $oCon;
        // deixando a variavel 'global' para reutilizar ela em outros escopos

        $cSQL="SELECT acervo.codigo, acervo.nome, CONCAT(SUBSTRING_INDEX(autor.nome, ' ', -1), ', ', RTRIM(REPLACE(autor.nome, SUBSTRING_INDEX(autor.nome, ' ', -1), ''))) Autor FROM acervo INNER JOIN autor ON acervo.autor = autor.codigo ORDER BY RAND() LIMIT 10";
        // consulta
        

        $oRes=$oCon->query($cSQL, PDO::FETCH_ASSOC)->fetchAll();
        // executando a consulta

        $oArray = array();
        $oArray = $oRes;
        return json_encode($oArray);

        // fazendo uma tabela: APENAS PARA TESTAR SE ESTA FUNCIONANDO
        // echo '<table>
        //         <thead>
        //             <tr>
        //                 <th> Codigo </th>
        //                 <th> Livro </th>
        //                 <th> Autor </th>
        //             </tr>
        //         </thead>
        //     <tbody>';

        // print_r($oRes); saida de Debug

        // PARA CADA ELEMENTO DO $oRes, indice $oReg, Valoresna variavel $oLinha
        // foreach($oRes as $oReg => $oLinha)
        // {
        //     // print_r($oLinha); saida de debug

        //     echo '<tr>';
        //     // Variavel $oLinha e um array, entao refazemos o foreach
        //     foreach($oLinha as $oCampo => $oValor){
                
        //         echo('<td>'.$oValor.'</td>');
                
        //     }
        //     echo '</tr>';
        // }
        // // fechou o corpo da tabela e mesma
        // echo '</tbody>
        //     </table>';

        // funcao retornando o resultado da consulta em JSON 
        // return json_encode($oRes);
       
    }
    // EXECUTA A BENDITA
    // fnMostrarLivros();







    function fnLivrosParecidos(int $oCod)
    {
        // Mesma coisa, nao vou comentar de novo em coisas que se repetem
        global $oCon;

        $cSQL="SELECT livro.nome FROM acervo livro JOIN (SELECT * FROM acervo WHERE acervo.codigo = $oCod) tbl ON tbl.autor = livro.autor
        UNION
        SELECT livro.nome FROM acervo livro JOIN (SELECT * FROM acervo WHERE acervo.codigo = $oCod) tbl ON tbl.genero = livro.genero
        UNION
        SELECT livro.nome FROM acervo livro JOIN (SELECT * FROM acervo WHERE acervo.codigo = $oCod) tbl ON tbl.editora = livro.editora LIMIT 3";
        // Nesse aqui concatenei o valor do parametro $oCod


        $oRes=$oCon->query($cSQL, PDO::FETCH_ASSOC)->fetchAll();
        // echo '<table>
        //         <thead>
        //             <tr>
        //                 <th> Livros </th>
        //             </tr>
        //         </thead>
        //     <tbody>';
        // foreach($oRes as $oReg => $oLinha)
        // {
        //     // Mesmo esquema, dois foreachs
        //     echo '<tr>';
        //     foreach($oLinha as $oCampo => $oValor){
                
        //         echo('<td>'.$oValor.'</td>');
                
        //     }
        //     echo '</tr>';
        // }
        // echo '
        //             </tbody>
        //         </table>';
        return json_encode($oRes);
    }
    // fnLivrosParecidos(2);
    // echo '<br>';


    // ESSEAQUI é PUNK
    function fnRelatorioEmprestimo(string $oUs)
    {
        global $oCon;
        
        // Crio um vetor pra guardar os nomes do parametro $oUs ('$oUsuario')
        $array=[];


        // Testo pra saber se alguem digitou uma virgula
        if(str_contains($oUs,',')==true)
        {
            // 'explodo o vetor' (separa pelas ocorencias de ',' a string do segundo parametro, e joga no vetor que criei)
            // EU POSSO COLOCAR PRA ELE SEPARAR POR ' ' (espaco), mas nao coloquei, futuramente posso 
            $array = explode(",", $oUs);
        }else
            $array[] = $oUs;

        // crio OUTRA variavel para guardar os codigos agora
        $ArrCod=[];

        // Deixo o texto pronto pra concatenar ele depois
        $cSQL="SELECT usuario.codigo codigo FROM usuario WHERE ";

        // foreach pra concatenar dependendo do numero de valores no vetor
        foreach($array as $indice=>$nome)
        {
            // Testo pra saber se é o primeiro indice, caso sim ele adiciona a condicional sem o 'OR'
            if($indice==0){
                $cSQL=$cSQL."usuario.nome LIKE '%".trim($nome)."%' ";
            }else
                $cSQL=$cSQL."OR usuario.nome LIKE '%".trim($nome)."%' ";
                //  Senão ele concatena com a mesma restrição porem com o 'OR'
        }
        $oQuery=$oCon->query($cSQL, PDO::FETCH_NUM)->fetchAll();
        // EXECUTO A CONSULTA
        // Decidi fazer dessa forma pq eu tentei fazer em único foreach, 
        // onde ele ia fazer a consulta pra pegar o codigo de cada nome, um por vez
        // porém ele não tava trazendo o codigo da segundo e subsquentes consultas, ele so executava a consulta uma vez
        // ENTÃO, decidi fazer assim.


        // Foreach com a consulta
            foreach($oQuery as $indice=>$codigo)
            {
                // outro foreach
                foreach($codigo as $valor){

                    // coloco o valor dos codigos nesse array
                    // eu podia sim usar apenas um array, no caso reutilizar o antigo
                    $ArrCod[]=$valor;
                }    
            }
        //     echo '<br>';

        // echo '<table>
        //             <thead>
        //                 <tr>
        //                     <th> Usuario </th>
        //                     <th> Em Atraso </th>
        //                     <th> No Prazo </th>
        //                 </tr>
        //             </thead>
        //         <tbody>';
        
        // Agora neste foreach eu trago enfim a pessoa e as porcentagens
        // utilizando o vetor com cada codigo de usuario 
        $oRes2 = array();
        foreach($ArrCod as $indice=>$valor){
            // Mais uma variavel desnecessaria
            $oCod=$valor;
            $cSQL="SELECT tbl.nome, IFNULL(CONCAT(CAST((atraso/tbl.total)*100 AS UNSIGNED), '%'), '0%') 'em atraso', IFNULL(CONCAT(CAST((tbl.prazo/tbl.total)*100 AS UNSIGNED), '%'), '0%') 'no prazo'
            FROM (
                SELECT usuario.nome, COUNT(devolvido) total, atraso.atraso, prazo.prazo
                FROM emprestimo
                LEFT JOIN
                (SELECT emprestimo.usuario, COUNT(devolvido)atraso FROM emprestimo WHERE devolvido>datafim AND emprestimo.usuario=$oCod) AS atraso
                ON emprestimo.usuario=atraso.usuario
                LEFT JOIN
                (SELECT emprestimo.usuario, COUNT(devolvido)prazo FROM emprestimo WHERE devolvido<datafim AND emprestimo.usuario=$oCod) AS prazo
                ON emprestimo.usuario=prazo.usuario
                LEFT JOIN usuario
                ON usuario.codigo=emprestimo.usuario
                WHERE emprestimo.usuario=$oCod
            ) as tbl;";


            $oRes=$oCon->query($cSQL)->fetchAll(PDO::FETCH_ASSOC);
            if($oRes[0]['nome'] != null){
                $oRes2[]=$oRes;
            }
            
            
            //Variavel para saber se a consulta traz registros vazios, eu sei que nao era pra acontecer isso...
            //porem eu tava com pressa, e essa foi a maneira mais rapida de resolver o problema 
            // $show = true;
            // foreach
            // foreach($oRes as $oReg => $oLinha)
            // {
            //     echo '<tr>';
            //     // pra cada registro eu defino que ela é true, pra resetar ao padrão 
            //     $show=true;
            //     foreach($oLinha as $oCampo => $oValor){
            //         // Testo se o nome (que por conveniencia é o primeiro valor) é vazio
            //         if($oValor == '')
            //             // se sim deixa a variavel como false
            //             $show=false;


            //             // testo se a variavel é true, ou seja, se o registro tem valor
            //         if($show==true)
            //             // se sim eu mostro o campo
            //         echo('<td>'.$oValor.'</td>');
                    
            //     }
            //     echo '</tr>';
            // }
        }
        if(count($oRes2) == 1){
            $oRes2 = $oRes2[0];
        }
        else{
            foreach($oRes2 as $indice => $valor)
            {
                $oRes2[$indice] = $oRes2[$indice][0];
            }
        }
            // echo '
        //             </tbody>
        //         </table>';
        // deixo esta variavel global pra reutilizar ela nesse escopo
        global $oRes;
        return json_encode($oRes2);
    }
    // Parametro separado por virgula
    // fnRelatorioEmprestimo('Keanu, J');




    // echo '<br><br>';

    // Cansei de comentar

    function fnPesquisa(string $texto)
    {
        global $oCon;
        $cSQL="SELECT acervo.codigo 'codigo', acervo.nome 'acervo', autor.nome 'autor', editora.nome 'editora' FROM acervo 
                LEFT JOIN autor ON autor.codigo = acervo.autor
                LEFT JOIN editora ON editora.codigo = acervo.editora 
                WHERE acervo.nome LIKE '%$texto%' OR autor.nome LIKE '%$texto%' OR editora.nome LIKE '%$texto%'";

        $oRes=$oCon->query($cSQL, PDO::FETCH_ASSOC)->fetchAll();
        // echo '<table>
        //         <thead>
        //             <tr>
        //                 <th> Codigo </th>
        //                 <th> Livro </th>
        //                 <th> Autor </th>
        //                 <th> Editora </th>
        //             </tr>
        //         </thead>
        //     <tbody>';
        // foreach($oRes as $oReg => $oLinha)
        // {
        //     echo '<tr>';
        //     foreach($oLinha as $oCampo){
                
        //         echo('<td>'.$oCampo.'</td>');
          
        //     }
        //     echo '</tr>';
        // }
        // echo '
        //             </tbody>
        //         </table>';

        return json_encode($oRes);
    }
    // fnPesquisa('Não');


    // echo '<br><br>';


    function fnImprestados(int $value)
    {
        global $oCon;
        switch($value)
        {
            case 1:
                $cSQL="SELECT
            acervo.nome, autor.nome autor, editora.nome editora, COUNT(emprestimo.datainicio) AS 'quantidade'
            FROM acervo
            INNER JOIN autor ON autor.codigo = acervo.autor
            INNER JOIN editora ON acervo.editora = editora.codigo
            INNER JOIN emprestimo ON acervo.codigo = emprestimo.acervo
            GROUP BY acervo.nome, autor.nome, editora.nome
            ORDER BY quantidade desc";
                break;

            case 2:
                
                $cSQL = "SELECT
                acervo.nome, autor.nome autor, editora.nome editora, COUNT(emprestimo.datainicio) AS 'quantidade'
                FROM acervo
                INNER JOIN autor ON autor.codigo = acervo.autor
                INNER JOIN editora ON acervo.editora = editora.codigo
                INNER JOIN emprestimo ON acervo.codigo = emprestimo.acervo
                WHERE devolvido IS NOT NULL
                GROUP BY acervo.nome, autor.nome, editora.nome
                ORDER BY quantidade desc;";        
                
                break;
        }
        

        $oRes=$oCon->query($cSQL)->fetchAll(PDO::FETCH_ASSOC);
        // echo '<table>
        //         <thead>
        //             <tr>
        //                 <th> Livro </th>
        //                 <th> Autor </th>
        //                 <th> Editora </th>
        //                 <th> Quantidade </th>
        //             </tr>
        //         </thead>
        //     <tbody>';
        // foreach($oRes as $oReg => $oLinha)
        // {
        //     echo '<tr>';
        //     foreach($oLinha as $oCampo){
        //             echo('<td>'.$oCampo.'</td>');
          
        //     }
        //     echo '</tr>';
        // }
        // echo '
        //             </tbody>
        //         </table>';
        return json_encode($oRes);
    }

    function fnTabelas(string $nTipo){
        global $oCon;

        switch($nTipo){
            case 'usuario':
                $cSQL = "SELECT codigo, IF(acesso = 1, 'Usuario', 'Admin') acesso, nome FROM usuario";

                $oConsulta = $oCon->query($cSQL)->fetchAll(PDO::FETCH_ASSOC);

                return json_encode($oConsulta);
            break;

            case 'acervo':
                $cSQL = "SELECT * FROM acervo";

                $oConsulta = $oCon->query($cSQL)->fetchAll(PDO::FETCH_ASSOC);

                return json_encode($oConsulta);
            break;

            case 'autor':
                $cSQL = "SELECT * FROM autor";

                $oConsulta = $oCon->query($cSQL)->fetchAll(PDO::FETCH_ASSOC);

                return json_encode($oConsulta);
            break;

            case 'emprestimo':
                $cSQL = "SELECT emprestimo.codigo, usuario.nome usuario, acervo.nome livro, DATE_FORMAT(datainicio, '%d/%m/%Y') as 'pegou', DATE_FORMAT(datafim, '%d/%m/%Y') as 'vai até', IFNULL(DATE_FORMAT(devolvido, '%d/%m/%Y'), 'Não devolveu') as 'devolvido' FROM emprestimo LEFT JOIN usuario ON usuario.codigo=emprestimo.usuario LEFT JOIN acervo ON acervo.codigo=emprestimo.acervo";

                $oConsulta = $oCon->query($cSQL)->fetchAll(PDO::FETCH_ASSOC);

                return json_encode($oConsulta);
            break;
        }
    }

    // fnImprestados();

    switch($_GET['nTipo']){
        case 1:
            echo fnTabelas($_GET['txtTabela']);
        case 2:
            switch($_GET['nFuncao']){
                case 1:
                    echo fnMostrarLivros();
                break;

                case 2:
                    echo fnLivrosParecidos($_GET['txtParametro']);
                break;
                
                case 3:
                    echo fnRelatorioEmprestimo($_GET['txtParametro']);
                break;

                case 4:
                    echo fnPesquisa($_GET['txtParametro']);
                    break;

                case 5:
                    echo fnImprestados($_GET['txtParametro']);
                break;

                default:
                    
                break;
            }
            break;
    }
?>