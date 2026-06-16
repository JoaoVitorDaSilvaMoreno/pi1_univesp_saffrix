<?php include 'views/layout/header.php'; ?>

<div class="container mt-4">

    <div class="card shadow-sm p-4">

        <h4 class="mb-4">Editar Usuário</h4>

        <form action="index.php?modulo=usuarios&acao=atualizar" method="POST">

            <!-- ID -->
            <input type="hidden" name="id" value="<?= $usuarioEditar['id']; ?>">

            <!-- USUÁRIO -->
            <div class="mb-3">
                <label class="form-label">Usuário</label>
                <input type="text"
                       name="usuario"
                       class="form-control"
                       value="<?= htmlspecialchars($usuarioEditar['usuario']); ?>"
                       required>
            </div>

            <!-- SENHA -->
            <div class="mb-3">
                <label class="form-label">Nova Senha</label>
                <input type="password"
                       name="senha"
                       class="form-control"
                       placeholder="Deixe em branco para manter">
            </div>

            <!-- NÍVEL -->
            <div class="mb-3">
                <label class="form-label">Nível</label>
                <select name="nivel" class="form-control" required>

                    <option value="admin"
                        <?= $usuarioEditar['nivel'] === 'admin' ? 'selected' : ''; ?>>
                        Administrador
                    </option>

                    <option value="usuario"
                        <?= $usuarioEditar['nivel'] === 'usuario' ? 'selected' : ''; ?>>
                        Usuário
                    </option>

                </select>
            </div>

            <!-- BOTÕES -->
            <div class="d-flex gap-2">

                <button class="btn btn-primary">
                    Salvar Alterações
                </button>

                <a href="index.php?modulo=usuarios&acao=listar"
                   class="btn btn-secondary">
                    Voltar
                </a>

            </div>

        </form>

    </div>

</div>

<?php include 'views/layout/footer.php'; ?>