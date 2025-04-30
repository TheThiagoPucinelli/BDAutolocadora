<?php
// Inclui o arquivo de conexão com o banco de dados
require_once __DIR__ . '/../db/conexao.php';

// Classe que representa uma locação de veículo
class Locacao {
    // Atributos privados da locação
    private $veiculo;
    private $cliente;
    private $dataInicio;
    private $dataFim;

    // Construtor que inicializa os dados da locação
    public function __construct($veiculo, $cliente, $dataInicio, $dataFim) {
        $this->veiculo = $veiculo;
        $this->cliente = $cliente;
        $this->dataInicio = $dataInicio;
        $this->dataFim = $dataFim;
    }

    // Método que insere a locação no banco de dados
    public function inserir($pdo) {
        // Query SQL para inserir uma nova locação (o código é auto-incrementado)
        $sql = "INSERT INTO tblocacao (locacao_codigo, locacao_veiculo, locacao_cliente, locacao_data_inicio, locacao_data_fim)
                VALUES (NULL, ?, ?, ?, ?)";
        
        // Prepara a query
        $stmt = $pdo->prepare($sql);

        // Executa com os dados da instância
        $stmt->execute([$this->veiculo, $this->cliente, $this->dataInicio, $this->dataFim]);
    }

    // Método estático que lista todas as locações feitas
    public static function listarTodos($pdo) {
        // Executa uma consulta para obter informações de locações, clientes e veículos
        $stmt = $pdo->query(
            "SELECT l.locacao_codigo, v.veiculo_placa, c.cliente_nome, l.locacao_data_inicio, l.locacao_data_fim
             FROM tblocacao l
             JOIN tbcliente c ON l.locacao_cliente = c.cliente_cpf
             JOIN tbveiculo v ON l.locacao_veiculo = v.veiculo_placa
             ORDER BY l.locacao_codigo"
        );
        
        // Retorna os dados como array associativo
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Método que retorna os veículos locados e disponíveis na data atual
    public static function listarDisponiveisLocados($pdo) {
        // Busca os veículos que estão locados no momento atual
        $stmtL = $pdo->query(
            "SELECT DISTINCT v.veiculo_placa, m.marca_descricao, v.veiculo_descricao
             FROM tblocacao l
             JOIN tbveiculo v ON l.locacao_veiculo = v.veiculo_placa
             JOIN tbmarca m ON v.veiculo_marca = m.marca_codigo
             WHERE CURDATE() BETWEEN l.locacao_data_inicio AND l.locacao_data_fim"
        );

        // Veículos atualmente locados
        $locados = $stmtL->fetchAll(PDO::FETCH_ASSOC);
        
        // Obtém todos os veículos cadastrados no sistema
        $todos = Veiculo::listar($pdo);

        // Filtra os veículos disponíveis (ou seja, que não estão locados)
        $disponiveis = array_filter($todos, function($v) use ($locados) {
            foreach ($locados as $l) {
                if ($l['veiculo_placa'] === $v['veiculo_placa']) {
                    return false; // Está locado
                }
            }
            return true; // Está disponível
        });

        // Retorna os dois conjuntos: locados e disponíveis
        return ['locados' => $locados, 'disponiveis' => $disponiveis];
    }
}
