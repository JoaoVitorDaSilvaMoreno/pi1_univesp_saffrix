<?php include 'views/layout/header.php'; ?>

<div class="container mt-5">

    <div class="alert alert-danger shadow-sm p-4 text-center">

        <h4 class="mb-3">⚠️ Erro ao cadastrar usuário</h4>

        <p class="mb-4">
            <?= htmlspecialchars($erro); ?>
        </p>

        <a href="index.php?modulo=usuarios&acao=criar" class="btn btn-primary">
            Voltar
        </a>

    </div>

</div>

<?php include 'views/layout/footer.php'; ?>