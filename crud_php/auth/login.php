<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Login - Saffrix</title>

<!-- Bootstrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- CSS personalizado -->
<link rel="stylesheet" href="/crud_php/assets/css/login.css">

</head>

<body>

<div class="container-fluid">
<div class="row vh-100">

    <!-- LADO ESQUERDO (IMAGEM) -->
    <div class="col-md-6 d-none d-md-flex login-bg">
        <div class="overlay"></div>
        <div class="content text-white">
            <img src="/crud_php/assets/img/logo.png" class="logo mb-3">
            <h1>Saffrix</h1>
            <p>Gestão inteligente de frota agrícola</p>
        </div>
    </div>

    <!-- LADO DIREITO (FORMULÁRIO) -->
    <div class="col-md-6 d-flex align-items-center justify-content-center">

        <div class="login-box">

            <h3 class="mb-4 text-center">Acesso ao Sistema</h3>
            <form action="autenticar.php" method="POST">
            

                <div class="mb-3">
                    <label>Usuario</label>
                    <input type="text" name="usuario" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Senha</label>
                    <input type="password" name="senha" class="form-control" required>
                </div>

                <button class="btn btn-success w-100">Entrar</button>

        <div class="d-flex justify-content-between mt-3">

        <div class="text-center mt-3">
            <a href="esqueci_senha.php">Esqueci minha senha</a>
        </div>

        </div>

            </form>

        </div>

    </div>

</div>
</div>

</body>
</html>