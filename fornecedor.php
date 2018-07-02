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
                var searchFornecedor = "<?php echo $_GET["fornecedor"]; ?>";

                $.ajax({
                    type: "POST",
                    url: "connector/supplier_master_data.php",
                    data: { fornecedor: searchFornecedor},
                    success: function(result){
                        //$("#nome_fornecedor").show();
                        var dados_mestre = JSON.parse(result);
                        $("#nome_fornecedor").append(dados_mestre.fornecedor);
                        $("#qtd_contratos").append(dados_mestre.qtd_contratos);
                        $("#total_contratado").append((Number(dados_mestre.total_contratado)).toLocaleString(undefined,{minimumFractionDigits:2}));
                        var fim = dados_mestre.fim_validade;
                        var fim_val = new Date(fim.substring(0,4),fim.substring(4,6),fim.substring(6,8)); 
                        $("#prazo_final_ultimo_contrato").append(fim_val.toLocaleDateString());
                        
                        //$("#total_consumido").append((Number(dados_mestre.total_consumido)).toLocaleoString(undefined,{minimumFractionDigits:2}));
                    }
                });
            }
        </script>
    </head>
    
	<body onload="carregarFornecedor()">
	    <div class="w3-container w3-center">
            <div></br><h1><b><p id="nome_fornecedor">  </p></b></h1></br> </div>

            <div class="w3-card-4 w3-center" style="background-color:#e0e0e0; width:90%; text-align:center; margin: 0 auto;">
                <header class="w3-container" style="background-color:#3777bc;">
                    </br><h3 style="color:#ffffff; text-align:left; margin: 0 auto;"><b>Relacionamento com a VL!</b></h3></br>
                </header>

                <div class="w3-container w3-cell" style="text-align:left;">
                    <p id="qtd_contratos"><b>Número total de contratos:</b> </p>
                    <p><b>Número total de contratos vigentes:</b>  </p>
                    <p id="prazo_final_ultimo_contrato"><b>Prazo final do último contrato:</b>  </p>
                </div>

                <div class="w3-container w3-cell" style="width: 20%; text-align:left;">
                </div>

                <div class="w3-container w3-cell" style="text-align:left;">
                    <p id="total_contratado"><b>Valor total de contratado (R$):</b> </p>
                    <p id="total_consumido"><b>Valor total consumido (R$):</b>  </p>
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