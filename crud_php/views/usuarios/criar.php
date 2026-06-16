<?php include 'views/layout/header.php'; ?>

<div class="container mt-4">

    <div class="card shadow-sm p-4">

        <h4 class="mb-4">Novo Usuário</h4>

        <form action="index.php?modulo=usuarios&acao=salvar" method="POST">

            <!-- USUÁRIO -->
            <div class="mb-3">
                <label class="form-label">Usuário</label>
                <input type="text" name="usuario" class="form-control" required>
            </div>

            <!-- E-mail -->
            <div class="mb-3">
                <label class="form-label">E-mail</label>
                <input type="email" name="email" class="form-control" required>
            </div>

            <!-- SENHA -->
            <div class="mb-3">
                <label class="form-label">Senha</label>
                <input type="password" name="senha" class="form-control" required>
            </div>

            <!-- NÍVEL -->
            <div class="mb-3">
                <label class="form-label">Nível</label>
                <select name="nivel" class="form-control" required>
                    <option value="admin">Administrador</option>
                    <option value="usuario">Usuário</option>
                </select>
            </div>

            <!-- BOTÕES -->
            <div class="d-flex gap-2">

                <button class="btn btn-success">
                    Salvar
                </button>

                <a href="index.php?modulo=usuarios&acao=listar" class="btn btn-secondary">
                    Voltar
                </a>

            </div>

        </form>

    </div>

</div>

<?php include 'views/layout/footer.php'; ?>