<?php
require_once __DIR__ . '/../db/conexao.php';

class Cliente {
    private $cpf;
    private $nome;
    private $endereco;

    public function __construct($cpf, $nome, $endereco) {
        $this->cpf = $cpf;
        $this->nome = $nome;
        $this->endereco = $endereco;
    }

    public function inserir($pdo) {
        $sql = "INSERT INTO tbcliente (cliente_cpf, cliente_nome, cliente_endereco) VALUES (?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$this->cpf, $this->nome, $this->endereco]);
    }

    public static function listar($pdo) {
        $stmt = $pdo->query("SELECT * FROM tbcliente ORDER BY cliente_nome");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}