<?php

// inicia sessão (caso ainda não esteja iniciada)
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// verifica se está logado
if (!isset($_SESSION['usuario'])) {

    // redireciona para login
    header("Location: auth/login.php");
    exit;
}

// função para permitir apenas ADMIN
function apenasAdmin() {

    // verifica nível
    if ($_SESSION['nivel'] != 'admin') {

        echo "Acesso negado!";
        exit;

    }

}

// função para permitir apenas usuários logados
function apenasLogado() {

    if (!isset($_SESSION['usuario'])) {

        header("Location: auth/login.php");
        exit;

    }

}