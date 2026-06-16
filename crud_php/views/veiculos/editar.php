<?php include 'views/layout/header.php'; ?>

<div class="container mt-4">

    <div class="card shadow-sm p-4">

        <!-- Cabeçalho -->
        <h4 class="mb-4">Editar Veículo</h4>

        <div class="card-body">

            <form method="POST" action="index.php?modulo=veiculos&acao=atualizar">

                <!-- ID -->
                <input type="hidden" name="id" value="<?= $veiculoEditar['id']; ?>">

                <div class="row">

                    <!-- Nome -->
                    <div class="col-md-12 mb-3">
                        <label class="form-label fw-semibold">Nome do Veículo</label>
                        <input type="text"
                               name="nome"
                               class="form-control"
                               value="<?= htmlspecialchars($veiculoEditar['nome'] ?? ''); ?>"
                               required>
                    </div>

                    <!-- Placa -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Placa</label>
                        <input type="text"
                               name="placa"
                               class="form-control text-uppercase"
                               maxlength="7"
                               value="<?= htmlspecialchars($veiculoEditar['placa'] ?? ''); ?>">
                    </div>

                    <!-- Número de Série -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Número de Série</label>
                        <input type="text"
                               name="numero_serie"
                               class="form-control"
                               value="<?= htmlspecialchars($veiculoEditar['numero_serie'] ?? ''); ?>">
                    </div>

                </div>

                <!-- Botões -->
                <div class="d-flex justify-content-between mt-3">

                    <a href="index.php?modulo=veiculos&acao=listar"
                       class="btn btn-outline-secondary">
                        Voltar
                    </a>

                    <button class="btn btn-success px-4">
                        Atualizar
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

<?php include 'views/layout/footer.php'; ?>