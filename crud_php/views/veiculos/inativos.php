<?php include __DIR__ . '/../layout/header.php'; ?>

<div class="container mt-4">

    <div class="card shadow-sm p-4">

        <!-- 🔝 HEADER -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0">Veículos Inativos</h4>

            <a href="index.php?modulo=veiculos&acao=listar" class="btn btn-secondary btn-sm">
                Voltar
            </a>
        </div>

        <!-- 📋 TABELA -->
        <div class="table-responsive">

            <table class="table table-striped table-hover align-middle">

                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Placa</th>
                        <th>Série</th>
                        <th>Motivo</th>
                        <th>Data</th>
                        <th>Ação</th>
                    </tr>
                </thead>

                <tbody>

                <?php if ($veiculos && $veiculos->num_rows > 0): ?>

                    <?php while($v = $veiculos->fetch_assoc()): ?>

                        <tr>

                            <td><?= $v['id']; ?></td>

                            <td>
                                <strong><?= htmlspecialchars($v['nome'] ?? '-'); ?></strong>
                            </td>

                            <td><?= htmlspecialchars($v['placa'] ?? '-'); ?></td>

                            <td><?= htmlspecialchars($v['numero_serie'] ?? '-'); ?></td>

                            <td>
                                <span class="badge bg-danger">
                                    <?= htmlspecialchars($v['motivo_inativacao'] ?? 'Não Informado'); ?>
                                </span>
                            </td>

                            <td>
                                <?php if (!empty($v['data_inativacao'])): ?>
                                    <?= date('d/m/Y H:i', strtotime($v['data_inativacao'])); ?>
                                <?php else: ?>
                                    <span class="text-muted">—</span>
                                <?php endif; ?>
                            </td>

                            <td>
                                <a href="index.php?modulo=veiculos&acao=reativar&id=<?= $v['id']; ?>"
                                   class="btn btn-success btn-sm"
                                   onclick="return confirm('Deseja reativar este veículo?')">
                                    Reativar
                                </a>
                            </td>

                        </tr>

                    <?php endwhile; ?>

                <?php else: ?>

                    <tr>
                        <td colspan="7" class="text-center text-muted">
                            Nenhum veículo inativo
                        </td>
                    </tr>

                <?php endif; ?>

                </tbody>

            </table>

        </div>

    </div>

</div>

<?php include __DIR__ . '/../layout/footer.php'; ?>