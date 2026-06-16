<?php include 'views/layout/header.php'; ?>

<h2 class="mb-3">Usuários</h2>

<!-- 🔍 FORMULÁRIO DE BUSCA -->
<form method="GET" action="index.php" class="mb-3 d-flex gap-2">

    <input type="hidden" name="modulo" value="usuarios">
    <input type="hidden" name="acao" value="listar">

    <input class="form-control" type="text" name="nome" placeholder="Pesquisar usuário">

    <button class="btn btn-primary">Buscar</button>

</form>

<!-- 🔐 AÇÕES ADMIN -->
<?php if ($_SESSION['nivel'] == 'admin'): ?>

<div class="mb-3">

<a class="btn btn-success btn-sm" href="index.php?modulo=usuarios&acao=criar">
Novo Usuário
</a>

</div>

<?php endif; ?>

<!-- 📋 TABELA -->
<div class="card card-custom p-3">

<div class="table-responsive">

<table class="table table-striped table-hover">

<thead class="table-dark">
<tr>
    <th>ID</th>
    <th>Usuário</th>
    <th>Nível</th>
    <th>Ações</th>
</tr>
</thead>

<tbody>

<?php while($row = $usuarios->fetch_assoc()): ?>

<tr>

<td><?= $row['id']; ?></td>

<!--usuario -->
<td><?= htmlspecialchars($row['usuario']); ?></td>

<!--nivel -->
<td>
    <span class="badge bg-secondary">
        <?= htmlspecialchars($row['nivel']); ?>
    </span>
</td>

<td>

<?php if ($_SESSION['nivel'] == 'admin'): ?>

<a class="btn btn-sm btn-primary mb-1"
href="index.php?modulo=usuarios&acao=editar&id=<?= $row['id']; ?>">
Editar
</a>

<a class="btn btn-sm btn-danger mb-1"
href="index.php?modulo=usuarios&acao=deletar&id=<?= $row['id']; ?>"
onclick="return confirm('Tem certeza que deseja excluir este usuário?')">
Deletar
</a>

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
href="index.php?modulo=usuarios&acao=listar&pagina=<?= $i ?>">
<?= $i ?>
</a>

<?php endfor; ?>

</div>

<?php include 'views/layout/footer.php'; ?>