<!DOCTYPE html>
<html>

<head>

<title>Painel Administrativo</title>

<link rel="icon" type="image/png" href="/crud_php/assets/img/logo.png">

<link rel="stylesheet" href="/crud_php/assets/css/style.css">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<meta name="viewport" content="width=device-width, initial-scale=1">

</head>

<body>

<div class="container-fluid">
<div class="row">

<!-- BOTÃO MOBILE -->
<button class="btn btn-dark d-md-none m-2" onclick="toggleMenu()">
☰ Menu
</button>

<div class="col-md-2 sidebar text-white d-none d-md-block" id="menu">

<div class="d-flex align-items-center gap-2 mt-3 mb-3">
    <img src="/crud_php/assets/img/logo.png" class="logo">
    <span class="logo-text">Saffrix</span>
</div>

<a href="/crud_php/index.php?modulo=dashboard">Dashboard</a>
<a href="/crud_php/index.php?modulo=usuarios&acao=listar">Usuários</a>
<a href="/crud_php/index.php?modulo=veiculos&acao=listar">Veículos</a>
<a href="/crud_php/auth/logout.php">Sair</a>

</div>

<script>
function toggleMenu() {
    const menu = document.getElementById("menu");
    menu.classList.toggle("d-none");
}
</script>

<div class="col-md-10 col-12 p-3">