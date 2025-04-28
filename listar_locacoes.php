<?php
require 'db/conexao.php'; 
require 'classes/locacao.php'; 
require 'classes/cliente.php'; 
require 'classes/veiculo.php'; 

$sql = "SELECT l.locacao_codigo, l.locacao_data_inicio, l.locacao_data_fim, c.cliente_nome, v.veiculo_placa
        FROM tblocacao l
        JOIN tbcliente c ON l.locacao_cliente = c.cliente_cpf
        JOIN tbveiculo v ON l.locacao_veiculo = v.veiculo_placa";
$stmt = $pdo->query($sql);
$locacoes = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
    <h1>Locações Cadastradas</h1>

    <table>
        <thead>
            <tr>
                <th>Código</th>
                <th>Veículo</th>
                <th>Cliente</th>
                <th>Data Início</th>
                <th>Data Fim</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($locacoes as $l): ?>
                <tr>
                    <td><?= $l['locacao_codigo'] ?></td>
                    <td><?= $l['veiculo_placa'] ?></td>
                    <td><?= $l['cliente_nome'] ?></td>
                    <td><?= $l['locacao_data_inicio'] ?></td>
                    <td><?= $l['locacao_data_fim'] ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
