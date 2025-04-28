<?php
require_once __DIR__ . '/../db/conexao.php';

class Locacao {
    private $veiculo;
    private $cliente;
    private $dataInicio;
    private $dataFim;

    public function __construct($veiculo, $cliente, $dataInicio, $dataFim) {
        $this->veiculo = $veiculo;
        $this->cliente = $cliente;
        $this->dataInicio = $dataInicio;
        $this->dataFim = $dataFim;
    }

    public function inserir($pdo) {
        $sql = "INSERT INTO tblocacao (locacao_codigo, locacao_veiculo, locacao_cliente, locacao_data_inicio, locacao_data_fim)
                VALUES (NULL, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$this->veiculo, $this->cliente, $this->dataInicio, $this->dataFim]);
    }

    public static function listarTodos($pdo) {
        $stmt = $pdo->query(
            "SELECT l.locacao_codigo, v.veiculo_placa, c.cliente_nome, l.locacao_data_inicio, l.locacao_data_fim
             FROM tblocacao l
             JOIN tbcliente c ON l.locacao_cliente = c.cliente_cpf
             JOIN tbveiculo v ON l.locacao_veiculo = v.veiculo_placa
             ORDER BY l.locacao_codigo"
        );
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function listarDisponiveisLocados($pdo) {
   
        $stmtL = $pdo->query(
            "SELECT DISTINCT v.veiculo_placa, m.marca_descricao, v.veiculo_descricao
             FROM tblocacao l
             JOIN tbveiculo v ON l.locacao_veiculo = v.veiculo_placa
             JOIN tbmarca m ON v.veiculo_marca = m.marca_codigo
             WHERE CURDATE() BETWEEN l.locacao_data_inicio AND l.locacao_data_fim"
        );
        $locados = $stmtL->fetchAll(PDO::FETCH_ASSOC);
        
     
        $todos = Veiculo::listar($pdo);

      
        $disponiveis = array_filter($todos, function($v) use ($locados) {
            foreach ($locados as $l) {
                if ($l['veiculo_placa'] === $v['veiculo_placa']) {
                    return false;
                }
            }
            return true;
        });

        return ['locados' => $locados, 'disponiveis' => $disponiveis];
    }
}