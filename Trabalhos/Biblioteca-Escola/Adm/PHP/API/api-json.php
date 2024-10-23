<?php 
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    //A turma B nao sabia usar isso, conversei com o um colega da Turma A e ele falou que precisa disso para retornar o resultado em JSON
    header("Acess-Control-Allow-Origin:: *");

    $oCon = new PDO('mysql: host=localhost;dbname=.the_library','root', '');
    // $oCon = new PDO('mysql:host=localhost;dbname=.the_library','Aluno02-B', 'Aluno02.2DS');  *conexão com o servidor da escola

    function fnMostrarLivros() {
        // deixando a variavel 'global' para reutilizar ela em outros escopos
        global $oCon;

        // consulta
        $cSQL="SELECT acervo.codigo, acervo.nome, CONCAT(SUBSTRING_INDEX(autor.nome, ' ', -1), ', ', RTRIM(REPLACE(autor.nome, SUBSTRING_INDEX(autor.nome, ' ', -1), ''))) Autor FROM acervo INNER JOIN autor ON acervo.autor = autor.codigo ORDER BY RAND() LIMIT 10";
        

        $oRes=$oCon->query($cSQL, PDO::FETCH_ASSOC)->fetchAll();
        // executando a consulta

        $oArray = array();
        $oArray = $oRes;
        return json_encode($oArray);       
    }

    function fnLivrosParecidos(int $oCod) {
        // Mesma coisa, nao vou comentar de novo em coisas que se repetem
        global $oCon;

        $cSQL = "
            SELECT acervo.nome AS titulo FROM acervo INNER JOIN (SELECT * FROM acervo WHERE acervo.codigo = $oCod) tbl ON tbl.autor = acervo.autor
            UNION
            SELECT acervo.nome AS titulo FROM acervo INNER JOIN (SELECT * FROM acervo WHERE acervo.codigo = $oCod) tbl ON tbl.genero = acervo.genero
            UNION
            SELECT acervo.nome AS titulo FROM acervo INNER JOIN (SELECT * FROM acervo WHERE acervo.codigo = $oCod) tbl ON tbl.editora = acervo.editora LIMIT 3
        ";
        // Nesse aqui concatenei o valor do parametro $oCod


        $oRes=$oCon->query($cSQL, PDO::FETCH_ASSOC)->fetchAll();
        return json_encode($oRes);
    }

    // ESSEAQUI é PUNK
    function fnRelatorioEmprestimo(string $oUser) {
        global $oCon;
        
        // Crio um vetor pra guardar os nomes do parametro $oUser ('$oUsuario')
        $array=[];

        // Testo pra saber se alguem digitou uma virgula
        if(str_contains($oUser, ',') == true) {
            // O metodo 'explode()' separa a string pelas ocorencias de ',' e joga no vetor que criei 
            $array = explode(",", $oUser);
        }
        else {
            $array[] = $oUser;
        }

        // crio OUTRA variavel para guardar os codigos agora
        $ArrCod=[];

        // Deixo o texto pronto pra concatenar ele depois
        $cSQL="SELECT usuario.codigo AS codigo FROM usuario WHERE ";

        // foreach pra concatenar dependendo do numero de valores no vetor
        foreach($array as $indice=>$nome)
        {
            // Testo pra saber se é o primeiro indice, caso sim ele adiciona a condicional sem o 'OR'
            if($indice == 0) {
                $cSQL = $cSQL . "usuario.nome LIKE '%" . trim($nome) . "%'";
            }
            else {
                //  Senão ele concatena com a mesma restrição porem com o 'OR'
                $cSQL = $cSQL . "OR usuario.nome LIKE '%" . trim($nome) . "%'";
            }
        }
        $oQuery=$oCon->query($cSQL, PDO::FETCH_NUM)->fetchAll();
        // EXECUTO A CONSULTA
        // Decidi fazer dessa forma pq eu tentei fazer em único foreach, 
        // onde ele ia fazer a consulta pra pegar o codigo de cada nome, um por vez
        // porém ele não tava trazendo o codigo da segundo e subsquentes consultas, ele so executava a consulta uma vez
        // ENTÃO, decidi fazer assim.


        // Foreach com a consulta
        // foreach($oQuery as $indice=>$codigo) {
        //     // outro foreach
        //     foreach($codigo as $valor) {
        //         // coloco o valor dos codigos nesse array
        //         // eu podia sim usar apenas um array, no caso reutilizar o antigo
        //         $ArrCod[]=$valor;
        //     }    
        // }
        
        foreach($oQuery as $indice=>$codigo) {
            foreach($codigo as $valor) {
                $ArrCod[] = $valor;
            }
        }

        // Agora neste foreach eu trago enfim a pessoa e as porcentagens
        // utilizando o vetor com cada codigo de usuario 
        $oRes2 = array();

        foreach($ArrCod as $indice=>$valor) {
            // Mais uma variavel desnecessaria
            $oCod = $valor;
            $cSQL = "SELECT tbl.nome, IFNULL(CONCAT(CAST((atraso/tbl.total)*100 AS UNSIGNED), '%'), '0%') 'em atraso', IFNULL(CONCAT(CAST((tbl.prazo/tbl.total)*100 AS UNSIGNED), '%'), '0%') 'no prazo'
            FROM (
                SELECT usuario.nome, COUNT(entregue) total, atraso.atraso, prazo.prazo
                FROM emprestimo
                LEFT JOIN
                (SELECT emprestimo.usuario, COUNT(entregue)atraso FROM emprestimo WHERE entregue>datafim AND emprestimo.usuario=$oCod) AS atraso
                ON emprestimo.usuario=atraso.usuario
                LEFT JOIN
                (SELECT emprestimo.usuario, COUNT(entregue)prazo FROM emprestimo WHERE entregue<datafim AND emprestimo.usuario=$oCod) AS prazo
                ON emprestimo.usuario=prazo.usuario
                LEFT JOIN usuario
                ON usuario.codigo=emprestimo.usuario
                WHERE emprestimo.usuario=$oCod
                GROUP BY usuario.nome, atraso.atraso, prazo.prazo
            ) as tbl";

            $oRes=$oCon->query($cSQL)->fetchAll(PDO::FETCH_ASSOC);
            
            if($oRes[0]['nome'] != null){
                $oRes2[]=$oRes;
            }
        }

        if(count($oRes2) == 1){
            $oRes2 = $oRes2[0];
        }
        else {
            foreach($oRes2 as $indice => $valor) {
                $oRes2[$indice] = $oRes2[$indice][0];
            }
        }
        
        global $oRes;
        return json_encode($oRes2);
    }
    // fnRelatorioEmprestimo('Keanu, J');

    function fnPesquisa(string $texto) {
        global $oCon;
        $cSQL="SELECT acervo.codigo 'codigo', acervo.nome 'acervo', autor.nome 'autor', editora.nome 'editora' FROM acervo 
                LEFT JOIN autor ON autor.codigo = acervo.autor
                LEFT JOIN editora ON editora.codigo = acervo.editora 
                WHERE acervo.nome LIKE '%$texto%' OR autor.nome LIKE '%$texto%' OR editora.nome LIKE '%$texto%'";

        $oRes=$oCon->query($cSQL, PDO::FETCH_ASSOC)->fetchAll();
        
        return json_encode($oRes);
    }

    function fnImprestados(int $value){
        global $oCon;
        switch($value) {
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


    function fnEmprestimo(bool $atrasados=null, bool $today=null, array $data=null){
        global $oCon;

        $cSQL="SELECT emprestimo.codigo, usuario.nome, acervo.nome, DATE_FORMAT(datainicio, '%d/%m/%Y') as 'data emprestimo'
        , DATE_FORMAT(datafim, '%d/%m/%Y') 'data devolver', DATE_FORMAT(devolvido, '%d/%m/%Y') as 'devolvido' FROM `emprestimo` LEFT JOIN usuario ON usuario.codigo=emprestimo.usuario LEFT JOIN acervo ON acervo.codigo=emprestimo.acervo WHERE 1=1 ";

            if(!is_null($data)){
            
                if($data['datainicio']!==null && $data['datainicio']!="null" && $data['datainicio'] != 'undefined')
                    $data1 = new DateTime($data['datainicio']);
                else 
                    $data1=null;
                    
                // echo $data['datafim'].'<br><br><br>';
                if(!is_null($data['datafim']) && $data['datafim']!="null" && $data['datafim'] != 'undefined')
                    $data2 = new DateTime($data['datafim']);
                else
                    $data2=null;

                if($data1!==null && $data1!="null" && $data1 != 'undefined' && $data2!==null && $data2!="null" && $data2 != 'undefined')
                {
                    if($data1<$data2) {
                        if(!is_null($data['datainicio']) && $data['datainicio'] != 'null' && $data['datainicio'] != 'undefined') {
                            // $cSQL .= "AND datainicio > '". $data['datainicio'] ."' OR devolvido > '". $data['datainicio'] ."' OR datafim> '". $data['datainicio'] ."' ";
                            $cSQL .= "AND datainicio >= '". $data['datainicio'] ."' ";
                        }
                        if(!is_null($data['datafim']) && $data['datafim'] != 'null' && $data['datafim'] != 'undefined'){
                            // $cSQL .= "AND datafim < '". $data['datafim'] ."' OR devolvido < '". $data['datafim'] ."' OR datainicio < '". $data['datafim'] ."' ";
                            // echo "datafim1";
                            $cSQL .= "AND datafim <= '". $data['datafim'] ."' ";
                        }
                    }else {
                        if(!is_null($data['datainicio']) && $data['datainicio'] != 'null' && $data['datainicio'] != 'undefined') {
                            // $cSQL .= "AND datafim <  '". $data['datainicio'] ."' OR devolvido < '". $data['datainicio'] ."' OR datainicio < '". $data['datainicio'] ."' ";

                            $cSQL .= "AND datafim <= '". $data['datainicio'] ."' ";
                        }
                        if(!is_null($data['datafim']) && $data['datafim'] != 'null' && $data['datafim'] != 'undefined'){
                            // $cSQL .= "AND datainicio >  '". $data['datafim'] ."' OR devolvido > '". $data['datafim'] ."' OR datafim > '". $data['datafim'] ."' ";
                            // echo 'datafim2';
                            $cSQL .= "AND datainicio >= '". $data['datafim'] ."' ";
                        }
                    }
                }else{
                    if($data1!==null && $data1!="null" && $data1 != 'undefined') {

                        $cSQL .= "AND datainicio >= '". $data['datainicio'] ."' ";
                    }
                    if($data2!==null && $data2!="null" && $data2 != 'undefined') {
                        // echo 'datafim3';
                        $cSQL .= "AND datafim  <=  '". $data['datafim'] ."' ";
                    }
                }
            }
            if(!is_null($_GET['atrasados']) && $_GET['atrasados'] != "null"){
                    $cSQL .= "AND devolvido>datafim ";
            }

            if(!is_null($_GET['today']) && $_GET['today'] != "null"){
                    $cSQL .= "AND datainicio=DATE_FORMAT(NOW(), '%Y-%m-%d') OR datafim=DATE_FORMAT(NOW(), '%Y-%m-%d') OR devolvido=DATE_FORMAT(NOW(), '%Y-%m-%d') ";
            }
            // echo $cSQL;
            $oRes=$oCon->query($cSQL, PDO::FETCH_ASSOC)->fetchAll();
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


                case 6:
                    $data = [];
                    if(!is_null($_GET['datainicio'])) {
                        $data['datainicio'] = $_GET['datainicio'];
                    }
                    if(!is_null($_GET['datafim'])) {
                        $data['datafim']=$_GET['datafim'];
                                
                    }
                    echo fnEmprestimo($_GET['atrasados'], $_GET['today'], $data);
                    break;

                default:
                    
                break;
            }
            break;
    }
?>