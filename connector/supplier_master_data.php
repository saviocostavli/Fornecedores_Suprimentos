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
        
        $fornecedor = $_POST["fornecedor"];
        $fornecedor = htmlentities($fornecedor);
        
        $sql_qtd_contratos = "
            SELECT COUNT(Contratos.\"cts_no_documento_compra\") AS \"qtd_contratos\"
            FROM \"_SYS_BIC\".\"edw.Views.Suprimentos/mdFornecedores\" AS Fornecedores
            INNER JOIN \"_SYS_BIC\".\"edw.Views.Suprimentos/fdContratosDeCompras\" AS Contratos
            ON Fornecedores.\"for_no_conta_fornecedor\" = Contratos.\"cts_no_conta_fornecedor\" 
            WHERE upper(Fornecedores.\"for_nm_fornecedor\") like concat('%', concat(upper('".$fornecedor."'),'%'))
            GROUP BY Fornecedores.\"for_nm_fornecedor\"";
        $result_qtd_contratos = odbc_exec($conn, $sql_qtd_contratos);

        if(count($result_qtd_contratos)) {
            $row = odbc_fetch_array($result_qtd_contratos);
            echo $row['qtd_contratos'];
        }
        else {
            echo '<p>No results found</p>';
        }
    }
?>