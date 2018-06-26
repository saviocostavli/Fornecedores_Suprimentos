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
            SELECT DISTINCT Fornecedores.\"for_cd_cnpj\" AS \"cnpj\", Fornecedores.\"for_cd_regiao\" AS \"estado\", Fornecedores.\"for_cd_pais\" AS \"pais\", 
                Fornecedores.\"for_nm_fornecedor\" AS \"fornecedor\", Fornecedores.\"for_no_conta_fornecedor\" AS \"for_conta\",
                Contratos.\"cts_vl_fixado_area_distribuicao\" AS \"con_conta\"

            FROM \"_SYS_BIC\".\"edw.Views.Suprimentos/mdFornecedores\" AS Fornecedores, 
                 \"_SYS_BIC\".\"edw.Views.Suprimentos/fdContratosDeCompras\" AS Contratos

            WHERE Fornecedores.\"for_no_conta_fornecedor\" = Contratos.\"cts_no_conta_fornecedor\" 
                AND Fornecedores.\"for_cd_cnpj\" like '%".$cnpj."%' 
                AND upper(Fornecedores.\"for_nm_fornecedor\") like concat('%', concat(upper('".$fornecedor."'),'%'))";
        
        $rs = odbc_exec($conn, $sql);

        if(count($rs)) {
            $row = odbc_fetch_array($rs);
            $end_result = '</br><h1><b><p>'. $row['fornecedor'] .' | '. $row['con_conta'] .' </p>  </b></h1></br>';
            echo $end_result;
        }
        else {
            echo '<p>No results found</p>';
        }
    }
?>