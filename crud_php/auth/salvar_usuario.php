<?php

// ativa erros
ini_set('display_errors', 1);
error_reporting(E_ALL);

// inicia sessão
session_start();

// conexão com banco
include '../config/database.php';

// recebe dados do formulário
$usuario = $_POST['usuario'];
$senha = $_POST['senha'];

// criptografa senha
$senha_hash = password_hash($senha, PASSWORD_DEFAULT);

// SQL para inserir usuário
$sql = "INSERT INTO login (usuario, senha)
VALUES ('$usuario', '$senha_hash')";

// executa query
if ($conn->query($sql) === TRUE) {

    echo "Usuário cadastrado com sucesso!";
    echo "<br><a href='login.php'>Voltar para login</a>";

} else {

    echo "Erro: " . $conn->error;

}

?>