<?php
include __DIR__ . '/../config/database.php';

$usuario = $_POST['usuario'];

$stmt = $conn->prepare("SELECT id, email FROM login WHERE usuario=?");
$stmt->bind_param("s", $usuario);
$stmt->execute();
$res = $stmt->get_result();

if ($res->num_rows === 0) {
    die("Usuário não encontrado");
}

$user = $res->fetch_assoc();

$token = bin2hex(random_bytes(32));
$expira = date('Y-m-d H:i:s', strtotime('+30 minutes'));

$stmt = $conn->prepare(
    "UPDATE login SET token_reset=?, token_expira=? WHERE id=?"
);
$stmt->bind_param("ssi", $token, $expira, $user['id']);
$stmt->execute();

$link = "http://localhost/crud_php/auth/resetar_senha.php?token=$token";

$assunto = "Redefinição de senha";
$mensagem = "Clique no link para redefinir sua senha:\n\n$link";

mail($user['email'], $assunto, $mensagem);

header("Location: esqueci_senha.php?msg=ok");
exit;