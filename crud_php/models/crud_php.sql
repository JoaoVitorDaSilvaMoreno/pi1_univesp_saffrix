CREATE DATABASE crud_php;

CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100),
    email VARCHAR(100),
    nivel ENUM('admin','usuario') DEFAULT 'usuario'
);



CREATE TABLE login (

id INT AUTO_INCREMENT PRIMARY KEY,
usuario VARCHAR(50) NOT NULL,
senha VARCHAR(255) NOT NULL

);

CREATE TABLE veiculos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    placa VARCHAR(20) NOT NULL
);

<?php

// Inicia uma sessão PHP
// Sessões permitem guardar informações do usuário logado
session_start();

?>

<!-- Título da página -->
<h2>Login</h2>

<!-- Formulário que envia os dados para autenticar.php -->
<form action="autenticar.php" method="POST">

<!-- Campo usuário -->
<label>Usuário</label>
<br>

<!-- Input onde o usuário digita o nome de usuário -->
<input type="text" name="usuario">

<br><br>

<!-- Campo senha -->
<label>Senha</label>
<br>

<!-- Input onde o usuário digita a senha -->
<input type="password" name="senha">

<br><br>

<!-- Botão que envia o formulário -->
<button type="submit">Entrar</button>

<br><br>

<a href="cadastrar.php">Criar novo usuário</a>

</form>