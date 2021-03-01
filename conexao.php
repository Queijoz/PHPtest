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
    }
}

// Função usada para debugs pelo console do navegador.
function consoleLog($data){
    echo '<script>
            console.log("'.$data.'")
        </script>';
}
?>