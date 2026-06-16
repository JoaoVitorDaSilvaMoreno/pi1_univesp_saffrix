<?php include __DIR__ . '/../views/layout/header.php'; ?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-5">

            <div class="card shadow-sm border-0">
                <div class="card-body p-4">

                    <h4 class="text-center mb-4">Recuperar Senha</h4>

                    <form method="POST" action="/crud_php/auth/enviar_reset.php">

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Usuário</label>
                            <input type="text"
                                   name="usuario"
                                   class="form-control"
                                   placeholder="Digite seu usuário"
                                   required>
                        </div>

                        <button class="btn btn-primary w-100">
                            Enviar link de redefinição
                        </button>

                    </form>

                    <div class="text-center mt-3">
                        <a href="../index.php" class="text-decoration-none">
                            Voltar ao login
                        </a>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

<?php include __DIR__ . '/../views/layout/footer.php'; ?>