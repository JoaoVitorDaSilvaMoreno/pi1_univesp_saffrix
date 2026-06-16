<?php include 'views/layout/header.php'; ?>

<div class="dashboard-bg">

<h2 class="mb-4">Dashboard</h2>

<div class="row g-3">

    <!-- TOTAL VEÍCULOS -->
    <div class="col-md-3">
        <div class="card text-white bg-primary p-3">
            <h6>Total Veículos</h6>
            <h3><?= $totalVeiculos ?? 0 ?></h3>
        </div>
    </div>

    <!-- EM CAMPO -->
    <div class="col-md-3">
        <div class="card text-white bg-info p-3">
            <h6>Em Campo</h6>
            <h3><?= $emCampo ?? 0 ?></h3>
        </div>
    </div>

    <!-- MANUTENÇÃO VENCIDA -->
    <div class="col-md-3">
        <div class="card text-white bg-danger p-3">
            <h6>Manutenção Vencida</h6>
            <h3><?= $manutencaoVencida ?? 0 ?></h3>
        </div>
    </div>

    <!-- PRÓXIMA MANUTENÇÃO -->
    <div class="col-md-3">
        <div class="card text-dark bg-warning p-3">
            <h6>Próximas</h6>
            <h3><?= $manutencaoProxima ?? 0 ?></h3>
        </div>
    </div>

</div>

<!-- GRÁFICO -->
<div class="card mt-4 p-3">
    <h5>Uso dos Veículos (Horas)</h5>
    <canvas id="graficoUso"></canvas>
</div>

</div>

<canvas id="graficoUso"></canvas>

<!-- JS DO GRÁFICO -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
const ctx = document.getElementById('graficoUso');

new Chart(ctx, {
    type: 'bar',
    data: {
        labels: <?= json_encode($nomes) ?>,
        datasets: [{
            label: 'Horas Trabalhadas',
            data: <?= json_encode($horas) ?>
        }]
    }
});
</script>

<div class="card mt-4 p-3">
    <h5>Manutenções por Período</h5>
    <canvas id="graficoManutencao"></canvas>
</div>

<script>
const ctxManutencao = document.getElementById('graficoManutencao');

new Chart(ctxManutencao, {
    type: 'line',
    data: {
        labels: <?= json_encode($datas) ?>,
        datasets: [{
            label: 'Manutenções realizadas',
            data: <?= json_encode($totais) ?>,
            tension: 0.3
        }]
    }
});
</script>

<?php include 'views/layout/footer.php'; ?>