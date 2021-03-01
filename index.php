<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Buscar Endereço</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">

    <!-- Own CSS -->
    <style>
        body{
          background: url("img/darker correios.jpg") no-repeat center center fixed;
          -webkit-background-size: cover;
          -moz-background-size: cover;
          -o-background-size: cover;
          background-size: cover;
        }
    </style>

    <?php // Start Connection with Database
    require 'conexao.php';?>

  </head>

  <body class="d-flex align-items-center">
    <?php
      // Checa se a url possui o parâmetro do CEP, para mostrar as informações do mesmo.
      if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['cep']) && checaCEP($_POST['cep'])){
        
        // Extrai o CEP da URL.
        $uri_parts = explode('?', $_SERVER['REQUEST_URI'], 2);
        $url = 'http://' . $_SERVER['HTTP_HOST'] . $uri_parts[0];

        // Obtém o objeto consulta do banco de dados ou do site ViaCep.
        $consulta = getConsulta($conexao, $_POST['cep']);

        // Exibe todas as informações encontradas do CEP informado.
        echo '<div class="container bg-light p-5 text-center">
        <h1 class="display-4 mb-5">'.$consulta->localidade.' / '.$consulta->uf.'</h1>';

        if($consulta->bairro != ""){echo '<p class="lead">Bairro: '.$consulta->bairro.'</p>';}
        if($consulta->logradouro != ""){echo '<p class="lead">Logradouro: '.$consulta->logradouro.'</p>';}
        if($consulta->complemento != ""){echo '<p class="lead">Complemento: '.$consulta->complemento.'</p>';}
        if($consulta->ddd != ""){echo '<p class="lead">DDD: '.$consulta->ddd.'</p>';}
        if($consulta->ibge != ""){echo '<p class="lead">IBGE: '.$consulta->ibge.'</p>';}
        if($consulta->gia != ""){echo '<p class="lead">GIA: '.$consulta->gia.'</p>';}
        if($consulta->siafi != ""){echo '<p class="lead">SIAFI: '.$consulta->siafi.'</p>';}

        echo '<a class="btn btn-primary btn-lg rounded-0 mt-3" href="'.$url.'">Nova Consulta</a></div>';
      }else{
        // Caso a URL não possua o parâmetro do CEP, exibe o formulário de consulta.
        echo '<div class="container bg-light p-5 text-center">
          
            <h1 class="display-4">Buscar Endereço</h1>
            <p class="lead">Procure um endereço pelo CEP.</p>';
            // Checa se é necessário informar ao usuário que o CEP informado é inválido.
            if(!checaCEP($_POST['cep'])){
              echo '<div class="alert alert-danger" role="alert">
                      CEP inválido! Informe um CEP existente usando apenas números.
                    </div>';
            }echo '<form class="input-group mt-5 justify-content-center" method="post">
              <input type="number" class="form-control rounded-0" maxlength="8" style="max-width: 400" placeholder="CEP" name="cep">
              <input class="btn btn-primary btn-lg rounded-0" id="buttonBuscar" type="submit" value="Buscar">
            </form>
          </div>';
      }
    ?>
  </body>
</html>