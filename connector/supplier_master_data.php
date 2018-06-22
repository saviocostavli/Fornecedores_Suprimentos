<?PHP
    $server_name = "SAP4HANA BW PROD";
    $username = "93247292";
    $password = "Weverton@1234";
    $conn = odbc_connect($server_name, $username, $password, SQL_CUR_USE_ODBC);

    header('Content-Type: text/html; charset=ISO-8859-1');
    if(!($conn)){
        echo "<p> Connection to DB via ODBC failed: ";
        echo odbc_errormsg ($conn);
        echo "</p>\n";
    }
    else {
        $cnpj = $_POST["cnpj"];
        $cnpj = htmlentities($cnpj);
        
        $fornecedor = $_POST["fornecedor"];
        $fornecedor = htmlentities($fornecedor);

        
        $sql = "
        Select DISTINCT \"for_cd_cnpj\" AS \"cnpj\", \"for_cd_regiao\" AS \"estado\", \"for_cd_pais\" AS \"pais\", \"for_nm_fornecedor\" AS \"fornecedor\"
        from \"_SYS_BIC\".\"edw.Views.Suprimentos/mdFornecedores\"
        where \"for_cd_cnpj\" like '%".$cnpj."%' AND upper(\"for_nm_fornecedor\") like concat('%', concat(upper('".$fornecedor."'),'%'))";
        
        $rs = odbc_exec($conn, $sql);

        if(count($rs)) {
            $row = odbc_fetch_array($rs);
            $end_result = '</br><h1><b><p>'. $row['fornecedor'] .'</p></b></h1></br>';
            echo $end_result;
        }
        else {
            echo '<p>No results found</p>';
        }
    }
?>