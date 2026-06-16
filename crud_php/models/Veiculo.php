<?php

class Veiculo {

    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    // listar somente ativos
    public function listar() {
        return $this->conn->query(
            "SELECT * FROM veiculos WHERE ativo = 1"
        );
    }

    // criar veículo
    public function criar($nome, $placa, $numero_serie, $horas_trabalhadas, $horas_manutencao) {

        if (empty($placa)) $placa = null;
        if (empty($numero_serie)) $numero_serie = null;

        if ($horas_manutencao <= 0) {
            throw new Exception("Intervalo de manutenção inválido");
        }

        $stmt = $this->conn->prepare(
            "INSERT INTO veiculos 
            (nome, placa, numero_serie, horas_trabalhadas, horas_manutencao, ultima_manutencao, ativo)
            VALUES (?, ?, ?, ?, ?, ?, 1)"
        );

        $stmt->bind_param(
            "sssiii",
            $nome,
            $placa,
            $numero_serie,
            $horas_trabalhadas,
            $horas_manutencao,
            $horas_trabalhadas
        );

        try {
            $stmt->execute();
        } catch (mysqli_sql_exception $e) {
            throw $e;
        }
    }

    // inativar
    public function inativar($id, $motivo) {

        $stmt = $this->conn->prepare(
            "UPDATE veiculos 
             SET ativo = 0,
                 motivo_inativacao = ?,
                 data_inativacao = NOW()
             WHERE id = ?"
        );

        $stmt->bind_param("si", $motivo, $id);
        $stmt->execute();
    }

    // reativar (limpa histórico de inativação)
    public function reativar($id) {

        $stmt = $this->conn->prepare(
            "UPDATE veiculos 
             SET ativo = 1,
                 motivo_inativacao = NULL,
                 data_inativacao = NULL
             WHERE id = ?"
        );

        $stmt->bind_param("i", $id);
        $stmt->execute();
    }

    // buscar por id
    public function buscarPorId($id) {

        $stmt = $this->conn->prepare(
            "SELECT * FROM veiculos WHERE id = ?"
        );

        $stmt->bind_param("i", $id);
        $stmt->execute();

        return $stmt->get_result()->fetch_assoc();
    }

    // atualizar com validação
    public function atualizar($id, $nome, $placa) {

        // evita duplicidade de placa
        $check = $this->conn->prepare(
            "SELECT id FROM veiculos WHERE placa = ? AND id != ?"
        );

        $check->bind_param("si", $placa, $id);
        $check->execute();

        if ($check->get_result()->num_rows > 0) {
            throw new Exception("Placa já cadastrada em outro veículo!");
        }

        $stmt = $this->conn->prepare(
            "UPDATE veiculos SET nome=?, placa=? WHERE id=?"
        );

        $stmt->bind_param("ssi", $nome, $placa, $id);
        $stmt->execute();
    }

    // busca + paginação
    public function listarComBusca($busca, $limite, $offset) {

        $sql = "SELECT * FROM veiculos 
                WHERE ativo = 1
                AND (
                    nome LIKE ?
                    OR IFNULL(placa,'') LIKE ?
                    OR IFNULL(numero_serie,'') LIKE ?
                )
                LIMIT ? OFFSET ?";

        $stmt = $this->conn->prepare($sql);

        $busca = "%$busca%";

        $stmt->bind_param("sssii", $busca, $busca, $busca, $limite, $offset);
        $stmt->execute();

        return $stmt->get_result();
    }

    // total
    public function contar($busca) {

        $sql = "SELECT COUNT(*) total FROM veiculos 
                WHERE ativo = 1
                AND (
                    nome LIKE ?
                    OR IFNULL(placa,'') LIKE ?
                    OR IFNULL(numero_serie,'') LIKE ?
                )";

        $stmt = $this->conn->prepare($sql);

        $busca = "%$busca%";

        $stmt->bind_param("sss", $busca, $busca, $busca);
        $stmt->execute();

        return $stmt->get_result()->fetch_assoc()['total'];
    }

}