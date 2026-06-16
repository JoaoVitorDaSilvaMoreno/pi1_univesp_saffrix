<?php include __DIR__ . '/../layout/header.php'; ?>

<h2>Inativar Veículo</h2>

<form method="POST" action="index.php?modulo=veiculos&acao=inativar">

    <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">

    <textarea name="motivo" required></textarea>

    <button type="submit">Confirmar</button>

</form>

<?php include __DIR__ . '/../layout/footer.php'; ?>