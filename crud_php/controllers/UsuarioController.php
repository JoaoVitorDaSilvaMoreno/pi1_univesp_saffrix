<?php

include __DIR__ . '/../config/database.php';
include __DIR__ . '/../models/Usuario.php';
include __DIR__ . '/../middleware/auth.php';

// Instância do model
$usuario = new Usuario($conn);

// Define ação padrão
$acao = $_GET['acao'] ?? 'listar';


/* LISTAR USUÁRIOS*/
if ($acao == "listar") {

    $limite = 10;
    $pagina = $_GET['pagina'] ?? 1;
    $offset = ($pagina - 1) * $limite;

    $usuarios = $usuario->listarPaginado($limite, $offset);
    $totalUsuarios = $usuario->contarUsuarios();
    $totalPaginas = ceil($totalUsuarios / $limite);

    include __DIR__ . '/../views/usuarios/listar.php';
}


/* CRIAR USUÁRIO (FORM)*/
if ($acao == "criar") {

    apenasAdmin();
    include __DIR__ . '/../views/usuarios/criar.php';
}


/* SALVAR NOVO USUÁRIO*/
if ($acao == "salvar") {

    apenasAdmin();

    $loginNome = $_POST['usuario'];
    $senha     = $_POST['senha'];
    $nivel     = $_POST['nivel'];

    try {

        $email = $_POST['email'];

        $usuario->criar($loginNome, $email, $senha, $nivel);

        header("Location: index.php?modulo=usuarios&acao=listar");
        exit;

    } catch (Exception $e) {

        $erro = $e->getMessage(); // "Usuário já existe!"

        include 'views/usuarios/erro.php';
        exit;
    }
}


/* DELETAR*/
if ($acao == "deletar") {

    apenasAdmin();

    $id = $_GET['id'];
    $usuario->deletar($id);

    header("Location: index.php?modulo=usuarios&acao=listar");
    exit;
}


/* EDITAR (FORM)*/
if ($acao == "editar") {

    apenasAdmin();

    $id = $_GET['id'];

    $stmt = $conn->prepare("SELECT * FROM login WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    $usuarioEditar = $stmt->get_result()->fetch_assoc();

    include __DIR__ . '/../views/usuarios/editar.php';
}


/* ATUALIZAR USUÁRIO*/
if ($acao == "atualizar") {

    apenasAdmin();

    $id         = $_POST['id'];
    $usuarioNome= $_POST['usuario'];
    $senha      = $_POST['senha'];
    $nivel      = $_POST['nivel'];

    // Se senha estiver vazia, não atualiza senha
    if (empty($senha)) {
        $usuario->atualizarSemSenha($id, $usuarioNome, $nivel);
    } else {
        $usuario->atualizar($id, $usuarioNome, $senha, $nivel);
    }

    header("Location: index.php?modulo=usuarios&acao=listar");
    exit;
}


/* DASHBOARD*/
if ($acao == "dashboard") {

    $totalUsuarios = $usuario->contarUsuarios();
    include __DIR__ . '/../views/usuarios/dashboard.php';
}


/* BUSCAR*/
if ($acao == "buscar") {

    $nome = $_GET['nome'];
    $usuarios = $usuario->buscar($nome);

    include __DIR__ . '/../views/usuarios/listar.php';
}