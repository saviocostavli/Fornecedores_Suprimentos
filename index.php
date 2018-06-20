<!DOCTYPE html>
<html lang="en">
	<head>
  		<title>Fornecedores VLI</title>
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

		<script type="text/javascript">
            $(function() {
                $(".search_button").click(function() {
                    var searchString = $("#search_box").val();
                    var data = 'search='+ searchString;

                    if(searchString) {
                        $.ajax({
                            type: "POST",
                            url: "connector/conexao_hana_suprimentos.php",
                            data: data,
                            beforeSend: function(html) {
                                $("#results").html('');
                                $(".word").html(searchString);
                            },
                            success: function(html){
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
				<form class="form-inline" method="post" action="connector/conexao_hana_suprimentos.php">
					<div class="input-group" style="text-align:center; margin: 0 auto;">
						<input type="text" name="search" id="search_box" class='form-control' size="50" placeholder="Informe o CNPJ do fornecedor." required/>
						<input type="submit" name="submit_search" value="Search" class="search_button btn btn-danger" /><br />
					</div>
                </form>
			</div>
		</div>

		<div style="background-color:white; width:95%; text-align:left; margin: 20px auto; padding: 10px;">
			<ul id="results" class="update"></ul>
		</div>
	</body>
</html>