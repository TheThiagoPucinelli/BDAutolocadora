<?php
require_once __DIR__ . '/../db/conexao.php';

class Marca {
    private $codigo;
    private $descricao;

    public function __construct($descricao, $codigo = null) {
        $this->descricao = $descricao;
        $this->codigo = $codigo;
    }

    public function inserir($pdo) {
        $sql = "INSERT INTO tbmarca (marca_codigo, marca_descricao) VALUES (NULL, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$this->descricao]);
        return $pdo->lastInsertId();
    }

    public static function listar($pdo) {
        $stmt = $pdo->query("SELECT * FROM tbmarca ORDER BY marca_descricao");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}