<?php include 'views/layout/header.php'; ?>

<div class="container mt-4">

    <div class="card shadow-sm p-4">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="mb-0">Histórico de Uso</h4>

            <a href="index.php?modulo=veiculos&acao=listar" class="btn btn-secondary btn-sm">
                Voltar
            </a>
        </div>

        <!-- 📋 TABELA -->
        <div class="table-responsive">

            <table class="table table-striped table-hover">

                <thead class="table-dark">
                    <tr>
                        <th>Veículo</th>
                        <th>Data</th>
                        <th>Horas Usadas</th>
                        <th>Usuario</th>
                    </tr>
                </thead>

                <tbody>

                <?php while($m = $movimentacoes->fetch_assoc()): ?>

                    <tr>
                        <td><?= htmlspecialchars($m['nome']); ?></td>
                        <td><?= date('d/m/Y H:i', strtotime($m['data_registro'])); ?></td>
                        <td><?= $m['horas_usadas']; ?> h</td>
                        <td><?= $m['usuario']; ?></td>

                    </tr>

                <?php endwhile; ?>

                </tbody>

            </table>

        </div>

    </div>

</div>

<?php include 'views/layout/footer.php'; ?>