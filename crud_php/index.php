<?php

// ativa erros
ini_set('display_errors', 1);
error_reporting(E_ALL);

// inicia sessão
session_start();

// verifica login
if (!isset($_SESSION['usuario'])) {
    header("Location: auth/login.php");
    exit;
}

// controle de tempo de sessão
$tempo_limite = 900;

if (isset($_SESSION['ultimo_acesso'])) {

    $tempo_inativo = time() - $_SESSION['ultimo_acesso'];

    if ($tempo_inativo > $tempo_limite) {
        session_destroy();
        header("Location: auth/login.php");
        exit;
    }
}

$_SESSION['ultimo_acesso'] = time();

// define módulo
$modulo = $_GET['modulo'] ?? 'usuarios';

// segurança
$modulosPermitidos = ['usuarios', 'veiculos', 'dashboard'];
if (!in_array($modulo, $modulosPermitidos)) {
    $modulo = 'usuarios';
}

// define ação
$acao = $_GET['acao'] ?? 'listar';

// roteamento
switch ($modulo) {

    case 'dashboard':
        include 'controllers/DashboardController.php';
        break;

    case 'veiculos':
        include 'controllers/VeiculoController.php';
        break;

    case 'usuarios':
    default:
        include 'controllers/UsuarioController.php';
        break;
}