<?php include 'views/layout/header.php'; ?>

<div class="container mt-4">

    <div class="card shadow-sm p-4">

        <h4 class="mb-4">Cadastrar Veículo</h4>

        <form method="POST" action="index.php?modulo=veiculos&acao=salvar">

            <div class="row">

                <!-- Nome -->
                <div class="col-md-6 mb-3">
                    <label class="form-label">Nome do Veículo</label>
                    <input type="text" name="nome" class="form-control" required>
                </div>

                <!-- Placa -->
                <div class="col-md-3 mb-3">
                    <label class="form-label">Placa</label>
                    <input type="text" name="placa" class="form-control" placeholder="ABC-1D23">
                </div>

                <!-- Número de Série -->
                <div class="col-md-3 mb-3">
                    <label class="form-label">Nº Série</label>
                    <input type="text" name="numero_serie" class="form-control">
                </div>

                <!-- Horas trabalhadas -->
                <div class="col-md-4 mb-3">
                    <label class="form-label">Horas Trabalhadas</label>
                    <input type="number" name="horas_trabalhadas" class="form-control" value="0">
                </div>

                <!-- Intervalo manutenção -->
                <div class="col-md-4 mb-3">
                    <label class="form-label">Intervalo de Manutenção (horas)</label>
                    <input type="number" name="horas_manutencao" class="form-control" placeholder="Minimo 1 hora" required min="1">
                </div>

            </div>

            <!-- BOTÕES -->
            <div class="d-flex justify-content-between mt-4">

                <a href="index.php?modulo=veiculos&acao=listar" class="btn btn-secondary">
                    Voltar
                </a>

                <button class="btn btn-success">
                    Salvar Veículo
                </button>

            </div>

        </form>

    </div>

</div>

<?php include 'views/layout/footer.php'; ?>