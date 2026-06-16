<?php
include __DIR__ . '/../config/database.php';

$token = $_POST['token'];
$senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);

$stmt = $conn->prepare(
    "SELECT id FROM login WHERE token_reset=? AND token_expira > NOW()"
);
$stmt->bind_param("s", $token);
$stmt->execute();

$res = $stmt->get_result();

if ($res->num_rows === 0) {
    die("Token inválido ou expirado");
}

$user = $res->fetch_assoc();

$stmt = $conn->prepare(
    "UPDATE login 
     SET senha=?, token_reset=NULL, token_expira=NULL 
     WHERE id=?"
);
$stmt->bind_param("si", $senha, $user['id']);
$stmt->execute();

header("Location: ../index.php?msg=senha_ok");
exit;