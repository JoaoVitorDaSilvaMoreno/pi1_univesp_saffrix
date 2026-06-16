<?php include __DIR__ . '/../layout/header.php'; ?>

<div class="container mt-4">

    <div class="card shadow-sm border-0">

        <div class="card-body p-4">

            <h4 class="mb-4">Registrar Manutenção</h4>

            <!-- Informações do veículo -->
            <div class="mb-4">

                <label class="form-label fw-semibold">Veículo</label>
                <input type="text"
                       class="form-control mb-2"
                       value="<?= htmlspecialchars($veiculo['nome']); ?>"
                       disabled>

                <small class="text-muted">
                    Horas atuais:
                    <strong><?= $veiculo['horas_trabalhadas']; ?> h</strong>
                </small>

            </div>

            <!-- Formulário -->
            <form method="POST" action="index.php?modulo=veiculos&acao=salvar_manutencao">

                <!-- ID do veículo -->
                <input type="hidden" name="id" value="<?= $veiculo['id']; ?>">

                <!-- Descrição -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">Descrição da manutenção</label>

                    <textarea name="descricao"
                              class="form-control"
                              rows="4"
                              placeholder="Ex: Troca de óleo, revisão de filtros..."
                              required></textarea>
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