<?PHP
    $driver = "HDBODBC32";
    $server_name = "SAP4HANA BW PROD";

    $dsn = "10.1.122.129:30215";
    $username = "93247292";
    $password = "Weverton@1234";

    $queryString = 'Select DISTINCT "cph_ds_nivel_01" AS "Pacote" from "_SYS_BIC"."edw.Views.Controladoria.AdHoc/prBaseRealCompleta" ( "PLACEHOLDER" = (""$$hierarquia_cdc$$", "13"))';
    
    try {
        // Connect to the data source
        // $dbh = odbc_connect($server_name, $username, $password, SQL_CUR_USE_ODBC);
        $dbh = new PDO($dsn, $username, $password);
        $stmt = $dbh->prepare($queryString);
        $stmt -> execute();
        $result = $stmt->fetchOne(PDO::FETCH_ASSOC);
    }
    catch (Exception $e) {
        echo $e->getMessage();
    }
?>