<?php

// Inicia sessão para poder destruí-la
session_start();

// Destrói todas as variáveis da sessão
session_destroy();

// Redireciona o usuário para a tela de login
header("Location: login.php");

?>