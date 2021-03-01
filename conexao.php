<?php
error_reporting(E_ERROR | E_PARSE);

$servidor = "localhost";
$usuario = "root";
$senha = "";

$conexao = new mysqli($servidor, $usuario, $senha);

if ($conexao->connect_error){
    echo '<script>alert("Não foi possível se conectar ao banco de dados, devido ao erro:\n'.$conexao->connect_error.'")</script>';
}
?>