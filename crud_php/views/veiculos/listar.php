<?php include 'views/layout/header.php'; ?>

<h2 class="mb-3">Veículos</h2>

<!-- 🔍 FORMULÁRIO DE BUSCA -->
<form method="GET" class="mb-3 d-flex gap-2">

    <input type="hidden" name="modulo" value="veiculos">

    <input class="form-control" type="text" name="busca" placeholder="Buscar veículo">

    <button class="btn btn-primary">Buscar</button>

</form>

<!-- 🔐 AÇÕES ADMIN -->
<?php if ($_SESSION['nivel'] == 'admin'): ?>

<div class="mb-3">

<a class="btn btn-success btn-sm" href="index.php?modulo=veiculos&acao=criar">Novo</a>

<!--
<a class="btn btn-secondary btn-sm" href="index.php?modulo=veiculos&acao=historico">Histórico</a>
-->

<a class="btn btn-info btn-sm" href="index.php?modulo=veiculos&acao=historico_manutencao">Manutenção</a>

<a class="btn btn-warning btn-sm" href="index.php?modulo=veiculos&acao=relatorio">Relatório</a>

<a class="btn btn-dark btn-sm" href="index.php?modulo=veiculos&acao=inativos">Inativos</a>

</div>

<?php endif; ?>

<!-- 📋 TABELA -->
<div class="card card-custom p-3">

<div class="table-responsive">

<table class="table table-striped table-hover">

<thead class="table-dark">
<tr>
    <th>ID</th>
    <th>Nome</th>
    <th>Placa</th>
    <th>Série</th>
    <th>Horas</th>
    <th>Manutenção</th>
    <th>Status</th>
    <th>Ações</th>
</tr>
</thead>

<tbody>

<?php while($v = $veiculos->fetch_assoc()): ?>

<tr>

<td><?= $v['id']; ?></td>
<td><?= htmlspecialchars($v['nome'] ?? ''); ?></td>
<td><?= htmlspecialchars($v['placa'] ?? '-'); ?></td>
<td><?= htmlspecialchars($v['numero_serie'] ?? '-'); ?></td>
<td><?= $v['horas_trabalhadas'] ?? 0; ?></td>
<td><?= $v['horas_manutencao'] ?? 0; ?></td>

<td>
<?php

$ultima = !empty($v['ultima_manutencao']) ? $v['ultima_manutencao'] : $v['horas_trabalhadas'];

$uso = $v['horas_trabalhadas'] - $ultima;

$limite = $v['horas_manutencao'] ?? 0;

// 🔴 manutenção não definida
if ($limite <= 0) {

    echo "<span class='text-secondary fw-bold'>NÃO DEFINIDO</span>";

} 
// 🔴 vencida
elseif ($uso >= $limite) {

    echo "<span class='text-danger fw-bold'>VENCIDA</span>";

} 
// 🟡 próxima
elseif (($limite - $uso) <= 20) {

    echo "<span class='text-warning fw-bold'>PRÓXIMA</span>";

} 
// 🟢 ok
else {

    echo "<span class='text-success fw-bold'>OK</span>";

}

?>
</td>

<td>

<?php if ($_SESSION['nivel'] == 'admin'): ?>

<a class="btn btn-sm btn-primary mb-1" href="index.php?modulo=veiculos&acao=editar&id=<?= $v['id']; ?>">
Editar
</a>

<a class="btn btn-sm btn-danger mb-1" href="index.php?modulo=veiculos&acao=form_inativar&id=<?= $v['id']; ?>">
Inativar
</a>

<?php if ($v['status'] == 'garagem'): ?>
<a class="btn btn-sm btn-info mb-1" href="index.php?modulo=veiculos&acao=ir_campo&id=<?= $v['id']; ?>">
Campo
</a>
<?php endif; ?>

<?php if ($v['status'] == 'campo'): ?>
<a class="btn btn-sm btn-secondary mb-1" href="index.php?modulo=veiculos&acao=form_retorno&id=<?= $v['id']; ?>">
Retorno
</a>
<?php endif; ?>

<?php if ($uso >= $limite && $limite > 0): ?>
<a class="btn btn-sm btn-warning mb-1" href="index.php?modulo=veiculos&acao=manutencao&id=<?= $v['id']; ?>">
Manutenção
</a>
<?php endif; ?>

<?php endif; ?>

</td>

</tr>

<?php endwhile; ?>

</tbody>
</table>

</div>
</div>

<!-- 📄 PAGINAÇÃO -->
<div class="mt-3">

<?php for ($i = 1; $i <= $totalPaginas; $i++): ?>

<a class="btn btn-sm btn-outline-primary"
href="index.php?modulo=veiculos&acao=listar&pagina=<?= $i ?>&busca=<?= $busca ?>">
<?= $i ?>
</a>

<?php endfor; ?>

</div>

<?php include 'views/layout/footer.php'; ?>