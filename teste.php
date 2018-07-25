<?PHP
    $server_name = "SAP4HANA BW PROD";
    $username = "93247292";
    $password = "Weverton@123456";
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

        $sql_lista_contratos = "
            SELECT TOP 3 Fornecedores.\"for_nm_fornecedor\" AS \"fornecedor\",
            Contratos.\"cts_no_documento_compra\" AS \"codigo_contrato\",
            Contratos.\"cts_dt_Inicio_periodo_validade\" AS \"inicio_contrato\",
            Contratos.\"cts_dt_fim_periodo_validade\" AS \"fim_contrato\",
            Contratos.\"cts_vl_fixado_area_distribuicao\" AS \"valor_contrato\",
            SUM(Pedidos.\"ped_vl_liquido_pedido_moeda\") AS \"valor_consumido\"

            FROM \"_SYS_BIC\".\"edw.Views.Suprimentos/fdContratosDeCompras\" AS Contratos 
            INNER JOIN \"_SYS_BIC\".\"edw.Views.Suprimentos/mdFornecedores\" AS Fornecedores ON Fornecedores.\"for_no_conta_fornecedor\" = Contratos.\"cts_no_conta_fornecedor\"
            INNER JOIN \"_SYS_BIC\".\"edw.Views.Suprimentos/fdPedidosDeCompras\" AS Pedidos ON Pedidos.\"ped_no_contrato_superior\" = Contratos.\"cts_no_documento_compra\"
            
            WHERE Fornecedores.\"for_no_conta_fornecedor\"  = '0060001161' AND Contratos.\"cts_dt_fim_periodo_validade\" >= ".$data."
            GROUP BY 
                Fornecedores.\"for_nm_fornecedor\", Contratos.\"cts_dt_Inicio_periodo_validade\",
                Contratos.\"cts_dt_fim_periodo_validade\", Contratos.\"cts_vl_fixado_area_distribuicao\",
                Contratos.\"cts_no_documento_compra\"
            ORDER BY Contratos.\"cts_vl_fixado_area_distribuicao\" DESC
            ";
        $result_lista_contratos = odbc_exec($conn, $sql_lista_contratos);
        
        $lista_contratos = "<table>";
        while ($row_lista_contratos = odbc_fetch_array($result_lista_contratos)) {
            $lista_contratos .="
                <tr>
                    <td>".$row_lista_contratos['codigo_contrato']."</td>
                    <td>".$row_lista_contratos['valor_contrato']."</td>
                    <td>".((float)$row_lista_contratos['valor_contrato'] - (float)$row_lista_contratos['valor_consumido'])."</td>
                    <td>".$row_lista_contratos['inicio_contrato']."</td>
                    <td>".$row_lista_contratos['fim_contrato']."</td>
                </tr>";
        }
        $lista_contratos .="</table>";
        echo  $lista_contratos;
    }
?>