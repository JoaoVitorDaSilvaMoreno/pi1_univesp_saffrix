<?php

include __DIR__ . '/../config/database.php';
include __DIR__ . '/../models/Veiculo.php';
include __DIR__ . '/../middleware/auth.php';

$veiculo = new Veiculo($conn);

$acao = $_GET['acao'] ?? 'listar';

// listar
if ($acao == "listar") {

    // busca
    $busca = $_GET['busca'] ?? '';

    // paginação
    $pagina = $_GET['pagina'] ?? 1;
    $limite = 10;
    $offset = ($pagina - 1) * $limite;

    // dados
    $veiculos = $veiculo->listarComBusca($busca, $limite, $offset);
    $total = $veiculo->contar($busca);

    $totalPaginas = ceil($total / $limite);

    include 'views/veiculos/listar.php';
}

// criar (admin)
if ($acao == "criar") {

    apenasAdmin();
    include 'views/veiculos/criar.php';
}

// Ação para salvar veículo
// Ação para salvar veículo
if ($acao == "salvar") {

    // 🔐 Apenas admin pode cadastrar
    apenasAdmin();

    // Recebe dados do formulário
    $nome = $_POST['nome'];
    $placa = strtoupper($_POST['placa'] ?? '');
    $numero_serie = $_POST['numero_serie'] ?? '';
    $horas_trabalhadas = $_POST['horas_trabalhadas'] ?? 0;
    $horas_manutencao = $_POST['horas_manutencao'] ?? 0;

    // 🔴 REGRA PRINCIPAL: deve ter placa OU número de série
    if (empty($placa) && empty($numero_serie)) {
        echo "Informe a placa OU o número de série!";
        exit;
    }

    // 🔎 Validação de placa (somente se informada)
    if (!empty($placa)) {

        if (!preg_match("/^[A-Z]{3}-?[0-9][A-Z0-9][0-9]{2}$/", $placa)) {
            echo "Placa inválida!";
            exit;
        }

        // 🔎 Verifica duplicidade da placa
        $sql = "SELECT id FROM veiculos WHERE placa = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $placa);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo "Essa placa já está cadastrada!";
            exit;
        }
    }

    // 🔎 Verifica duplicidade do número de série
    if (!empty($numero_serie)) {

        $sql = "SELECT id FROM veiculos WHERE numero_serie = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $numero_serie);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo "Esse número de série já está cadastrado!";
            exit;
        }
    }

    // 🔎 Validação do intervalo de manutenção
    if ($horas_manutencao <= 0) {
        echo "Informe um intervalo de manutenção válido! (maior que 0)!";
        exit;
    }

    // 🚀 Chama o model para salvar
    $veiculo->criar(
        $nome,
        $placa,
        $numero_serie,
        $horas_trabalhadas,
        $horas_manutencao
    );

    // 🔄 Redireciona para listagem
    header("Location: index.php?modulo=veiculos&acao=listar");
    exit;
    }

// deletar
if ($acao == "deletar") {

    apenasAdmin();

    $id = $_GET['id'];
    $veiculo->deletar($id);

    header("Location: index.php?modulo=veiculos&acao=listar");
    exit;
    }

// inativar veículo
if ($acao == "form_inativar") {

    apenasAdmin();

    $id = $_GET['id'] ?? null;

    if (!$id) {
        echo "ID não informado!";
        exit;
    }

    include 'views/veiculos/inativar.php';
}

if ($acao == "inativar") {

    apenasAdmin();

    $id = $_POST['id'] ?? null;
    $motivo = $_POST['motivo'] ?? '';

    if (!$id) {
        echo "ID inválido!";
        exit;
    }

    if (empty($motivo)) {
        echo "Informe o motivo da inativação!";
        exit;
    }

    $veiculo->inativar($id, $motivo);

    header("Location: index.php?modulo=veiculos&acao=listar");
    exit;
}

//  LISTAR INATIVOS
if ($acao == "inativos") {

    apenasAdmin();

    $sql = "SELECT * FROM veiculos WHERE ativo = 0";
    $veiculos = $conn->query($sql);

    include 'views/veiculos/inativos.php';
}

// Reativar veiculo
if ($acao == "reativar") {

    apenasAdmin();

    $id = $_GET['id'];

    $veiculo->reativar($id);

    header("Location: index.php?modulo=veiculos&acao=inativos");
    exit;
}

// editar
if ($acao == "editar") {

    apenasAdmin();

    $id = $_GET['id'];
    $veiculoEditar = $veiculo->buscarPorId($id);

    include 'views/veiculos/editar.php';
}

// 🚜 ENVIAR PARA CAMPO
if ($acao == "ir_campo") {

    apenasAdmin();

    $id = $_GET['id'];

    $sql = "UPDATE veiculos SET status='campo' WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();

    header("Location: index.php?modulo=veiculos&acao=listar");
    exit;
    }


// 📄 ABRIR FORMULÁRIO DE RETORNO
if ($acao == "form_retorno") {

    apenasAdmin();

    $id = $_GET['id'] ?? null;

    if (!$id) {
        echo "Veículo inválido!";
        exit;
    }

    // 🔎 busca dados do veículo
    $stmt = $conn->prepare("SELECT nome, horas_trabalhadas FROM veiculos WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $veiculoRetorno = $stmt->get_result()->fetch_assoc();

    include __DIR__ . '/../views/veiculos/retorno.php';
}


// 🏠 SALVAR RETORNO (ATUALIZA HORAS)
if ($acao == "salvar_retorno") {

    apenasAdmin();

    $id = $_POST['id'];
    $horas_uso = $_POST['horas_uso'];
    $usuario = $_SESSION['usuario'];

    if ($horas_uso <= 0) {
        echo "Informe horas válidas!";
        exit;
    }

    // 📜 SALVA HISTÓRICO
    $sqlHist = "INSERT INTO movimentacoes (veiculo_id, horas_usadas, usuario)
                VALUES (?, ?, ?)";

    $stmtHist = $conn->prepare($sqlHist);
    $stmtHist->bind_param("iis", $id, $horas_uso, $usuario);
    $stmtHist->execute();

    // 🚜 ATUALIZA VEÍCULO
    $sql = "UPDATE veiculos 
            SET status='garagem',
                horas_trabalhadas = horas_trabalhadas + ?
            WHERE id=?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $horas_uso, $id);
    $stmt->execute();

    header("Location: index.php?modulo=veiculos&acao=listar");
    exit;
}

if ($acao == "historico") {

    $sql = "SELECT m.*, v.nome 
            FROM movimentacoes m
            JOIN veiculos v ON m.veiculo_id = v.id
            ORDER BY m.data_registro DESC";

    $movimentacoes = $conn->query($sql);

    include __DIR__ . '/../views/veiculos/historico.php';
}

// HISTÓRICO DE MANUTENÇÃO
if ($acao == "historico_manutencao") {

    $veiculo = $_GET['veiculo'] ?? '';
    $data_inicio = $_GET['data_inicio'] ?? '';
    $data_fim = $_GET['data_fim'] ?? '';

    $sql = "SELECT m.*, v.nome 
            FROM manutencoes m
            JOIN veiculos v ON m.veiculo_id = v.id
            WHERE 1=1";

    if (!empty($veiculo)) {
        $sql .= " AND v.nome LIKE '%$veiculo%'";
    }

    if (!empty($data_inicio)) {
        $sql .= " AND DATE(m.data_manutencao) >= '$data_inicio'";
    }

    if (!empty($data_fim)) {
        $sql .= " AND DATE(m.data_manutencao) <= '$data_fim'";
    }

    $sql .= " ORDER BY m.data_manutencao DESC";

    $manutencoes = $conn->query($sql);

    include 'views/veiculos/historico_manutencao.php';
}

// 📊 RELATÓRIO
if ($acao == "relatorio") {

    // pega filtros
    $data_inicio = $_GET['data_inicio'] ?? '';
    $data_fim = $_GET['data_fim'] ?? '';
    $veiculo_id = $_GET['veiculo_id'] ?? '';

    // base da query
    $sql = "SELECT m.*, v.nome 
            FROM movimentacoes m
            JOIN veiculos v ON m.veiculo_id = v.id
            WHERE 1=1";

    // filtros dinâmicos
    if (!empty($data_inicio)) {
        $sql .= " AND DATE(m.data_registro) >= '$data_inicio'";
    }

    if (!empty($data_fim)) {
        $sql .= " AND DATE(m.data_registro) <= '$data_fim'";
    }

    if (!empty($veiculo_id)) {
        $sql .= " AND m.veiculo_id = '$veiculo_id'";
    }

    // ordenação
    $sql .= " ORDER BY m.data_registro DESC";

    $movimentacoes = $conn->query($sql);

    // lista de veículos para o select
    $veiculosLista = $conn->query("SELECT id, nome FROM veiculos");

    include __DIR__ . '/../views/veiculos/relatorio.php';
}

if ($acao == "manutencao") {

    apenasAdmin();

    $id = $_GET['id'];

    // 🔥 BUSCA DADOS DO VEÍCULO
    $sql = "SELECT * FROM veiculos WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $veiculo = $result->fetch_assoc();

    include __DIR__ . '/../views/veiculos/manutencao.php';
}

if ($acao == "salvar_manutencao") {

    apenasAdmin();

    $id = $_POST['id'];
    $descricao = $_POST['descricao'];

    // 🔎 pega horas atuais
    $sql = "SELECT horas_trabalhadas FROM veiculos WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $veiculo = $result->fetch_assoc();

    $horas_atual = $veiculo['horas_trabalhadas'];

    // 📜 salva histórico da manutenção
    $sql = "INSERT INTO manutencoes (veiculo_id, descricao, horas_no_momento)
            VALUES (?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isi", $id, $descricao, $horas_atual);
    $stmt->execute();

    // 🔥 ATUALIZA O MARCO DA MANUTENÇÃO (ESSENCIAL)
    $sql = "UPDATE veiculos 
            SET ultima_manutencao = ?
            WHERE id=?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $horas_atual, $id);
    $stmt->execute();

    header("Location: index.php?modulo=veiculos&acao=listar");
    exit;
}

// Ação para atualizar veículo
if ($acao == "atualizar") {

    // 🔐 Apenas admin pode editar
    apenasAdmin();

    // Recebe dados do formulário
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $placa = strtoupper($_POST['placa']);

    // 🔎 Validação de placa
    if (!preg_match("/^[A-Z]{3}-?[0-9][A-Z0-9][0-9]{2}$/", $placa)) {

        echo "Placa inválida!";
        exit;
    }

    // 🔎 Verifica duplicidade ignorando o próprio veículo
    $sql = "SELECT id FROM veiculos WHERE placa = ? AND id != ?";

    $stmt = $conn->prepare($sql);

    // "s" = string (placa) | "i" = inteiro (id)
    $stmt->bind_param("si", $placa, $id);

    $stmt->execute();

    $result = $stmt->get_result();

    // Se encontrou outro veículo com mesma placa
    if ($result->num_rows > 0) {

        echo "Essa placa já está cadastrada!";
        exit;
    }

    // Atualiza os dados no banco
    $veiculo->atualizar($id, $nome, $placa);

    // Redireciona para listagem
    header("Location: index.php?modulo=veiculos&acao=listar");
    exit;
}