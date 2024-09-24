<?php
    
   
   $con = new PDO('mysql: host=localhost;dbname=BIBLIOTECA', 'Aluno2DS', 'SenhaBD2');

    function exportaDados(int $nPag, array $campos = null, array $ordem = null, string $pesquisa = null) {
        global $con;
        $select = "SELECT " . (is_null($campos)?'*':implode(',', $campos)) . " FROM EDITORAS WHERE 1 = 1";


        if(!is_null($pesquisa)){
            $select .= "  AND EDTNOME LIKE '%$pesquisa%'";
        }
        $nPag = ($nPag - 1) * 10;
        $select .= " LIMIT $nPag , 10";


        return json_encode($con->query($select, PDO::FETCH_ASSOC)->fetchAll());
    }

    function geraTabela(string $cDados) {
        $vDados = json_decode($cDados, TRUE);
        $nReg = 0;
        $cHeader = '<thead><tr>';
        $cCorpo = '';

        echo '<table>';

        foreach($vDados as $vReg) {
            foreach($vReg as $cNome=>$cCampo) {
                if($nReg == 0) {
                    $cHeader .= "<th>$cNome</th>";
                    $cCorpo .= "<td>$cCampo</td>";
                }
                else {
                    $cHeader = '';
                    $cCorpo .= "<td>$cCampo</td>";
                }
            }

            if($cHeader != '') {
                echo $cHeader . '</tr></thead><tbody>';
            }

            echo "<tr>$cCorpo</tr>";
            $nReg++;
            $cCorpo = '';
        }
        echo '</tbody></table>';
    }

    //echo geraTabela(exportaDados(['LVRCODIGO', 'LVRTITULO', 'DATE_FORMAT(LVRDTPUBLIC, "%d/%m/%y")']));
    echo geraTabela(exportaDados($_POST['txtPag'], null, null, $_POST['txtPesquisa']));
?>