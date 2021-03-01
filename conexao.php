<?php
error_reporting(E_ERROR | E_PARSE);

$servidor = "localhost";
$usuario = "root";
$senha = "";
$database = "buscarCep";

$conexao = new mysqli($servidor, $usuario, $senha, $database);

// Trata o erro, caso não seja possível acessar o banco de dados.
if ($conexao->connect_error){
    echo '<script>alert("Não foi possível se conectar ao banco de dados, devido ao erro:\n'.$conexao->connect_error.'")</script>';
}


function getConsulta($conexao, $cep){
    // Checa se a consulta já existe.
    $sqlQuery = "SELECT * FROM consulta WHERE cep='".$cep."'";
    $resultado = $conexao->query($sqlQuery);

    if($resultado->num_rows != 0){ 
        // Caso exista, pega a consulta do bando de dados em forma de objeto.
        $consulta = (object) $resultado->fetch_assoc();
        return $consulta;
    }else{
        // Caso não exista, pega as informações do site ViaCep.
        $response = file_get_contents('https://viacep.com.br/ws/'.$cep.'/xml');
        $consulta = simplexml_load_string($response);

        if(checaCEP($consulta)){

            // Salva no banco de dados APENAS AS INFORMAÇÕES ENCONTRADAS.

            $sqlQuery = "INSERT INTO consulta ( cep";

            if($consulta->localidade != ""){$sqlQuery .= ",localidade";}
            if($consulta->uf != ""){$sqlQuery .= ",uf";}
            if($consulta->ddd != ""){$sqlQuery .= ",ddd";}
            if($consulta->bairro != ""){$sqlQuery .= ",bairro";}
            if($consulta->logradouro != ""){$sqlQuery .= ",logradouro";}
            if($consulta->complemento != ""){$sqlQuery .= ",complemento";}
            if($consulta->ibge != ""){$sqlQuery .= ",ibge";}
            if($consulta->gia != ""){$sqlQuery .= ",gia";}
            if($consulta->siafi != ""){$sqlQuery .= ",siafi";}

            $sqlQuery .= ") VALUES ( '$cep'";

            if($consulta->localidade != ""){$sqlQuery .= ",'$consulta->localidade'";}
            if($consulta->uf != ""){$sqlQuery .= ",'$consulta->uf'";}
            if($consulta->ddd != ""){$sqlQuery .= ",$consulta->ddd";}
            if($consulta->bairro != ""){$sqlQuery .= ",'$consulta->bairro'";}
            if($consulta->logradouro != ""){$sqlQuery .= ",'$consulta->logradouro'";}
            if($consulta->complemento != ""){$sqlQuery .= ",'$consulta->complemento'";}
            if($consulta->ibge != ""){$sqlQuery .= ",'$consulta->ibge'";}
            if($consulta->gia != ""){$sqlQuery .= ",'$consulta->gia'";}
            if($consulta->siafi != ""){$sqlQuery .= ",'$consulta->siafi'";}

            $sqlQuery .= ")";
            $conexao->query($sqlQuery);

            return $consulta;
        }else {
            return $consulta;
        }

        
    }
}

function checaCEP($consulta){
    // Checa se o CEP informado é válido.
    if(strlen($_POST['cep']) != 8 || preg_match("/[a-z]/i", $_POST['cep']) || $consulta->erro){
        return false;
    }
    return true;
}

// Função usada para debugs pelo console do navegador.
function consoleLog($data){
    echo '<script>
            console.log("'.$data.'")
        </script>';
}
?>