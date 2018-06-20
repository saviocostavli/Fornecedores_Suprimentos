<!DOCTYPE html>
<html lang="en">
	<head>
  		<title>Fornecedores VLI</title>
  		<meta charset="utf-8">
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

		<script type="text/javascript">
            $(function() {
                $(".search_button").click(function() {
                    // getting the value that user typed
                    var searchString = $("#search_box").val();
                    // forming the queryString
                    var data = 'search='+ searchString;
                    
                    // if searchString is not empty
                    if(searchString) {
                        // ajax call
                        $.ajax({
                            type: "POST",
                            url: "connector/conexao_hana_suprimentos.php",
                            data: data,
                            beforeSend: function(html) { // this happens before actual call
                                $("#results").html(''); 
                                $(".word").html(searchString);
                            },
                            success: function(html){ // this happens after we get results
                                $("#results").show();
                                $("#results").append(html);
                            }
                        });    
                    }
                    return false;
                });
            });
        </script>
	</head>
	<body>
		<div class="w3-card-4 w3-center" style="width:95%; text-align:center; margin:20px auto; padding:10px;">
  			<div class="jumbotron w3-indigo w3-center">
  				<h1>Suprimentos VL!</h1> 
  				<p>Obtenha informações importantes dos nossos fornecedores!</p>

<!--  				<form action = "connector/conexao_hana_suprimentos.php" class="form-inline">
					<div class="input-group" style="text-align:center; margin: 0 auto;">
						<input type="text" class="form-control" size="50" placeholder="Informe o CNPJ do fornecedor." required>
					
						<div class="input-group-btn">
							<button type="button" class="btn btn-danger">Buscar</button>
						</div>	
					</div>
				</form>
-->
				<form class="form-inline" method="post" action="connector/conexao_hana_suprimentos.php">
					<div class="input-group" style="text-align:center; margin: 0 auto;">
						<input type="text" name="search" id="search_box" class='form-control' size="50" placeholder="Informe o CNPJ do fornecedor." required/>
						<input type="submit" name="submit_search" value="Search" class="search_button btn btn-danger" /><br />
					</div>
                </form>
			</div>		
		</div>

		<div style="background-color:white; width:95%; text-align:left; margin: 20px auto; padding: 10px;">
			<!--
			<h3>Fornecedor A:</h3>
			<b>CNPJ:</b> 00.000.000.000 0001-98 &emsp;&emsp; <b>País:</b> Brasil &emsp;&emsp;<b>Estado:</b> Minas Gerais &emsp;&emsp;<a href="http://google.com"><img src="./media/icons/arrow-right-bold-circle.svg" class="w3-round" alt="seta para baixo" data-toggle="tooltip" title="A seta para baixo indica uma queda no Faturamento em relação ao ano anterior do último faturamento informado. A seta para cima indica um aumento no Faturamento em relação ao ano anterior do último faturamento informado."></a></p>
			<hr width="95%">
			-->
			<ul id="results" class="update"></ul>
		</div>
	</body>
	<!-- 
		https://www.w3schools.com/w3css/w3css_effects.asp
		https://www.w3schools.com/bootstrap4/
		https://www.w3schools.com/bootstrap/trybs_theme_company_full.htm
		https://www.materialpalette.com/colors
		https://materialdesignicons.com/
	-->
</html>