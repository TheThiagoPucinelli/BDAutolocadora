<?php
// Importa o arquivo de conexão com o banco de dados
require_once __DIR__ . '/../db/conexao.php';

// Classe que representa uma marca de veículo
class Marca {
    // Atributos privados: código e descrição da marca
    private $codigo;
    private $descricao;

    // Construtor que recebe a descrição e, opcionalmente, o código da marca
    public function __construct($descricao, $codigo = null) {
        $this->descricao = $descricao;
        $this->codigo = $codigo;
    }

    // Método que insere a marca no banco de dados
    public function inserir($pdo) {
        // SQL para inserir uma nova marca (o código é gerado automaticamente)
        $sql = "INSERT INTO tbmarca (marca_codigo, marca_descricao) VALUES (NULL, ?)";
        
        // Prepara a instrução SQL
        $stmt = $pdo->prepare($sql);
        
        // Executa a inserção passando a descrição como parâmetro
        $stmt->execute([$this->descricao]);
        
        // Retorna o ID da marca recém inserida
        return $pdo->lastInsertId();
    }

    // Método estático que lista todas as marcas cadastradas
    public static function listar($pdo) {
        // Executa a query SQL para selecionar todas as marcas ordenadas por descrição
        $stmt = $pdo->query("SELECT * FROM tbmarca ORDER BY marca_descricao");
        
        // Retorna os resultados como array associativo
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
