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
        
        $fornecedor = $_POST["fornecedor"];
        $fornecedor = htmlentities($fornecedor);
        
        //upper(Fornecedores.\"for_nm_fornecedor\") like concat('%', concat(upper('".$fornecedor."'),'%'))

        $sql_contratos = "
            SELECT Fornecedores.\"for_nm_fornecedor\" AS \"fornecedor\", COUNT(Contratos.\"cts_no_documento_compra\") AS \"qtd_contratos\",
            SUM(Contratos.\"cts_vl_fixado_area_distribuicao\") AS \"total_contratado\", SUM(Contratos.\"cts_vl_liquido_pedido_moeda\") AS \"total_consumido\"

            FROM \"_SYS_BIC\".\"edw.Views.Suprimentos/mdFornecedores\" AS Fornecedores
            INNER JOIN \"_SYS_BIC\".\"edw.Views.Suprimentos/fdContratosDeCompras\" AS Contratos ON Fornecedores.\"for_no_conta_fornecedor\" = Contratos.\"cts_no_conta_fornecedor\"
            
            WHERE Fornecedores.\"for_no_conta_fornecedor\"  = '".$fornecedor."'
            GROUP BY Fornecedores.\"for_nm_fornecedor\"";
        $result_qtd_contratos = odbc_exec($conn, $sql_contratos);
        
        
        $sql_prazo_final = "
            SELECT MAX (Contratos.\"cts_dt_fim_periodo_validade\") AS \"fim_validade\"
            
            FROM \"_SYS_BIC\".\"edw.Views.Suprimentos/mdFornecedores\" AS Fornecedores
            INNER JOIN \"_SYS_BIC\".\"edw.Views.Suprimentos/fdContratosDeCompras\" AS Contratos ON Fornecedores.\"for_no_conta_fornecedor\" = Contratos.\"cts_no_conta_fornecedor\"
            
            WHERE Fornecedores.\"for_no_conta_fornecedor\"  = '".$fornecedor."' ";
        $result_prazo_final = odbc_exec($conn, $sql_prazo_final);
        

        $sql_contratos_vigentes = "
            SELECT COUNT(Contratos.\"cts_no_documento_compra\") AS \"qtd_contratos_validos\"
            
            FROM \"_SYS_BIC\".\"edw.Views.Suprimentos/mdFornecedores\" AS Fornecedores
            INNER JOIN \"_SYS_BIC\".\"edw.Views.Suprimentos/fdContratosDeCompras\" AS Contratos ON Fornecedores.\"for_no_conta_fornecedor\" = Contratos.\"cts_no_conta_fornecedor\"
            
            WHERE Fornecedores.\"for_no_conta_fornecedor\"  = '".$fornecedor."' AND Contratos.\"cts_dt_fim_periodo_validade\" >= ".$data."
            GROUP BY Fornecedores.\"for_nm_fornecedor\"
            ";
        $result_contratos_vigentes = odbc_exec($conn, $sql_contratos_vigentes);
        

        $sql_valor_consumido = "
            SELECT DISTINCT Fornecedores.\"for_nm_fornecedor\" AS \"fornecedor\",
            SUM(Pedidos.\"ped_vl_liquido_pedido_moeda\") AS \"valor_consumido\"
            
            FROM \"_SYS_BIC\".\"edw.Views.Suprimentos/fdContratosDeCompras\" AS Contratos
            INNER JOIN \"_SYS_BIC\".\"edw.Views.Suprimentos/mdFornecedores\" AS Fornecedores ON Fornecedores.\"for_no_conta_fornecedor\" = Contratos.\"cts_no_conta_fornecedor\"
            INNER JOIN \"_SYS_BIC\".\"edw.Views.Suprimentos/fdPedidosDeCompras\" AS Pedidos ON Contratos.\"cts_no_documento_compra\" = Pedidos.\"ped_no_contrato_superior\"
            
            WHERE Fornecedores.\"for_no_conta_fornecedor\"  = '".$fornecedor."'
            GROUP BY Fornecedores.\"for_nm_fornecedor\"
            ";
        $result_valor_consumido = odbc_exec($conn, $sql_valor_consumido);
        
        
        if(count($result_qtd_contratos)) {
            //$row = odbc_fetch_array($result_qtd_contratos);
            
            $row_contratos = odbc_fetch_array($result_qtd_contratos);
            $row_prazo_final = odbc_fetch_array($result_prazo_final);
            $row_contratos_vigentes = odbc_fetch_array($result_contratos_vigentes);
            $row_valor_consumido = odbc_fetch_array($result_valor_consumido);
            
            $array = array(
                'qtd_contratos' => $row_contratos['qtd_contratos'],
                'fornecedor' => $row_contratos['fornecedor'], 
                'total_contratado' => $row_contratos['total_contratado'],
                'total_consumido' => $row_contratos['total_consumido'], 
                'fim_validade' => $row_prazo_final['fim_validade'],
                'qtd_contratos_validos' => $row_contratos_vigentes['qtd_contratos_validos'],
                'valor_consumido' => $row_valor_consumido['valor_consumido'], 
                'saldo_contrato' => ((float)$row_contratos['total_contratado'] - (float)$row_valor_consumido['valor_consumido'])
            );
            echo json_encode($array);
        }
        else {
            echo '<p>No results found</p>';
        }
    }
?>