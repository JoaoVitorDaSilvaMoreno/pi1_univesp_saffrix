<?php

// Dados de conexão com o banco
$host = "localhost";
$user = "root";
$pass = "";
$db = "crud_php";


// Cria conexão com o banco de dados
$conn = new mysqli($host, $user, $pass, $db);

// Verifica se ocorreu erro na conexão
if ($conn->connect_error) {

    // Interrompe o programa e mostra erro
    die("Erro de conexão: " . $conn->connect_error);

}

?>