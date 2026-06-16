<?php
include '../config/database.php';

$token = $_GET['token'] ?? '';

$stmt = $conn->prepare(
    "SELECT id FROM login WHERE reset_token=? AND reset_expira > NOW()"
);
$stmt->bind_param("s", $token);
$stmt->execute();

$user = $stmt->get_result()->fetch_assoc();

if (!$user) {
    die("Link inválido ou expirado.");
}
?>

<form method="POST" action="salvar_nova_senha.php">
<input type="hidden" name="token" value="<?= $token ?>">

Nova senha:
<input type="password" name="senha" required>

<button>Salvar</button>
</form>