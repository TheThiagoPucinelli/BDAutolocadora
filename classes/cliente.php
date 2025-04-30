<?php
// Importa o arquivo de conexão com o banco de dados
require_once __DIR__ . '/../db/conexao.php';

// Define a classe Cliente
class Cliente {
    // Atributos privados do cliente
    private $cpf;
    private $nome;
    private $endereco;

    // Construtor que inicializa o objeto com CPF, nome e endereço
    public function __construct($cpf, $nome, $endereco) {
        $this->cpf = $cpf;
        $this->nome = $nome;
        $this->endereco = $endereco;
    }

    // Método que insere os dados do cliente no banco de dados
    public function inserir($pdo) {
        // Cria a instrução SQL com placeholders
        $sql = "INSERT INTO tbcliente (cliente_cpf, cliente_nome, cliente_endereco) VALUES (?, ?, ?)";
        
        // Prepara a instrução para execução
        $stmt = $pdo->prepare($sql);
        
        // Executa a instrução com os valores do cliente
        $stmt->execute([$this->cpf, $this->nome, $this->endereco]);
    }

    // Método estático que retorna a lista de todos os clientes cadastrados
    public static function listar($pdo) {
        // Executa a query para buscar todos os clientes ordenados por nome
        $stmt = $pdo->query("SELECT * FROM tbcliente ORDER BY cliente_nome");
        
        // Retorna os resultados como array associativo
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
