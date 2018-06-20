<?PHP 
    // $driver = "HDBODBC32";
    // $dsn = "10.1.122.129:30215";
    
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
        $sql = "Select DISTINCT \"cph_ds_nivel_01\" AS \"Pacote\", \"cdch_ds_nivel_01\" AS \"Diretoria\", \"cdch_ds_nivel_02\" AS \"Gerência\"
            from \"_SYS_BIC\".\"edw.Views.Controladoria.AdHoc/prBaseRealCompleta\" ( 'PLACEHOLDER' = ('$$"."hierarquia_cdc"."$$', '13')) 
            where (\"cdch_ds_nivel_01\" like 'DIRETORIA DE GENTE E SERVI%' ) and (\"cdch_ds_nivel_02\" like 'GER. SUPRIMENTOS' ) 
            order by \"Pacote\" ";

        $rs = odbc_exec($conn, $sql);
        print("<DIV ALIGN=’CENTER’>");
        print("<H1>SAP HANA from PHP</H1>"); 
        print("<p>");
        while($row = odbc_fetch_array($rs)){
            var_dump($row);
        }
        print("</p>");
        print("</DIV>");
    }


?>
