<!DOCTYPE html>
<html lang="pt-br">
	<head>
  	    <title>Bootstrap 4 Example</title>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  		<meta name="viewport" content="width=device-width, initial-scale=1">
  		
  		<link type="text/css" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700">
  		<link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet" type="text/css">
  		<link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css">

  		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
  		<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
        <link rel="stylesheet" href="./css/style.css">

  		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
  		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>

        <script>
            $(document).ready(function(){
                $('[data-toggle="tooltip"]').tooltip(); 
            });
        </script>

        <script type="text/javascript">
            function carregarFornecedor(){
                var searchCnpj = "<?php echo $_GET["cnpj"]; ?>";
                var searchFornecedor = "<?php echo $_GET["fornecedor"]; ?>";
                
                //var data = "{ cnpj=" + searchCnpj + ", fornecedor=" + searchFornecedor + "}";

                $.ajax({
                    type: "POST",
                    url: "connector/supplier_master_data.php",
                    data: { cnpj: searchCnpj, fornecedor: searchFornecedor},
                    success: function(html){
                        $("#nome_fornecedor").show();
                        $("#nome_fornecedor").append(html);
                    }
                });
            }
        </script>
    </head>
    
	<body onload="carregarFornecedor()">
	    <div class="w3-container w3-center">
            <div id="nome_fornecedor"> </div>

            <div class="w3-card-4 w3-center" style="background-color:#e0e0e0; width:90%; text-align:center; margin: 0 auto;">
                <header class="w3-container" style="background-color:#3777bc;">
                    </br><h3 style="color:#ffffff; text-align:left; margin: 0 auto;"><b>Relacionamento com a VL!</b></h3></br>
                </header>

                <div class="w3-container w3-cell" style="text-align:left;">
                    <p><b>Número total de contratos:</b> </p>
                    <p><b>Número total de contratos vigentes:</b>  </p>
                    <p><b>Prazo final do último contrato:</b>  </p>
                </div>

                <div class="w3-container w3-cell" style="width: 20%; text-align:left;">
                </div>

                <div class="w3-container w3-cell" style="text-align:left;">
                    <p><b>Valor total de contratado (R$):</b> </p>
                    <p><b>Valor total consumido (R$):</b>  </p>
                    <p><b>Saldo (R$):</b>  </p>
                </div>
                <!--
                <div class="w3-container" style="text-align:center; margin: 0 auto;">
                    <table class="w3-table-all">
                        <thead>
                            <tr style="background-color:#3777bc; color:white">
                                <th colspan="5">Maiores contratos vigentes:</th>
                            </tr>
                        </thead>
                        <tr>
                            <td><b>Objeto: </b></td>
                            <td><b>Valor (R$): </b></td>
                            <td><b>Saldo (R$): </b></td>
                            <td><b>Data Início: </b></td>
                            <td><b>Data Fim: </b></td>
                        </tr>
                        <tr>
                            <td>Fornecimento de tilhos de aço</td>
                            <td>40.000.000,00</td>
                            <td>13.000.000,00</td>
                            <td>01/01/2016</td>
                            <td>01/01/2016</td>
                        </tr>
                        <tr>
                            <td>Fornecimento de tilhos de aço</td>
                            <td>40.000.000,00</td>
                            <td>13.000.000,00</td>
                            <td>01/01/2016</td>
                            <td>01/01/2016</td>
                        </tr>
                        <tr>
                            <td>Fornecimento de tilhos de aço</td>
                            <td>40.000.000,00</td>
                            <td>13.000.000,00</td>
                            <td>01/01/2016</td>
                            <td>01/01/2016</td>
                        </tr>
                    </table>
                </div>
                -->
                </br>
            </div>
        </div>
	</body>
</html>