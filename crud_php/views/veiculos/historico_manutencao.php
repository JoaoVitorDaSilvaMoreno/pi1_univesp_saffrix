<?php include __DIR__ . '/../layout/header.php'; ?>

<div class="container mt-4">

    <div class="card shadow-sm p-4">

        <!-- 🔝 HEADER -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0">Histórico de Manutenção</h4>

            <a href="index.php?modulo=veiculos&acao=listar" class="btn btn-secondary btn-sm">
                Voltar
            </a>
        </div>

        <!-- 🔍 FILTROS -->
        <form method="GET" class="row g-2 mb-4">

            <input type="hidden" name="modulo" value="veiculos">
            <input type="hidden" name="acao" value="historico_manutencao">

            <div class="col-md-4">
                <input type="text" name="veiculo" class="form-control"
                       placeholder="Buscar veículo"
                       value="<?= $_GET['veiculo'] ?? '' ?>">
            </div>

            <div class="col-md-3">
                <input type="date" name="data_inicio" class="form-control"
                       value="<?= $_GET['data_inicio'] ?? '' ?>">
            </div>

            <div class="col-md-3">
                <input type="date" name="data_fim" class="form-control"
                       value="<?= $_GET['data_fim'] ?? '' ?>">
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
                        <th>ID</th>
                        <th>Veículo</th>
                        <th>Descrição</th>
                        <th>Horas</th>
                        <th>Data</th>
                    </tr>
                </thead>

                <tbody>

                <?php if ($manutencoes && $manutencoes->num_rows > 0): ?>

                    <?php while($m = $manutencoes->fetch_assoc()): ?>

                        <tr>

                            <td><?= $m['id']; ?></td>

                            <td>
                                <strong><?= htmlspecialchars($m['nome'] ?? $m['veiculo_id']); ?></strong>
                            </td>

                            <td><?= htmlspecialchars($m['descricao']); ?></td>

                            <td>
                                <span class="badge bg-info">
                                    <?= $m['horas_no_momento']; ?> h
                                </span>
                            </td>

                            <td>
                                <?php if (!empty($m['data_manutencao'])): ?>
                                    <?= date('d/m/Y H:i', strtotime($m['data_manutencao'])); ?>
                                <?php else: ?>
                                    <span class="text-muted">Sem data</span>
                                <?php endif; ?>
                            </td>

                        </tr>

                    <?php endwhile; ?>

                <?php else: ?>

                    <tr>
                        <td colspan="5" class="text-center text-muted">
                            Nenhuma manutenção encontrada
                        </td>
                    </tr>

                <?php endif; ?>

                </tbody>

            </table>

        </div>

    </div>

</div>

<?php include __DIR__ . '/../layout/footer.php'; ?>