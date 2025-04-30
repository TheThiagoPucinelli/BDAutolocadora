<?php
// Conecta ao banco de dados
require 'db/conexao.php';
// Inclui as classes necessárias
require 'classes/Cliente.php';
require 'classes/Locacao.php';
require 'classes/Veiculo.php';
require 'classes/Marca.php';

// Consulta para obter locações
$sql_locacao = "SELECT l.locacao_codigo, l.locacao_data_inicio, l.locacao_data_fim, c.cliente_nome, v.veiculo_placa, v.veiculo_descricao, m.marca_descricao
                FROM tblocacao l
                JOIN tbcliente c ON l.locacao_cliente = c.cliente_cpf
                JOIN tbveiculo v ON l.locacao_veiculo = v.veiculo_placa
                JOIN tbmarca m ON v.veiculo_marca = m.marca_codigo";
$stmt_locacao = $pdo->query($sql_locacao);
$locacoes = $stmt_locacao->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Locações Cadastradas</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>Todas as Locações Cadastradas</h1>

    <!-- Tabela de locações com informações de clientes e veículos -->
    <table>
        <thead>
            <tr>
                <th>Código</th>
                <th>Cliente</th>
                <th>Veículo</th>
                <th>Marca</th>
                <th>Descrição do Veículo</th>
                <th>Data Início</th>
                <th>Data Fim</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($locacoes as $l): ?>
                <tr>
                    <td><?= $l['locacao_codigo'] ?></td>
                    <td><?= htmlspecialchars($l['cliente_nome']) ?></td>
                    <td><?= htmlspecialchars($l['veiculo_placa']) ?></td>
                    <td><?= htmlspecialchars($l['marca_descricao']) ?></td>
                    <td><?= htmlspecialchars($l['veiculo_descricao']) ?></td>
                    <td><?= htmlspecialchars($l['locacao_data_inicio']) ?></td>
                    <td><?= htmlspecialchars($l['locacao_data_fim']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</body>
</html>
