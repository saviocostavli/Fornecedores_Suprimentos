<?PHP
    $server_name = "SAP4HANA BW PROD";
    $username = "93247292";
    $password = "Weverton@1234";
    $conn = odbc_connect($server_name, $username, $password, SQL_CUR_USE_ODBC);
    
    date_default_timezone_set('America/Sao_Paulo');
    $data_hoje = date("Ymd");
    $data = (int)$data_hoje;
    header('Content-Type: text/html; charset=ISO-8859-1');

    if(!($conn)){
        echo "<p> Connection to DB via ODBC failed: ";
        echo odbc_errormsg ($conn);
        echo "</p>\n";
    }
    else {

       $sql_contratos = "
            SELECT Fornecedores.\"for_nm_fornecedor\" AS \"fornecedor\", COUNT(Contratos.\"cts_no_documento_compra\") AS \"qtd_contratos\",
            SUM(Contratos.\"cts_vl_fixado_area_distribuicao\") AS \"total_contratado\", SUM(Contratos.\"cts_vl_liquido_pedido_moeda\") AS \"total_consumido\"

            FROM \"_SYS_BIC\".\"edw.Views.Suprimentos/mdFornecedores\" AS Fornecedores
            INNER JOIN \"_SYS_BIC\".\"edw.Views.Suprimentos/fdContratosDeCompras\" AS Contratos ON Fornecedores.\"for_no_conta_fornecedor\" = Contratos.\"cts_no_conta_fornecedor\"
            
            WHERE Fornecedores.\"for_no_conta_fornecedor\"  = '0060000721'
            GROUP BY Fornecedores.\"for_nm_fornecedor\"";
        $result_qtd_contratos = odbc_exec($conn, $sql_contratos);


        $row_contratos = odbc_fetch_array($result_qtd_contratos);
        var_dump($row_contratos);
        
    }
?>