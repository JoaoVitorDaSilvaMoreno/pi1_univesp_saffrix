<?php

session_start();

// conexão com banco
include '../config/database.php';

// recebe dados do formulário
$usuario = $_POST['usuario'];
$senha = $_POST['senha'];

// busca usuário no banco
$sql = "SELECT * FROM login WHERE usuario='$usuario'";

$result = $conn->query($sql);

// verifica se encontrou usuário
if ($result->num_rows > 0) {

    $row = $result->fetch_assoc();

    // verifica senha
    if (password_verify($senha, $row['senha'])) {

        // salva usuário na sessão
        $_SESSION['usuario'] = $row['usuario'];

        // salva nível vindo do banco
        $_SESSION['nivel'] = $row['nivel'];

        // redireciona para o dashboard
        header("Location: ../index.php?modulo=dashboard");

    } else {
        echo "Senha incorreta";
    }

} else {
    echo "Usuário não encontrado";
}

?>