<?php 
$id = $_GET['id'] ?? 0;
include __DIR__ . '/../layout/header.php'; 
?>

<div class="container mt-4">

    <div class="card shadow-sm border-0">

        <!-- Cabeçalho -->
        <div class="card-body p-4">

            <h4 class="mb-4">Registrar Retorno do Campo</h4>

            <!-- Informações do veículo -->
            <div class="mb-4">
                <label class="form-label fw-semibold">Veículo</label>
                <input type="text"
                       class="form-control mb-2"
                       value="<?= htmlspecialchars($veiculoRetorno['nome'] ?? ''); ?>"
                       disabled>

                <small class="text-muted">
                    Horas atuais:
                    <strong><?= $veiculoRetorno['horas_trabalhadas']; ?> h</strong>
                </small>
            </div>

            <!-- Formulário -->
            <form method="POST" action="index.php?modulo=veiculos&acao=salvar_retorno">

                <input type="hidden" name="id" value="<?= htmlspecialchars($id); ?>">

                <div class="mb-3">
                    <label class="form-label fw-semibold">Horas trabalhadas no dia</label>
                    <input type="number"
                           name="horas_uso"
                           class="form-control"
                           min="1"
                           placeholder="Ex: 8"
                           required>
                </div>

                <!-- Botões -->
                <div class="d-flex justify-content-between mt-4">
                    <a href="index.php?modulo=veiculos&acao=listar"
                       class="btn btn-outline-secondary">
                        Voltar
                    </a>

                    <button class="btn btn-success px-4">
                        Salvar
                    </button>
                </div>

            </form>

        </div>
    </div>

</div>

<?php include __DIR__ . '/../layout/footer.php'; ?>