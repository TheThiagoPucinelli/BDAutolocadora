<?php
require_once __DIR__ . '/../db/conexao.php';

class Veiculo {
    private $placa;
    private $marca;
    private $descricao;

    public function __construct($placa, $marca, $descricao) {
        $this->placa = $placa;
        $this->marca = $marca;
        $this->descricao = $descricao;
    }

    public function inserir($pdo) {
        $sql = "INSERT INTO tbveiculo (veiculo_placa, veiculo_marca, veiculo_descricao) VALUES (?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$this->placa, $this->marca, $this->descricao]);
    }

    public static function listar($pdo) {
        $stmt = $pdo->query(
            "SELECT v.veiculo_placa, m.marca_descricao, v.veiculo_descricao
             FROM tbveiculo v
             LEFT JOIN tbmarca m ON v.veiculo_marca = m.marca_codigo
             ORDER BY v.veiculo_placa"
        );
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}