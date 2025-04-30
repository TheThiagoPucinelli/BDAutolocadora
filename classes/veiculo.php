<?php
// Importa o arquivo de conexão com o banco de dados
require_once __DIR__ . '/../db/conexao.php';

// Classe que representa um veículo
class Veiculo {
    // Atributos privados do veículo
    private $placa;
    private $marca;
    private $descricao;

    // Construtor que recebe placa, marca e descrição do veículo
    public function __construct($placa, $marca, $descricao) {
        $this->placa = $placa;
        $this->marca = $marca;
        $this->descricao = $descricao;
    }

    // Método que insere o veículo no banco de dados
    public function inserir($pdo) {
        // SQL para inserir um veículo com placa, marca e descrição
        $sql = "INSERT INTO tbveiculo (veiculo_placa, veiculo_marca, veiculo_descricao) VALUES (?, ?, ?)";
        
        // Prepara a query SQL
        $stmt = $pdo->prepare($sql);

        // Executa a query com os valores do veículo
        $stmt->execute([$this->placa, $this->marca, $this->descricao]);
    }

    // Método estático que lista todos os veículos cadastrados
    public static function listar($pdo) {
        // Executa uma consulta que retorna todos os veículos com suas respectivas marcas
        $stmt = $pdo->query(
            "SELECT v.veiculo_placa, m.marca_descricao, v.veiculo_descricao
             FROM tbveiculo v
             LEFT JOIN tbmarca m ON v.veiculo_marca = m.marca_codigo
             ORDER BY v.veiculo_placa"
        );

        // Retorna o resultado como array associativo
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
