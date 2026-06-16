<?php include 'views/layout/header.php'; ?>

<div class="container mt-4">

    <div class="card shadow-sm p-4">

        <!-- 🔝 HEADER -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0">Histórico de Uso</h4>

            <a href="index.php?modulo=veiculos&acao=listar" class="btn btn-secondary btn-sm">
                Voltar
            </a>
        </div>

        <!-- 🔍 FILTROS -->
        <form method="GET" class="row g-2 mb-4">

            <input type="hidden" name="modulo" value="veiculos">
            <input type="hidden" name="acao" value="historico">

            <div class="col-md-4">
                <input type="text" name="veiculo" class="form-control" placeholder="Buscar veículo">
            </div>

            <div class="col-md-3">
                <input type="date" name="data_inicio" class="form-control">
            </div>

            <div class="col-md-3">
                <input type="date" name="data_fim" class="form-control">
            </div>

            <div class="col-md-2">
                <button class="btn btn-primary w-100">Filtrar</button>
            </div>

        </form>

        <!-- 📋 TABELA -->
        <div class="table-responsive">

            <table class="table table-striped table-hover align-middle">

                <thead class="table-dark">
                    <tr>
                        <th>Veículo</th>
                        <th>Data</th>
                        <th>Horas</th>
                        <th>Usuário</th>
                    </tr>
                </thead>

                <tbody>

                <?php if ($movimentacoes && $movimentacoes->num_rows > 0): ?>

                    <?php while($m = $movimentacoes->fetch_assoc()): ?>

                        <tr>

                            <td>
                                <strong><?= htmlspecialchars($m['nome']); ?></strong>
                            </td>

                            <td>
                                <?= date('d/m/Y H:i', strtotime($m['data_registro'])); ?>
                            </td>

                            <td>
                                <span class="badge bg-success">
                                    <?= $m['horas_usadas']; ?> h
                                </span>
                            </td>

                            <td>
                                <span class="badge bg-secondary">
                                    <?= htmlspecialchars($m['usuario']); ?>
                                </span>
                            </td>

                        </tr>

                    <?php endwhile; ?>

                <?php else: ?>

                    <tr>
                        <td colspan="4" class="text-center text-muted">
                            Nenhum registro encontrado
                        </td>
                    </tr>

                <?php endif; ?>

                </tbody>

            </table>

        </div>

    </div>

</div>

<?php include 'views/layout/footer.php'; ?>