<?PHP 
    header('Content-Type: text/html; charset=ISO-8859-1');
    $server_name = "SAP4HANA BW PROD";
    $username = "93247292";
    $password = "Weverton@1234";
    $conn = odbc_connect($server_name, $username, $password, SQL_CUR_USE_ODBC);

    if(!($conn)){
        echo "<p> Connection to DB via ODBC failed: ";
        echo odbc_errormsg ($conn);
        echo "</p>\n";
    }
    else {
                    
        // never trust what user wrote! We must ALWAYS sanitize user input
        $forn = $_POST["search"];
        $forn = htmlentities($forn);
        
        $sql = "Select DISTINCT \"for_cd_cnpj\" AS \"cnpj\", \"for_cd_regiao\" AS \"estado\", \"for_cd_pais\" AS \"pais\", \"for_nm_fornecedor\" AS \"nome_fornecedor\" 
            from \"_SYS_BIC\".\"edw.Views.Suprimentos/mdFornecedores\" where \"for_nm_fornecedor\" like '%".$forn."%' "; //\"for_cd_regiao\" = 'MG' ";

        $rs = odbc_exec($conn, $sql);

        if(count($rs)) {
            $end_result = '';
            while($row = odbc_fetch_array($rs)){
                $result = $row['nome_fornecedor'];
                // we will use this to bold the search fornecedor in result
                $bold = '<span class="found">' . $forn . '</span>';    
                $end_result.= '<li>' . str_ireplace($forn, $bold, $result) . '</li>';            
            }
            echo $end_result;
        }
        else {
            echo '<li>No results found</li>';
        }

        //while($row = odbc_fetch_array($rs)){
            //$array[] = $row;
            //$array[$row['cnpj']] = $row;
            //print("<pre>");
            //var_dump($row);
            //echo "<br>";
            //print("</pre>");
            
            //print($row['nome_fornecedor']);
            //print($row['cnpj']);
            //print($row['estado']);
            //print($row['pais']);
        //}
        //print_r($array['04817251000114']);
        //while($item = $array){
        //    var_dump($item);
        //}
    }
?>