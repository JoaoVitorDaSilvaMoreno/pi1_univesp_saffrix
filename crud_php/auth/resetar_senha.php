<?php include __DIR__ . '/../views/layout/header.php'; ?>

<div class="container mt-5">
<div class="row justify-content-center">
<div class="col-md-5">

<div class="card shadow-sm p-4">

<h4 class="text-center mb-3">Nova Senha</h4>

<form method="POST" action="salvar_nova_senha.php">

<input type="hidden" name="token" value="<?= $_GET['token']; ?>">

<label>Nova senha</label>
<input type="password" name="senha" class="form-control mb-3" required>

<button class="btn btn-success w-100">Salvar nova senha</button>

</form>

</div>
</div>
</div>
</div>

<?php include __DIR__ . '/../views/layout/footer.php'; ?>