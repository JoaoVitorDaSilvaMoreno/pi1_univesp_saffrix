<?php

class Usuario {

    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    // Listar todos
    public function listar() {
        return $this->conn->query("SELECT * FROM login");
    }

    // Criar usuário
    public function criar($usuario, $email, $senha, $nivel) {

    // Verifica duplicidade por usuário
    $check = $this->conn->prepare(
        "SELECT id FROM login WHERE usuario = ? OR email = ?"
    );
    $check->bind_param("ss", $usuario, $email);
    $check->execute();

    if ($check->get_result()->num_rows > 0) {
        throw new Exception("Usuário ou e-mail já cadastrado!");
    }

    // Hash da senha
    $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

    $stmt = $this->conn->prepare(
        "INSERT INTO login (usuario, email, senha, nivel)
         VALUES (?, ?, ?, ?)"
    );

    $stmt->bind_param("ssss", $usuario, $email, $senhaHash, $nivel);
    $stmt->execute();
    }

    // Deletar usuário
    public function deletar($id) {

        $stmt = $this->conn->prepare(
            "DELETE FROM login WHERE id=?"
        );
        $stmt->bind_param("i", $id);
        $stmt->execute();
    }

    // Atualizar usuário COM senha
    public function atualizar($id, $usuario, $senha, $nivel) {

        // Verifica duplicidade ignorando o próprio
        $check = $this->conn->prepare(
            "SELECT id FROM login WHERE usuario=? AND id!=?"
        );
        $check->bind_param("si", $usuario, $id);
        $check->execute();

        if ($check->get_result()->num_rows > 0) {
            throw new Exception("Nome de usuário já existe!");
        }

        // Hash da senha
        $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

        $stmt = $this->conn->prepare(
            "UPDATE login SET usuario=?, senha=?, nivel=? WHERE id=?"
        );
        $stmt->bind_param("sssi", $usuario, $senhaHash, $nivel, $id);
        $stmt->execute();
    }

    // Atualizar usuário SEM senha
    public function atualizarSemSenha($id, $usuario, $nivel) {

        $check = $this->conn->prepare(
            "SELECT id FROM login WHERE usuario=? AND id!=?"
        );
        $check->bind_param("si", $usuario, $id);
        $check->execute();

        if ($check->get_result()->num_rows > 0) {
            throw new Exception("Nome de usuário já existe!");
        }

        $stmt = $this->conn->prepare(
            "UPDATE login SET usuario=?, nivel=? WHERE id=?"
        );
        $stmt->bind_param("ssi", $usuario, $nivel, $id);
        $stmt->execute();
    }

    // Buscar por nome
    public function buscar($usuario) {

        $sql = "SELECT * FROM login WHERE usuario LIKE ?";
        $stmt = $this->conn->prepare($sql);

        $usuario = "%$usuario%";
        $stmt->bind_param("s", $usuario);
        $stmt->execute();

        return $stmt->get_result();
    }

    // Paginação
    public function listarPaginado($limite, $offset) {

        $stmt = $this->conn->prepare(
            "SELECT * FROM login LIMIT ? OFFSET ?"
        );
        $stmt->bind_param("ii", $limite, $offset);
        $stmt->execute();

        return $stmt->get_result();
    }

    // Contar total
    public function contarUsuarios() {

        $sql = "SELECT COUNT(*) as total FROM login";
        $result = $this->conn->query($sql);

        return $result->fetch_assoc()['total'];
    }
}