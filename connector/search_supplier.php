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
        $search = $_POST["search"];
        $search = htmlentities($search);
        $search = str_replace('.', '', $search);
        $search = str_replace('-', '', $search);
        $search = trim($search);
        
        $sql = "
            Select DISTINCT \"for_cd_cnpj\" AS \"cnpj\", \"for_cd_regiao\" AS \"estado\", \"for_cd_pais\" AS \"pais\", \"for_nm_fornecedor\" AS \"fornecedor\"
            from \"_SYS_BIC\".\"edw.Views.Suprimentos/mdFornecedores\"
            where upper(\"for_nm_fornecedor\") like concat('%', concat(upper('".$search."'),'%')) OR \"for_cd_cnpj\" like '%".$search."%' ";

        $rs = odbc_exec($conn, $sql);

        if(count($rs)) {
            $end_result = '';
            while($row = odbc_fetch_array($rs)){
                $end_result.=
                    '<li>
                        <h3>Fornecedor: '. $row['fornecedor'] .'</h3>
                        <b>CNPJ: '. $row['cnpj'] .'</b>  &emsp;&emsp;
                        <b>Pa&iacute;s: '. $row['pais'] .'</b> &emsp;&emsp;
                        <b>Estado: '. $row['estado'] .'</b> &emsp;&emsp;'.
                        '<a href="./fornecedor.php?cnpj='.$row['cnpj'].'&fornecedor='.$row['fornecedor'].' ">
                            <img src="./media/icons/arrow-right-bold-circle.svg" class="w3-round follow_fornecedor" data-toggle="tooltip" title="Ver Fornecedor ">
                        </a>
                    </li>';
            }
            echo $end_result;
        }
        else {
            echo '<li>No results found</li>';
        }
    }
?>