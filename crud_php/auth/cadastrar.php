<?php
// inicia sessão
session_start();
?>

<h2>Cadastrar Usuário</h2>

<form action="salvar_usuario.php" method="POST">

<label>Usuário</label>
<br>
<input type="text" name="usuario" required>

<br><br>

<label>Senha</label>
<br>
<input type="password" name="senha" required>

<br><br>

<button type="submit">Cadastrar</button>

</form>

<br>

<a href="login.php">Voltar para login</a>